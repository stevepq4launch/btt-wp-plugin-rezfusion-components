<?php

namespace Rezfusion\TestBuilder;

class TestBuilderParametersHolder
{
    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var string[]
     */
    private $use = [];

    /**
     * @var string
     */
    private $namespace = '';

    /**
     * @var string
     */
    private $className = '';

    /**
     * @var string
     */
    private $extends = '';

    /**
     * @var array
     */
    private $customCallbacks = [];

    /**
     * @var array
     */
    private $classPreContent = [];

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of file
     *
     * @return  string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @param  string  $file
     *
     * @return  self
     */
    public function setFile(string $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of use
     *
     * @return  string[]
     */
    public function getUse()
    {
        return $this->use;
    }

    /**
     * Set the value of use
     *
     * @param  string[]  $use
     *
     * @return  self
     */
    public function setUse(array $use = [])
    {
        $this->use = $use;

        return $this;
    }

    /**
     * Get the value of namespace
     *
     * @return  string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the value of namespace
     *
     * @param  string  $namespace
     *
     * @return  self
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get the value of className
     *
     * @return  string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set the value of className
     *
     * @param  string  $className
     *
     * @return  self
     */
    public function setClassName(string $className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get the value of extends
     *
     * @return  string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * Set the value of extends
     *
     * @param  string  $extends
     *
     * @return  self
     */
    public function setExtends(string $extends)
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * Get the value of customCallbacks
     *
     * @return  array
     */
    public function getCustomCallbacks()
    {
        return $this->customCallbacks;
    }

    /**
     * Set the value of customCallbacks
     *
     * @param  array  $customCallbacks
     *
     * @return  self
     */
    public function setCustomCallbacks(array $customCallbacks)
    {
        $this->customCallbacks = $customCallbacks;

        return $this;
    }

    /**
     * Get the value of classPreContent
     *
     * @return  array
     */
    public function getClassPreContent()
    {
        return $this->classPreContent;
    }

    /**
     * Set the value of classPreContent
     *
     * @param  array  $classPreContent
     *
     * @return  self
     */
    public function setClassPreContent(array $classPreContent)
    {
        $this->classPreContent = $classPreContent;

        return $this;
    }
}
