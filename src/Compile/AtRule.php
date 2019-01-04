<?php
namespace Padaliyajay\PHPAutoprefixer\Compile;

use Padaliyajay\PHPAutoprefixer\Vendor;

/**
 * Compile CSS AtRule
 * This class under construction
 */
class AtRule {
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
    
    /**
     * Compile AtRule
     */
    public function compile(){
        return $this->getVendorsRule();
    }
    
    public function getVendorsRule(){
        $vendors_rule = array();
        
        foreach(Vendor::getVendors() as $vendor){
            $vendor_rule_name = $this->getVendorRuleName($vendor);
            
            if($vendor_rule_name){
                $vendors_rule[] = $vendor_rule_name;
            }
        }
        
        return $vendors_rule;
    }
    
    public function getVendorRuleName($vendor){
        $vendor_rule_names = Vendor::getATRule($vendor);
        
        $generic_rule_name = $this->atRule->atRuleName();
        
        if(isset($vendor_rule_names[$generic_rule_name])){
            $vendor_at_rule = false;
            
            if($this->atRule instanceof \Sabberworm\CSS\CSSList\KeyFrame){
                $vendor_at_rule = clone $this->atRule;
                $vendor_at_rule->setVendorKeyFrame($vendor_rule_names[$generic_rule_name]);
            }
            
            if($this->atRule instanceof \Sabberworm\CSS\CSSList\AtRuleBlockList){
                $vendor_at_rule = new \Sabberworm\CSS\CSSList\AtRuleBlockList($vendor_rule_names[$generic_rule_name], $this->atRule->atRuleArgs());
            }
            
            return $vendor_at_rule;
        } else {
            return false;
        }
    }
    
//    protected function parseArgs($argStr){
//        $parseArg = array();
//        $parseArg['type'] = 'box';
//        $parseArg['value'] = '';
//        
//        $argStr = ltrim(trim($argStr), '(');
//        
//        for($i = 0; $i < strlen($argStr); $i++){
//            if($argStr[$i] == '('){
//                
//                
//            } elseif($argStr[$i] == ')'){
//                break;
//            }
//        }
//        
//        return $parseArg;
//    }
}

