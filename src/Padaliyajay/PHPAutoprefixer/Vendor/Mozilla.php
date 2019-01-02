<?php
namespace Padaliyajay\PHPAutoprefixer\Vendor;

use Padaliyajay\PHPAutoprefixer\Vendor\Vendor;

class Mozilla extends Vendor {
    protected static $RULE_PROPERTY = array(
        'column-count' => '-moz-column-count',
        'column-gap' => '-moz-column-gap',
        'user-select' => '-moz-user-select',
        'appearance' => '-moz-appearance'
        
    );
    
    protected static $PSEUDO = array(
        '::placeholder' => '::-moz-placeholder',
    );
}

