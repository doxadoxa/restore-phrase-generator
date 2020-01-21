<?php
declare(strict_types=1);

namespace Doxadoxa\Generator;

use ArrayAccess;
use Doxadoxa\Exceptions\MethodNotAllowedException;
use Doxadoxa\Exceptions\WordListNotUniqueException;
use Doxadoxa\Exceptions\WrongWordListSizeException;

class WordList implements ArrayAccess
{
    public const WORDS_COUNT = 2048;

    /** @var array */
    private $list;

    /**
     * WordList constructor.
     * @param string $wordList
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function __construct( string $wordList )
    {
        $this->parse( $wordList );
    }

    /**
     * @param string $wordList
     * @throws WrongWordListSizeException
     * @throws WordListNotUniqueException
     */
    private function parse( string $wordList )
    {
        $this->list = explode(PHP_EOL, $wordList );

        if ( count( $this->list ) != self::WORDS_COUNT ) {
            throw new WrongWordListSizeException();
        }

        if ( !$this->isUnique( $this->list ) ) {
            throw new WordListNotUniqueException();
        }
    }

    /**
     * @param array $words
     * @return bool
     */
    private function isUnique( array $words )
    {
        return count( array_flip( $words ) ) == self::WORDS_COUNT;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists( $offset )
    {
        return isset( $this->list[ $offset ] );
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->list[ $offset ];
    }

    /**
     * @inheritDoc
     * @throws MethodNotAllowedException
     */
    public function offsetSet($offset, $value)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * @inheritDoc
     * @throws MethodNotAllowedException
     */
    public function offsetUnset($offset)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * @return array
     */
    public function flip(): array
    {
        return array_flip( $this->list );
    }

    /**
     * @param array $words
     * @return array|null
     */
    public function notExistedWordList( array $words ): ?array
    {
        $flip = $this->flip();
        $result = [];

        foreach( $words as $word ) {
            if ( !isset( $flip[ $word] ) ) {
                $result[] = $word;
            }
        }

        return empty( $result ) ? null : $result;
    }

    /**
     * @param string $word
     * @return string|null
     */
    public function replace( string $word ): ?string
    {
        $max = 0;
        $result = null;

        foreach( $this->list as $w ) {
            if ( ( $similarity = similar_text( $word, $w ) ) > $max ) {
                $max = $similarity;
                $result = $w;
            }
        }

        return $result;
    }
}
