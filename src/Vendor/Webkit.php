<?php
namespace Padaliyajay\PHPAutoprefixer\Vendor;

use Padaliyajay\PHPAutoprefixer\Vendor\Vendor;

class Webkit extends Vendor {
    protected static $RULE_PROPERTY = array(
        'box-reflect' => '-webkit-box-reflect',
        'column-count' => '-webkit-column-count',
        'column-gap' => '-webkit-column-gap',
        'column-rule' => '-webkit-column-rule',
        'clip-path' => '-webkit-clip-path',
        'user-select' => '-webkit-user-select',
        'appearance' => '-webkit-appearance',
        'animation' => '-webkit-animation',
        'transition' => '-webkit-transition',
        'transform' => '-webkit-transform',
        'transform-origin' => '-webkit-transform-origin',
        'backface-visibility' => '-webkit-backface-visibility',
        'backdrop-filter' => '-webkit-backdrop-filter',
        'perspective' => '-webkit-perspective',
        'background-clip' => '-webkit-background-clip',
        'filter' => '-webkit-filter',
        'font-feature-settings' => '-webkit-font-feature-settings',
        'flow-from' => '-webkit-flow-from',
        'flow-into' => '-webkit-flow-into',
        'hyphens' => '-webkit-hyphens',
        'mask-image' => '-webkit-mask-image',
        'mask-repeat' => '-webkit-mask-repeat',
        'mask-position' => '-webkit-mask-position',
        'mask-size' => '-webkit-mask-size',
    );
    
    protected static $RULE_VALUE = array(
        'display' => array(
            'flex' => '-webkit-flex',
            'inline-flex' => '-webkit-inline-flex',
        ),
        'position' => array('sticky' => '-webkit-sticky')
    );
    
    protected static $PSEUDO = array(
        '::placeholder' => '::-webkit-input-placeholder',
        '::file-selector-button' => '::-webkit-file-upload-button',
    );
    
    protected static $AT_RULE = array('keyframes' => '-webkit-keyframes');
}

