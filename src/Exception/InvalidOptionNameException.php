<?php

namespace Rezfusion\Exception;

use Exception;

class InvalidOptionNameException extends Exception
{
    protected $message = "Option name is invalid.";
}
