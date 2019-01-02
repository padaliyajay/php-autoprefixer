<?php
namespace Padaliyajay\PHPAutoprefixer\Parse;

use Padaliyajay\PHPAutoprefixer\Vendor;
use Padaliyajay\PHPAutoprefixer\Parse\Property;

class Rule {
    /**
     * @type \Sabberworm\CSS\Rule\Rule
     */
    private $rule;
    
    public function __construct($rule){
        if($rule instanceof \Sabberworm\CSS\Rule\Rule){
            $this->rule = $rule;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\Rule\Rule');
        }
    }
    
    /**
     * Create vendor rules of generic rule
     * @return Array Vendor rules
     */
    public function getVendorRules(){
        $vendor_rules = array();
        
        foreach(Vendor::getVendors() as $vendor){
//            if($this->rule->getRule() == 'transition' && $this->rule->getValue() instanceof \Sabberworm\CSS\Value\ValueList){
//                var_dump($this->rule->getValue()->getListComponents());
//            }
            $rule_property = new Property($this->rule->getRule());
            
            // Vendor property
            $rule_vendor_property = $rule_property->getVendorProperty($vendor);
            
            if($rule_vendor_property){
                $vendor_rule = clone $this->rule;
                $vendor_rule->setRule((string)$rule_vendor_property);
                
                $vendor_value = $rule_vendor_property->getVendorValue($this->rule->getValue(), $vendor);
                if($vendor_value){
                    $vendor_rule->setValue($vendor_value);
                }
                
                $vendor_rules[] = $vendor_rule;
            }
            
            // Vendor value
            $rule_vendor_value = $rule_property->getVendorValue($this->rule->getValue(), $vendor);
            
            if($rule_vendor_value){
                $vendor_rule = clone $this->rule;
                $vendor_rule->setValue($rule_vendor_value);
                
                $vendor_rules[] = $vendor_rule;
            }
        }
        
        return $vendor_rules;
    }
    
    /**
     * Get vendor rules of generic rule
     * @param String $rule_name generic rule name
     * @param String $rule_value generic rule value
     * @return Array Vendor rules
     */
//    protected function getPrefixedRules($vendor, $rule_name, $rule_value){
//        $vendor_rules = array();
//        
//        $rule_property = new Property($pName)
//        
//        
//        // Parser property
//        if(isset($vendor_rule_set[$rule_name]) && is_array($vendor_rule_set[$rule_name])){ // vendor prefix with vendor value
//            
//            foreach($vendor_rule_set[$rule_name] as $vendor_rule_name => $vendor_rule_value){
//                
//                if($vendor_rule_name !== $rule_name){ // different vendor rule and value
//                    if(isset($vendor_rule_value[$rule_value])){
//                        $vendor_rules[] = array('name' => $vendor_rule_name, 'value' => $vendor_rule_value[$rule_value]);
//                    } else {
//                        $vendor_rules[] = array('name' => $vendor_rule_name, 'value' => $rule_value);
//                    }
//                } elseif(isset($vendor_rule_value[$rule_value])) { // Same rule but different vendor value
//                    $vendor_rules[] = array('name' => $rule_name, 'value' => $vendor_rule_value[$rule_value]);
//                }
//            }
//        } elseif(isset($vendor_rule_set[$rule_name]) && is_string($vendor_rule_set[$rule_name])) { // Single vendor prefix
//            $vendor_rules[] = array('name' => $vendor_rule_set[$rule_name], 'value' => $rule_value);
//        }
//        
//        // Parser value as property
////        foreach($vendor_rules as $vendor_rule){
////            if(is_string($vendor_rule['value'])){
////                $vendor_rule['value'] = implode(', ', $this->getPrefixedProperties($vendor_rule['value'], $vendor));
////            } elseif($vendor_rule['value'] instanceof \Sabberworm\CSS\Value\ValueList){
////                $ListComponents = $vendor_rule['value']->getListComponents();
////                
////            }
////        }
//        
//        return $vendor_rules;
//    }
    
    
    
}

