<?php

namespace Rezfusion\Helper;

use InvalidArgumentException;

/**
 * Helper for registering styles and scripts.
 */
class Registerer
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
     * Prepare name for file.
     * @param string $file
     * 
     * @return string
     */
    protected function prepareName($file = ''): string
    {
        return str_replace('.js', '-script', str_replace('.css', '-style', $file));
    }

    /**
     * Validate type of file to be registered.
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
     */
    protected function throwInvalidRegistererTypeException()
    {
        throw new InvalidArgumentException(__CLASS__ . ": Invalid registerer type.");
    }

    /**
     * Prepare URL for file.
     * @param string $file
     * @param string $type
     * 
     * @return string
     */
    protected function prepareFileURL($file = '', $type = ''): string
    {
        if ($this->validateType($type) === false)
            $this->throwInvalidRegistererTypeException();
        $dir = ($type === static::script()) ? 'js' : 'css';
        $path = plugin_dir_url(REZFUSION_PLUGIN) . '/assets/' . $dir . '/' . $file;
        return $path;
    }

    /**
     * Handle script/style file.
     * @param string $file
     * @param string $type
     * 
     * @return void
     */
    protected function handle($file = '', $type = ''): void
    {
        if ($this->validateType($type) === false)
            $this->throwInvalidRegistererTypeException();
        $name = $this->prepareName($file);
        $path = $this->prepareFileURL($file, $type);
        if (empty($name) || empty($path))
            return;
        if ($type === static::style()) {
            wp_register_style($name, $path);
            wp_enqueue_style($name, $path);
        } else if ($type === static::script()) {
            wp_register_script($name, $path, "", "", true);
            wp_enqueue_script($name);
        }
    }

    /**
     * Handle style file.
     * @param string $file
     * 
     * @return void
     */
    public function handleStyle($file = ''): void
    {
        $this->handle($file, static::style());
    }

    /**
     * Handle script file.
     * @param string $file
     * 
     * @return void
     */
    public function handleScript($file = ''): void
    {
        $this->handle($file, static::script());
    }
}
