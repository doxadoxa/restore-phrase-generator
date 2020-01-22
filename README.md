## Restore phrase generator
<a href="https://packagist.org/packages/doxadoxa/restore-phrase-generator"><img src="https://poser.pugx.org/doxadoxa/restore-phrase-generator/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/doxadoxa/restore-phrase-generator"><img src="https://poser.pugx.org/doxadoxa/restore-phrase-generator/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/doxadoxa/restore-phrase-generator"><img src="https://poser.pugx.org/doxadoxa/restore-phrase-generator/license.svg" alt="License"></a>

Small PHP library for generating a phrase for password restoring.

Inspired by BIP-39 from Bitcoin Core.

### How to install
Just use Composer:
```bash
composer require doxadoxa/restore-phrase-generator
```

### How to use
Simply you can work with library via facade-helper-singleton:
```php
use Doxadoxa\Phrase;
$phrase = Phrase::generate("123456");
// about basket book speak plug
$restore = Phrase::decode( $phrase );
// 123456
```

Or if you have to be more flexible, you can use `Generator` class instead:
```php
use Doxadoxa\Generator\Generator;
$generator = new Generator("wordlist.txt");
$result = $generator->generate("123456");
// about basket book speak plug
$generator->decode( $result );
// 123456 
```

You allow to make you own wordlist in file (separated with `\n`) and provide path to file in `Generator` constructor.