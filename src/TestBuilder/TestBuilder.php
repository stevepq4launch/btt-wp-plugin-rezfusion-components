<?php

namespace Rezfusion\TestBuilder;

/**
 * @file Builder for creating tests class.
 */
class TestBuilder
{
    /**
     * @var TestBuilderParametersHolder
     */
    private $ParametersHolder;

    /**
     * @return string
     */
    private function renderContent(): string
    {
        $content = "<?php\n\n"
            . "/**\n"
            . " * @file " . $this->ParametersHolder->getDescription() . "\n"
            . " */\n"
            . "\n";

        $namespace = $this->ParametersHolder->getNamespace();
        if (!empty($namespace)) {
            $content .= "namespace " . $namespace . ";\n\n";
        };

        $use = $this->ParametersHolder->getUse();
        if (!empty($use) && is_array($use) && count($use)) {
            foreach ($use as $use_) {
                $content .= "use " . $use_ . ";\n";
            }
            $content .= "\n";
        }

        $content .= "class " . $this->ParametersHolder->getClassName();
        $extends = $this->ParametersHolder->getExtends();
        if (!empty($extends)) {
            $content .= " extends " . $extends;
        }

        $content .= "\n{\n";

        $classPreContent = $this->ParametersHolder->getClassPreContent();
        if (is_array($classPreContent) && count($classPreContent)) {
            foreach ($classPreContent as $classPreContent_) {
                $content .= $classPreContent_ . "\n";
            }
        }

        $customCallbacks = $this->ParametersHolder->getCustomCallbacks();
        if (is_array($customCallbacks) && count($customCallbacks)) {
            foreach ($customCallbacks as $customCallback) {
                $content .= $this->renderCustomCallbacks(...$customCallback);
            }
        }

        $content .= "}\n";

        return $content;
    }

    /**
     * @return self
     */
    private function outputToFile(): self
    {
        if (empty($this->ParametersHolder->getFile()))
            throw new \Error("Invalid file.");
        file_put_contents($this->ParametersHolder->getFile(), $this->renderContent());
        return $this;
    }

    /**
     * Renders arguments for function.
     * @param mixed[] $args
     * 
     * @return string
     */
    public function renderArgumentsString(array $args = []): string
    {
        $content = [];
        foreach ($args as $argument) {
            if (is_string($argument)) {
                $content[] = "'$argument'";
            } else {
                $content[] = "null";
            }
        }
        return join(', ', $content);
    }

    /**
     * @param string[] $use
     * 
     * @return self
     */
    public function withUse(array $use = []): self
    {
        $current = $this->ParametersHolder->getUse();
        foreach ($use as $use_) {
            $current[] = $use_;
        }
        $this->ParametersHolder->setUse($current);
        return $this;
    }

    /**
     * @param string $className
     * 
     * @return self
     */
    public function withClassName($className = ''): self
    {
        $this->ParametersHolder->setClassName($className);
        return $this;
    }

    /**
     * @param string $extends
     * 
     * @return self
     */
    public function withExtends($extends = ''): self
    {
        $this->ParametersHolder->setExtends($extends);
        return $this;
    }

    /**
     * @param string $namespace
     * 
     * @return self
     */
    public function withNamespace($namespace =  ''): self
    {
        $this->ParametersHolder->setNamespace($namespace);
        return $this;
    }

    /**
     * @return self
     */
    public function reset(): self
    {
        $this->ParametersHolder = null;
        $this->ParametersHolder = new TestBuilderParametersHolder;
        return $this;
    }

    /**
     * @param string $description
     * 
     * @return self
     */
    public function withDescription($description = ''): self
    {
        $this->ParametersHolder->setDescription($description);
        return $this;
    }

    /**
     * @param string $file
     * 
     * @return self
     */
    public function withOutputToFile($file = ''): self
    {
        $this->ParametersHolder->setFile($file);
        return $this;
    }

    /**
     * @return string
     */
    private function renderCustomCallbacks(array $data = [], callable $callback): string
    {
        $content = '';
        foreach ($data as $datum) {
            $content .= $callback(...$datum);
        }
        return $content;
    }

    /**
     * @param array $data
     * @param callable $callback
     * 
     * @return self
     */
    public function withCustomCallback(array $data = [], callable $callback): self
    {
        $current = $this->ParametersHolder->getCustomCallbacks();
        $current[] = [$data, $callback];
        $this->ParametersHolder->setCustomCallbacks($current);
        return $this;
    }

    /**
     * @return self
     */
    public function build(): self
    {
        if (!empty($this->ParametersHolder->getFile())) {
            $this->outputToFile();
        }
        $this->reset();
        return $this;
    }

    /**
     * @param string $classPreContent
     * 
     * @return self
     */
    public function withClassPreContent($classPreContent = ''): self
    {
        $current = $this->ParametersHolder->getClassPreContent();
        $current[] = $classPreContent;
        $this->ParametersHolder->setClassPreContent($current);
        return $this;
    }

    /**
     * @param string $name
     * @param string $content
     * 
     * @return string
     */
    public function renderTestMethod($name = '', $content = ''): string
    {
        if (is_array($content)) {
            $content = join("\n        ", $content);
        }
        return "    public function test" . $name . "()\n    {\n        $content\n    }\n\n";
    }
}
