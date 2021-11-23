<?php

namespace Rezfusion;

use InvalidArgumentException;
use Rezfusion\SessionHandler\SessionHandlerInterface;

class PostRecentVisits
{

    /**
     * @var string
     */
    const META_KEY = 'recent_visits_data';

    /**
     * @var string
     */
    const RECENT_VISITS_COUNT_META_KEY = 'recent_visits_count';

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @var int
     */
    protected $daysThreshold;

    /**
     * @var SessionHandlerInterface
     */
    protected $SessionHandler;

    /**
     * @return string
     */
    protected function metaKey()
    {
        return static::META_KEY;
    }

    /**
     * @return string
     */
    protected function recentVisitsCountMetaKey()
    {
        return static::RECENT_VISITS_COUNT_META_KEY;
    }

    /**
     * @param int $daysThreshold
     * @param SessionHandlerInterface $SessionHandler
     */
    public function __construct($daysThreshold, SessionHandlerInterface $SessionHandler)
    {
        $this->SessionHandler = $SessionHandler;
        $this->daysThreshold = $daysThreshold;
    }

    /**
     * Get recent visitors count for post by it's id.
     * 
     * @param int $postId
     * 
     * @return int
     */
    public function getRecentVisitsCount($postId)
    {
        if (empty($postId))
            throw new InvalidArgumentException('Invalid post ID.');
        return get_post_meta($postId, static::RECENT_VISITS_COUNT_META_KEY, true);
    }

    /**
     * Get valid key for current request.
     * 
     * @return string
     */
    protected function getKey()
    {
        if (empty($key = $this->SessionHandler->getSessionId())) {
            $this->SessionHandler->startSession();
            $key = $this->SessionHandler->getSessionId();
        }
        return $key;
    }

    /**
     * Get "visits" data for post by it's id.
     * 
     * @param int $postId
     * 
     * @return array
     */
    protected function getData($postId)
    {
        if (!array_key_exists($postId, $this->cache) && is_array($data = get_post_meta($postId, $this->metaKey(), true)))
            $this->cache[$postId] = $data;
        return (isset($this->cache[$postId]) && is_array($this->cache[$postId])) ? $this->cache[$postId] : [];
    }

    /**
     * Filter array of valid items.
     * 
     * @param array $data
     * 
     * @return array
     */
    protected function filterValidItems(array $data = [])
    {
        $time = strtotime(date("Y-m-d 00:00:00", strtotime("-" . (int) $this->daysThreshold . " day")));
        $filteredData = array_filter($data, function ($date) use ($time) {
            return strtotime($date) > $time;
        });
        return $filteredData ?: [];
    }

    /**
     * Reset whole cache or for specific post.
     * 
     * @param int|null $postId
     */
    public function resetCache($postId = null)
    {
        if (!empty($postId)) {
            if (isset($this->cache[$postId]))
                unset($this->cache[$postId]);
        } else {
            $this->cache = [];
        }
    }

    /**
     * Update count of recent visits for post.
     * 
     * @param mixed $postId
     * @param mixed $recentVisitsCount
     * @throws InvalidArgumentException
     * @return int|bool
     */
    protected function updateRecentVisitsCount($postId, $recentVisitsCount)
    {
        if (empty($postId))
            throw new InvalidArgumentException('Invalid post ID.');
        return update_post_meta($postId, $this->recentVisitsCountMetaKey(), $recentVisitsCount);
    }

    /**
     * Update visits information for postId.
     * 
     * @param int $postId
     */
    public function update($postId)
    {
        $key = $this->getKey();

        if (empty($key))
            return;

        $metaKey = $this->metaKey();
        $visits = $this->getData($postId);
        $oldVisits = [];
        $update = false;

        if ($visits) {
            $update = true;
            $oldVisits = $visits;
            $visits = $this->filterValidItems($visits);
        }

        if (!isset($visits[$key]))
            $visits[$key] = date('Y-m-d H:i:s');

        $update === true
            ? update_post_meta($postId, $metaKey, $visits, $oldVisits)
            : add_post_meta($postId, $metaKey, $visits);

        $this->updateRecentVisitsCount($postId, count($visits));
    }
}
