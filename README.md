# php-autoprefixer
CSS autoprefixer written in pure PHP

## Installation
Simply add a dependency on padaliyajay/php-autoprefixer to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:
```
composer require padaliyajay/php-autoprefixer
```
Although it's recommended to use Composer, you can actually [include these files](https://github.com/padaliyajay/php-autoprefixer/wiki/Installation) anyway you want.

## Usage
```php
use Padaliyajay\PHPAutoprefixer\Autoprefixer;

$unprefixed_css = file_get_contents('main.css'); // CSS code

$autoprefixer = new Autoprefixer($unprefixed_css);
$prefixed_css = $autoprefixer->compile();
```

## Options

### `prettyOutput`

Example:
```php
$autoprefixer->compile(false); // Output minified CSS
```
Defines if the prefixed CSS will be a verbose/prettified output. When `false` the output will be minified. You can pass it as an option to the `compile()` method.

Default: `true`

### `setVendors`

Example:
```php
$autoprefixer->setVendors(array(
    // Omit prefixes for IE
    \Padaliyajay\PHPAutoprefixer\Vendor\Webkit::class,
    \Padaliyajay\PHPAutoprefixer\Vendor\Mozilla::class,
    MyNamespace\Custom\Opera::class // Use custom vendor prefixes
));

$autoprefixer->compile();
```
Define which vendor classes should be used for prefixing. You can omit unwanted vendors like e.g. IE. If used, only the vendor classes in the given array will take effect.

Default: 
```php
array(
    \Padaliyajay\PHPAutoprefixer\Vendor\IE::class,
    \Padaliyajay\PHPAutoprefixer\Vendor\Webkit::class,
    \Padaliyajay\PHPAutoprefixer\Vendor\Mozilla::class,
)
```

## License

[MIT](http://opensource.org/licenses/MIT) licensed.


## Donate & Support
[PayPal.me](https://www.paypal.me/padaliyajay/)
