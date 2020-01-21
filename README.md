## Restore phrase generator
Small PHP library for generating a phrase for password restoring.

Inspired by BIP-39 from Bitcoin Core.

### How to install
//TODO

### How to use
Simply you can work with library via facade-helper-singleton:
```php
use Doxadoxa\Phrase;
$phrase = Phrase::generate("123456");
$restore = Phrase::decode( $phrase );
```

Or if you have to be more flexible, you can use `Generator` class instead:
```php
use Doxadoxa\Generator\Generator;
$generator = new Generator("wordlist.txt");
$result = $generator->generate("123456");
$generator->decode( $result );
```

You allow to make you own wordlist in file (separated with `\n`) and provide path to file in `Generator` constructor.