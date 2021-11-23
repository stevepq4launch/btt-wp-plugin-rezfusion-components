<?php

namespace Rezfusion\Helper;

use InvalidArgumentException;

/**
 * Helper for registering styles and scripts.
 */
class AssetsRegisterer implements AssetsRegistererInterface
{

    /**
     * @var string
     */
    const SCRIPT_TYPE = 'script';

    /**
     * @var string
     */
    const STYLE_TYPE = 'style';

    /**
     * @return string
     */
    public static function script(): string
    {
        return static::SCRIPT_TYPE;
    }

    /**
     * @return string
     */
    public static function style(): string
    {
        return static::STYLE_TYPE;
    }

    /**
     * Prepare name for source.
     * @param string $source
     * 
     * @return string
     */
    protected function prepareName($source = ''): string
    {
        return str_replace('.js', '-script', str_replace('.css', '-style', $source));
    }

    /**
     * Validate type of source to be registered.
     * @param string $type
     * 
     * @return bool
     */
    protected function validateType($type = ''): bool
    {
        return ($type === static::script() || $type === static::style());
    }

    /**
     * Throw exception for invalid type.
     * @throws InvalidArgumentException
     * 
     * @return void
     */
    protected function throwInvalidRegistererTypeException(): void
    {
        throw new InvalidArgumentException(__CLASS__ . ": Invalid registerer type.");
    }

    /**
     * Prepare URL for source.
     * @param string $source
     * @param string $type
     * 
     * @return string
     */
    protected function prepareSourceURL($source = '', $type = ''): string
    {
        if ($this->validateType($type) === false)
            $this->throwInvalidRegistererTypeException();
        $dir = ($type === static::script()) ? 'js' : 'css';
        $path = plugin_dir_url(REZFUSION_PLUGIN) . '/assets/' . $dir . '/' . $source;
        return $path;
    }

    /**
     * Handle script or style source.
     * @param string $source
     * @param string $type
     * @param string[] $dependencies
     * @param string|bool|null $version
     * @param bool $inFooter
     * @param string $media
     * 
     * @return void
     */
    protected function handle($handle = '', $source = '', $type = '', $dependencies = [], $version = false, $inFooter = true, $media = 'all'): string
    {
        if ($this->validateType($type) === false)
            $this->throwInvalidRegistererTypeException();
        if (empty($handle))
            throw new \Error("Handle is invalid.");
        if (empty($source))
            throw new \Error("Source is invalid.");
        if ($type === static::style()) {
            wp_register_style($handle, $source, $dependencies, $version, $media);
            wp_enqueue_style($handle);
        } else if ($type === static::script()) {
            wp_register_script($handle, $source, $dependencies, $version, $inFooter);
            wp_enqueue_script($handle);
        } else {
            throw new \Error("Invalid source type.");
        }
        return $handle;
    }

    /**
     * Handle style source.
     * @param string $source
     * @param string[] $dependencies
     * @param string|bool|null $version
     * @param string $media
     * 
     * @return void
     */
    public function handleStyle($source = '', array $dependencies = [], $version = false, $media = 'all'): string
    {
        return $this->handle(
            $this->prepareName($source),
            $this->prepareSourceURL($source, static::style()),
            static::style(),
            $dependencies,
            $version,
            false,
            $media
        );
    }

    /**
     * Handle script source.
     * @param string $source
     * @param string[] $dependencies
     * @param string|bool|null $version
     * @param bool $inFooter
     * 
     * @return void
     */
    public function handleScript($source = '', array $dependencies = [], $version = false, $inFooter = false): string
    {
        return $this->handle(
            $this->prepareName($source),
            $this->prepareSourceURL($source, static::script()),
            static::script(),
            $dependencies,
            $version,
            $inFooter
        );
    }

    /**
     * Prepares name for script URL.
     * @param string $url
     * 
     * @return string
     */
    protected function prepareURL_Name($url = ''): string
    {
        return preg_replace(['/http(s):\/\//', '/\.|\//'], ['', '-'], $url);
    }

    /**
     * Handle script URL.
     * @param string $source
     * @param string[] $dependencies
     * @param string|bool|null $version
     * @param bool $inFooter
     * 
     * @return void
     */
    public function handleScriptURL($source = '', $dependencies = [], $version = false, $inFooter = false): string
    {
        return $this->handle(
            $this->prepareURL_Name($source),
            $source,
            static::script(),
            $dependencies,
            $version,
            $inFooter
        );
    }

    /**
     * Handle style URL.
     * @param string $source
     * @param string[] $dependencies
     * @param string|bool|null $version
     * @param string $media
     * 
     * @return void
     */
    public function handleStyleURL($source = '', $dependencies = [], $version = false, $media = 'all'): string
    {
        return $this->handle(
            $this->prepareURL_Name($source),
            $source,
            static::style(),
            $dependencies,
            $version,
            false,
            $media
        );
    }
}
