<?php
declare(strict_types=1);

namespace Doxadoxa\Exceptions;

use Exception;

class WrongWordListSizeException extends Exception
{
    protected $message = "File must contain 2048 line of words.";
}
