<?php
declare(strict_types=1);

namespace Doxadoxa\Exceptions;

use Exception;

class WordListNotUniqueException extends Exception
{
    protected $message = "Word list not unique";
}
