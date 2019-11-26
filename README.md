# php-autoprefixer
CSS autoprefixer written in pure PHP

## Installation
Simply add a dependency on padaliyajay/php-autoprefixer to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:
```
composer require padaliyajay/php-autoprefixer
```
Although it's recommended to use Composer, you can actually [include these files](https://github.com/padaliyajay/php-autoprefixer/wiki/Installation) anyway you want.

## Usage
```
use Padaliyajay\PHPAutoprefixer\Autoprefixer;

$unprefixed_css = file_get_contents('main.css'); // CSS code

$autoprefixer = new Autoprefixer($unprefixed_css);
$prefixed_css = $autoprefixer->compile();
```

## License

[MIT](http://opensource.org/licenses/MIT) licensed.


## Donate & Support
[PayPal.me](https://www.paypal.me/padaliyajay/)
