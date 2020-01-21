<?php
declare(strict_types=1);

namespace Doxadoxa\Generator;

use Doxadoxa\Exceptions\PhraseCantBeEmptyException;
use Doxadoxa\Exceptions\WordListNotFoundException;
use Doxadoxa\Exceptions\WordListNotUniqueException;
use Doxadoxa\Exceptions\WordsNotExistException;
use Doxadoxa\Exceptions\WrongWordListSizeException;

/**
 * Class Generator
 * @package Doxadoxa\Generator
 */
class Generator
{
    /** @var WordList */
    private $wordList;

    /**
     * Generator constructor.
     * @param string $file
     * @throws WordListNotFoundException
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function __construct( string $file )
    {
        if ( !file_exists( $file ) ) {
            throw new WordListNotFoundException();
        }

        $this->wordList = new WordList(
            file_get_contents( $file )
        );
    }

    /**
     * @param string $phrase
     * @return array
     * @throws PhraseCantBeEmptyException
     */
    public function generate( string $phrase ): array
    {
        if ( strlen( $phrase ) == 0 ) {
            throw new PhraseCantBeEmptyException();
        }

        $bin = implode('', array_map(function( string $char ) {
            return str_pad( decbin( ord( $char ) ), 8, '0', STR_PAD_LEFT );
        }, str_split( $phrase ) ) );

        $padding = (strlen( $bin ) - strlen( $bin )%11 + 11 );
        $bin = str_pad( $bin, $padding, "0", STR_PAD_LEFT );

        $numbers = array_map(function( string $bin ) {
            return bindec( $bin );
        }, str_split( $bin, 11 ) );

        return array_map( function( $number ) {
            return $this->wordList[ $number ];
        }, $numbers );
    }

    /**
     * @param array $words
     * @return string
     * @throws WordsNotExistException
     */
    public function decode( array $words ): string
    {
        if ( $notExists = $this->wordList->notExistedWordList( $words ) ) {
            throw new WordsNotExistException( $notExists );
        }

        $inverse = $this->wordList->flip();

        $numbers = array_map( function( string $word ) use ( $inverse ) {
            return str_pad( decbin( $inverse[ $word ] ), 11, '0', STR_PAD_LEFT );
        }, $words );

        $payload = implode('', $numbers);
        $payload = substr( $payload, strlen( $payload ) % 8 );

        $symbols = array_map( function( string $symbol ) {
            return chr( bindec( $symbol ) );
        }, str_split( $payload, 8 ) );

        return implode( '', $symbols );
    }

    /**
     * @return WordList
     */
    public function getWordList(): WordList
    {
        return $this->wordList;
    }
}
