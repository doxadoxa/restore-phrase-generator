<?php
declare(strict_types=1);

use Doxadoxa\Exceptions\MethodNotAllowedException;
use Doxadoxa\Exceptions\WordListNotUniqueException;
use Doxadoxa\Exceptions\WrongWordListSizeException;
use Doxadoxa\Generator\WordList;
use PHPUnit\Framework\TestCase;

/**
 * Class WordListTest
 */
class WordListTest extends TestCase
{
    private $wordList;

    /**
     * WordListTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->wordList = $this->createNormalWordList();

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function testNotCreatingWithEmptyContent()
    {
        $this->expectException( WrongWordListSizeException::class );
        $wordList = new WordList("");
    }

    /***
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function testNotUniqueContentFailed()
    {
        $this->expectException( WordListNotUniqueException::class );
        $wordList = new WordList( $this->makeNotUniqueList() );
    }

    /**
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function testCreatingNormally()
    {
        $this->assertIsObject( $this->wordList );
    }

    /**
     *
     */
    public function testFlipMethod()
    {
        $word = $this->wordList[0];
        $flipped = $this->wordList->flip();

        $this->assertEquals( 0, $flipped[ $word ] );
    }

    /**
     */
    public function testIsSetNotAllowed()
    {
        $this->expectException( MethodNotAllowedException::class );
        $this->wordList[0] = "test";
    }

    /**
     */
    public function testIsUnsetNotAllowed()
    {
        $this->expectException( MethodNotAllowedException::class );
        unset( $this->wordList[0] );
    }

    /**
     */
    public function testNotExistedWordListReturnNotNull()
    {
        $notExistedWord = "ijasoiqej";
        $result = $this->wordList->notExistedWordList( [ $notExistedWord ] );
        $this->assertIsArray( $result );
        $this->assertNotEmpty( $result );
    }

    /**
     */
    public function testNotExistedWordListReturnNull()
    {
        $notExistedWord = "shift";
        $result = $this->wordList->notExistedWordList( [ $notExistedWord ] );
        $this->assertNull( $result );
    }

    /**
     *
     */
    public function testReplace()
    {
        $toReplace = "shit";
        $replacement = "shift";
        $result = $this->wordList->replace( $toReplace );

        $this->assertEquals( $replacement, $result );
    }

    /**
     * @return WordList
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function createNormalWordList(): WordList
    {
        return new WordList( file_get_contents("wordlist.txt") );
    }

    /**
     * @return string
     */
    public function makeNotUniqueList(): string
    {
        $list = [];
        for( $i = 0; $i < 2048; ++$i ) {
            $list[] = "unique";
        }

        return implode(PHP_EOL, $list );
    }
}
