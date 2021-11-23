<?php

namespace Rezfusion\Validator;

interface ValidatorInterface
{
    public function validate($validatable): bool;
    public function getErrors(): array;
}
