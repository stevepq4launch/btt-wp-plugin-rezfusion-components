<?php

namespace Rezfusion\Entity;

interface EntityInterface
{
    public function setId($id);
    public function getId();
    public function toArray();
}
