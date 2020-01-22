<?php
declare(strict_types=1);

namespace Doxadoxa;

use Doxadoxa\Generator\Generator;

/**
 * Class Phrase
 * @package Doxadoxa
 */
class Phrase
{
    private static $instance = null;

    private function __construct()
    {
        //
    }

    /**
     * @param string $phrase
     * @return string
     * @throws Exceptions\PhraseCantBeEmptyException
     * @throws Exceptions\WordListNotFoundException
     * @throws Exceptions\WordListNotUniqueException
     * @throws Exceptions\WrongWordListSizeException
     */
    public static function generate( string $phrase ): string
    {
        return implode(" ", static::generator()->generate( $phrase ) );
    }

    /**
     * @param string $words
     * @return string
     * @throws Exceptions\WordListNotFoundException
     * @throws Exceptions\WordListNotUniqueException
     * @throws Exceptions\WrongWordListSizeException
     * @throws Exceptions\WordsNotExistException
     */
    public static function decode( string $words ): string
    {
        return static::generator()->decode( explode(' ', $words ) );
    }

    /**
     * @throws Exceptions\WordListNotFoundException
     * @throws Exceptions\WordListNotUniqueException
     * @throws Exceptions\WrongWordListSizeException
     */
    private static function generator(): Generator
    {
        if ( !static::$instance ) {
            static::$instance = new Generator(
                "wordlist.txt"
            );
        }

        return static::$instance;
    }
}
