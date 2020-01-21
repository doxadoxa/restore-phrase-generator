<?php
declare(strict_types=1);

include "vendor/autoload.php";

$generator = new Doxadoxa\Generator\Generator("wordlist.txt");

$phrases = [
    '123456',
    'Jwt^0$^q$iSb',
    'APowOKRQpf0i1-r12r0-ri-SA)_I0214'
];

foreach( $phrases as $phrase ) {
    echo "Phrase: " . $phrase . PHP_EOL;

    $words = $generator->generate($phrase);

    echo "Recovery: " . implode(' ', $words) . PHP_EOL;

    $restore = $generator->decode($words);

    echo "Restore: " . $restore . PHP_EOL;
    echo "-----" . PHP_EOL;
}

$wrongRestore = "about basket book speak shit";
echo "Try to restore fake phrase: $wrongRestore" . PHP_EOL;

$wrongRestore = explode(" ", $wrongRestore );

try {
    $restore = $generator->decode( $wrongRestore );
} catch ( Exception $e ) {
    echo $e->getMessage() . PHP_EOL;
}

$wordList = $generator->getWordList();
$wrongWordList = $wordList->notExistedWordList( $wrongRestore );
$replace = $wordList->replace( $wrongWordList[0] );
echo "May be you mean $replace not $wrongWordList[0]?" . PHP_EOL;