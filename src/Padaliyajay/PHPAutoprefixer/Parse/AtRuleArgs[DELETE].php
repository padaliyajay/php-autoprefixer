<?php
namespace Padaliyajay\PHPAutoprefixer\Parse;

class AtRuleArgs {
    /**
     * @type \Sabberworm\CSS\Property\AtRule
     */
    private $atRule;
    
    public function __construct($atRule){
        if($atRule instanceof \Sabberworm\CSS\Property\AtRule){
            $this->atRule = $atRule;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\Property\AtRule');
        }
    }
    
    
}

