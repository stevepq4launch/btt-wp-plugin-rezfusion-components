<?php

namespace Rezfusion\Client;

use RuntimeException;
use SebastianBergmann\Environment\Runtime;
use stdClass;

class FileCache extends Cache
{
    /**
     * @inheritdoc
     */
    protected $mode = Cache::MODE_READ | Cache::MODE_WRITE;

    /**
     * @var string
     */
    private $filePath = '';

    private $data;

    /**
     * @param string $filePath
     * 
     * @return bool
     */
    private function validateFilePath($filePath = ''): bool
    {
        return !empty($filePath) && file_exists($filePath);
    }

    private function loadDataFromFile($filePath = '')
    {
        $data = json_decode(file_get_contents($filePath));
        return !empty($data) ? $data : new stdClass;
    }

    private function reloadData(): void
    {
        $this->data = $this->loadDataFromFile($this->filePath);
    }

    private function saveData(): void
    {
        file_put_contents($this->filePath, json_encode($this->data));
    }

    public function __construct($filePath = '')
    {
        $this->filePath = $filePath;
        if ($this->validateFilePath($this->filePath) === false) {
            throw new RuntimeException('Invalid file.');
        }
        $this->reloadData();
    }

    public function getMode(): int
    {
        return static::MODE_READ | static::MODE_WRITE;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return $this->data->$key;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $data)
    {
        if ($this->has($key)) {
            throw new RuntimeException(sprintf('Key %s was already saved.', $key));
        }
        $this->data->$key = $data;
        $this->saveData();
        $this->reloadData();
        return $this->data->$key;
    }

    /**
     * @inheritdoc
     */
    public function has($key)
    {
        return isset($this->data->$key);
    }

    /**
     * @inheritdoc
     */
    public function delete($key)
    {
        if (isset($this->data->$key)) {
            unset($this->data->$key);
            $this->saveData();
            $this->reloadData();
            return true;
        }
        return false;
    }
}
