<?php
require_once 'vendor/autoload.php';

use Padaliyajay\PHPAutoprefixer\Autoprefixer;

// Common
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Renderable.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Settings.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/OutputFormat.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Parser.php';
//
//// Value
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Value.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/PrimitiveValue.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/URL.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/ValueList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CSSFunction.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CalcFunction.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/RuleValueList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CalcRuleValueList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CSSString.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/LineName.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Color.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Size.php';
//
//// Comment
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Comment/Commentable.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Comment/Comment.php';
//
//// Rule
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Rule/Rule.php';
//
//// Property
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Selector.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Property/AtRule.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Charset.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Property/CSSNamespace.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Import.php';
//
//// RuleSet
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/RuleSet.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/AtRuleSet.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/DeclarationBlock.php';
//
//// CSSList
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/CSSList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/KeyFrame.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/CSSBlockList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/AtRuleBlockList.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/Document.php';
//
//// Parsing
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/SourceException.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/OutputException.php';
//require_once 'PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/UnexpectedTokenException.php';

// Vendor compile and parsing
//require_once 'padaliyajay/php-autoprefixer/src/autoprefixer.php';
//
//require_once 'padaliyajay/php-autoprefixer/src/Vendor.php';
//require_once 'padaliyajay/php-autoprefixer/src/Vendor/Vendor.php';
//require_once 'padaliyajay/php-autoprefixer/src/Vendor/IE.php';
//require_once 'padaliyajay/php-autoprefixer/src/Vendor/Mozilla.php';
//require_once 'padaliyajay/php-autoprefixer/src/Vendor/Webkit.php';
//
//require_once 'padaliyajay/php-autoprefixer/src/Parse/Property.php';
//require_once 'padaliyajay/php-autoprefixer/src/Parse/Rule.php';
//require_once 'padaliyajay/php-autoprefixer/src/Parse/Selector.php';
//require_once 'padaliyajay/php-autoprefixer/src/Compile/AtRule.php';
//require_once 'padaliyajay/php-autoprefixer/src/Compile/RuleSet.php';
//require_once 'padaliyajay/php-autoprefixer/src/Compile/DeclarationBlock.php';

$autoprefixer = new Autoprefixer(file_get_contents('unprefixed-bootstrap.css'));
file_put_contents('prefixed-bootstrap.css', $autoprefixer->compile());

$css_parser = new Sabberworm\CSS\Parser(file_get_contents('orignal-bootstrap.css'));
file_put_contents('parsed-bootstrap.css', $css_parser->parse()->render(Sabberworm\CSS\OutputFormat::createPretty()));


