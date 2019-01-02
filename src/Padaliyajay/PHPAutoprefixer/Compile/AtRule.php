<?php
namespace Padaliyajay\PHPAutoprefixer\Compile;

class AtRule {
    /**
     * @type \Sabberworm\CSS\Property\AtRule
     */
    private $atRule;
    
    private $atArgs;
    
    public function __construct($atRule){
        if($atRule instanceof \Sabberworm\CSS\Property\AtRule){
            $this->atRule = $atRule;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\Property\AtRule');
        }
    }
    
    /**
     * Compile AtRule
     */
    public function compile(){
//        var_dump($this->atRule->atRuleArgs());
    }
    
    protected function parseArgs($argStr){
        $parseArg = array();
        $parseArg['type'] = 'box';
        $parseArg['value'] = '';
        
        $argStr = ltrim(trim($argStr), '(');
        
        for($i = 0; $i < strlen($argStr); $i++){
            if($argStr[$i] == '('){
                
                
            } elseif($argStr[$i] == ')'){
                break;
            }
        }
        
        return $parseArg;
    }
}

