<?php
declare(strict_types=1);

namespace Doxadoxa\Exceptions;

use Exception;

class WordListNotFoundException extends Exception
{
    protected $message = "Word list file not found.";
}
