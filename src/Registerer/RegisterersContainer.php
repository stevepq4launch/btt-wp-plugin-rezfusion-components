<?php

namespace Rezfusion\Registerer;

class RegisterersContainer
{

    /**
     * @var RegistererInterface[]
     */
    private $registerers;

    /**
     * @param RegistererInterface[] $registerers
     */
    public function __construct(array $registerers = [])
    {
        $this->registerers = $registerers;
    }

    /**
     * @return RegistererInterface[]
     */
    public function getAll(): array
    {
        return $this->registerers;
    }

    /**
     * Find registerer by name.
     * @param string $name
     * 
     * @return RegistererInterface|null
     */
    public function find($name = '')
    {
        foreach ($this->registerers as $Registerer) {
            if (RegistererNameGetter::get($Registerer) === $name) {
                return $Registerer;
            }
        }
        return null;
    }
}
