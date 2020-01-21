<?php
declare(strict_types=1);

use Doxadoxa\Exceptions\PhraseCantBeEmptyException;
use Doxadoxa\Exceptions\WordListNotFoundException;
use Doxadoxa\Exceptions\WordListNotUniqueException;
use Doxadoxa\Exceptions\WordsNotExistException;
use Doxadoxa\Exceptions\WrongWordListSizeException;
use PHPUnit\Framework\TestCase;
use Doxadoxa\Generator\Generator;

class GeneratorTest extends TestCase
{
    private $generator;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->generator = $this->createGenerator();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @throws WordListNotFoundException
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function testGeneratorNotCreateWithWronFile()
    {
        $this->expectException(WordListNotFoundException::class);
        $generator = new Generator("reallynotexistedfile.txt");
    }

    /**
     * @throws PhraseCantBeEmptyException
     */
    public function testEmptyPhraseNotAllowed()
    {
        $this->expectException( PhraseCantBeEmptyException::class );
        $this->generator->generate("");
    }

    /**
     * @throws PhraseCantBeEmptyException
     */
    public function testGeneratingWorks()
    {
        $password = "123456";
        $words = "about basket book speak plug";

        $phrase = implode(" ", $this->generator->generate( $password ) );

        $this->assertEquals( $phrase, $words );
    }

    /**
     * @throws WordsNotExistException
     */
    public function testDecodeWorks()
    {
        $password = "123456";
        $words = "about basket book speak plug";

        $restored = $this->generator->decode( explode(" ", $words ) );

        $this->assertEquals( $restored, $password );
    }

    /**
     * @return Generator
     * @throws WordListNotFoundException
     * @throws WordListNotUniqueException
     * @throws WrongWordListSizeException
     */
    public function createGenerator(): Generator
    {
        return new Generator("wordlist.txt");
    }
}
