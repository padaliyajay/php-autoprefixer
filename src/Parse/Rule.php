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
    
    
}

