<?php
namespace Padaliyajay\PHPAutoprefixer\Compile;

class RuleSet {
    /**
     * @type \Sabberworm\CSS\RuleSet\RuleSet
     */
    private $ruleSet;
    
    public function __construct($ruleSet){
        if($ruleSet instanceof \Sabberworm\CSS\RuleSet\RuleSet){
            $this->ruleSet = $ruleSet;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\RuleSet\RuleSet');
        }
    }
    
    /**
     * Compile \Sabberworm\CSS\RuleSet\RuleSet
     */
    public function compile(){
        $m_rules = $this->ruleSet->getRules();
        
        $total_added = 0;
        foreach($this->ruleSet->getRules() as $key => $rule){
            $parser_rule = new \Padaliyajay\PHPAutoprefixer\Parse\Rule($rule);
            $vendor_rules = $parser_rule->getVendorRules();
            
            // Remove already existing value
            $vendor_rules = array_filter($vendor_rules, function($vendor_rule) use($m_rules) {
                $outputFormat = new \Sabberworm\CSS\OutputFormat();
                $current_vendor_string = $vendor_rule->render($outputFormat);
                
                $m_rules_strings = array_map(function ($m_rule_obj) use ($outputFormat) {
                    return $m_rule_obj->render($outputFormat);
                }, $m_rules);

                if(!in_array($current_vendor_string, $m_rules_strings)){
                    return true;
                } else {
                    return false;
                }
            });
            
            if($vendor_rules){
                array_splice($m_rules, $key + $total_added, 0, $vendor_rules);
                $total_added += count($vendor_rules);
            }
        }
        
        $this->ruleSet->setRules($m_rules);
    }
}

