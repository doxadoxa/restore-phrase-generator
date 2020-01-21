<?php
declare(strict_types=1);

namespace Doxadoxa\Exceptions;

use Exception;

class PhraseCantBeEmptyException extends Exception
{
    protected $message = "Phrase can't be empty.";
}
