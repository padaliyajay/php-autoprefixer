<?php
namespace Padaliyajay\PHPAutoprefixer\Vendor;

use Padaliyajay\PHPAutoprefixer\Vendor\Vendor;

class IE extends Vendor {
    protected static $RULE_PROPERTY = array(
        'flex' => '-ms-flex',
        'flex-wrap' => '-ms-flex-wrap',
        'flex-basis' => '-ms-flex-preferred-size',
        'flex-grow' => '-ms-flex-positive',
        'flex-flow' => '-ms-flex-flow',
        'flex-direction' => '-ms-flex-direction',
        'flex-shrink' => '-ms-flex-negative',
        'flow-from' => '-ms-flow-from',
        'flow-into' => '-ms-flow-into',
        'align-items' => '-ms-flex-align',
        'align-content' => '-ms-flex-line-pack',
        'align-self' => '-ms-flex-item-align',
        'justify-content' => '-ms-flex-pack',
        'order' => '-ms-flex-order',
        'user-select' => '-ms-user-select',
        'hyphens' => '-ms-hyphens',
        'word-break' => '-ms-word-break',
        'transform'  => '-ms-transform',
        'transform-origin'  => '-ms-transform-origin'
    );
    
    protected static $RULE_VALUE = array(
        'display' => array(
            'flex' => '-ms-flexbox',
            'inline-flex' => '-ms-inline-flexbox',
            'grid' => '-ms-grid',
        ),
        '-ms-flex-align' => array('flex-start' => 'start', 'flex-end' => 'end'),
        '-ms-flex-line-pack' => array('flex-start' => 'start', 'flex-end' => 'end', 'space-between' => 'justify', 'space-around' => 'distribute'),
        '-ms-flex-item-align' => array('flex-start' => 'start', 'flex-end' => 'end', 'space-between' => 'justify', 'space-around' => 'distribute'),
        '-ms-flex-pack' => array('space-between' => 'justify', 'flex-start' => 'start', 'flex-end' => 'end', 'space-around' => 'distribute'),
        
    );
    
    protected static $PSEUDO = array(
        '::placeholder' => '::-ms-input-placeholder',
    );
}

