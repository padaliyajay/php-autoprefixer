# php-autoprefixer
CSS autoprefixer written in pure PHP

## Installation
Simply add a dependency on padaliyajay/php-autoprefixer to your composer.json file

```
composer require padaliyajay/php-autoprefixer
```

## Usage
```
use Padaliyajay\PHPAutoprefixer\Autoprefixer;

$unprefixed_css = file_get_contents('main.css'); // CSS code

$autoprefixer = new Autoprefixer($unprefixed_css);
$prefixed_css = $autoprefixer->compile();
```

## License

Minify is [MIT](http://opensource.org/licenses/MIT) licensed.
