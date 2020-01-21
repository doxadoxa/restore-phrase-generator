<?php
declare(strict_types=1);

namespace Doxadoxa\Exceptions;

use Exception;
use Throwable;

class WordsNotExistException extends Exception
{
    protected $message = "This words not found in wordlist: %s";

    public function __construct( array $notExists, $code = 0, Throwable $previous = null)
    {
        parent::__construct( sprintf( $this->message, implode(", ", $notExists ) ), $code, $previous);
    }
}
