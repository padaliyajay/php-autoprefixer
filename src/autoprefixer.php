<?php
require_once 'css.php';

class Autoprefixer {
    const VENDOR_RULE_SET = array(
        'display' => array('display' => array(
            'flex' => '-ms-flexbox',
            'inline-flex' => '-ms-inline-flexbox',
        )),
        'position' => array('position' => array('sticky' => '-webkit-sticky')),
        'flex' => array('-ms-flex'),
        'flex-wrap' => array('-ms-flex-wrap'),
        'flex-basis' => array('-ms-flex-preferred-size'),
        'flex-grow' => array('-ms-flex-positive'),
        'flex-flow' => array('-ms-flex-flow'),
        'flex-direction' => array('-ms-flex-direction'),
        'flex-shrink' => array('-ms-flex-negative'),
        'align-items' => array('-ms-flex-align' => array('flex-start' => 'start', 'flex-end' => 'end')),
        'align-content' => array('-ms-flex-line-pack' => array('flex-start' => 'start', 'flex-end' => 'end', 'space-between' => 'justify', 'space-around' => 'distribute')),
        'align-self' => array('-ms-flex-item-align' => array('flex-start' => 'start', 'flex-end' => 'end', 'space-between' => 'justify', 'space-around' => 'distribute')),
        'justify-content' => array('-ms-flex-pack' => array('space-between' => 'justify', 'flex-start' => 'start', 'flex-end' => 'end', 'space-around' => 'distribute')),
        'order' => array('-ms-flex-order'),
        'column-count' => array('-webkit-column-count', '-moz-column-count'),
        'column-gap' => array('-webkit-column-gap', '-moz-column-gap'),
        'user-select' => array('-webkit-user-select', '-moz-user-select', '-ms-user-select'),
        'appearance' => array('-webkit-appearance', '-moz-appearance'),
        'animation' => array('-webkit-animation'),
        'transform' => array('-webkit-transform'),
        'backface-visibility' => array('-webkit-backface-visibility'),
        'perspective' => array('-webkit-perspective'),
        
    );
    
    const VENDOR_PSEUDO = array(
        '::placeholder' => array('::-webkit-input-placeholder', '::-moz-placeholder', '::-ms-input-placeholder', ':-ms-input-placeholder'),
    );
    
    const VENDOR_KEYFRAMES = array('-webkit-keyframes');
    
    private $css_parser;
    
    public function __construct($css_code){
        $this->css_parser = new Sabberworm\CSS\Parser($css_code);
    }
    
    public function compile(){
        if($this->css_parser){
            $css_document = $this->css_parser->parse();
            
            $this->compileCSSList($css_document);
            
            return $css_document->render(Sabberworm\CSS\OutputFormat::createPretty());
        } else {
            return false;
        }
    }
    
    /**
     * Compile CSSList
     * @param Sabberworm\CSS\CSSList\CSSList $css_list
     */
    protected function compileCSSList($css_list){
        foreach($css_list->getContents() as $content){
            // RuleSet
            if($content instanceof Sabberworm\CSS\RuleSet\RuleSet) {
                $this->compileRuleSet($content);
            } 
            
            // DeclarationBlock
            if($content instanceof Sabberworm\CSS\RuleSet\DeclarationBlock){
                $this->compileDeclarationBlock($content);
            }
            
            // CSSList
            if($content instanceof Sabberworm\CSS\CSSList\CSSList) { 
                $this->compileCSSList($content);
            }
            
            // KeyFrame
            if($content instanceof Sabberworm\CSS\CSSList\KeyFrame) { 
                $m_keyframes = $this->compileKeyFrame($content);
                
                if($m_keyframes){
                    array_push($m_keyframes, $content);
                    $css_list->replace($content, $m_keyframes);
                }
            }
        }
    }
    
    /**
     * Compile KeyFrame
     * @param Sabberworm\CSS\CSSList\KeyFrame $key_frame
     */
    protected function compileKeyFrame($key_frame){
        $m_keyframes = array();
        
        foreach(self::VENDOR_KEYFRAMES as $vendor_keyframe){
            if($key_frame->getVendorKeyFrame() !== $vendor_keyframe){
                $m_keyframe = clone $key_frame;
                $m_keyframe->setVendorKeyFrame($vendor_keyframe);
                array_push($m_keyframes, $m_keyframe);
            }
         }
        
        return $m_keyframes;
    }
    
    
    /**
     * Compile Ruleset
     * @param Sabberworm\CSS\RuleSet\RuleSet $rule_set
     */
    protected function compileRuleSet($rule_set){
        $m_rules = $rule_set->getRules();
        $total_added = 0;
        foreach($rule_set->getRules() as $key => $rule){
            $vendor_rules = $this->createVendorRules($rule);
            
            if($vendor_rules){
                array_splice($m_rules, $key + $total_added, 0, $vendor_rules);
                $total_added += count($vendor_rules);
            }
        }
        $rule_set->setRules($m_rules);
    }
    
    /**
     * Create vendor rules of generic rule
     * @param Sabberworm\CSS\Rule\Rule $rule generic rule
     * @return Array Vendor rules
     */
    protected function createVendorRules($rule){
        $vendor_rules = array();
        
        if(isset(self::VENDOR_RULE_SET[$rule->getRule()]) && is_array(self::VENDOR_RULE_SET[$rule->getRule()])){ // Multiple vendor prefix
            
            foreach(self::VENDOR_RULE_SET[$rule->getRule()] as $rule_key => $rule_name_or_value){
                
                if(is_array($rule_name_or_value)){ // Vendor rule with vendor value
                    
                    if($rule_key !== $rule->getRule()){ // different vendor rule and value
                        if(isset($rule_name_or_value[$rule->getValue()])){
                            $vendor_rules[] = $this->createRuleFrom($rule, $rule_key, $rule_name_or_value[$rule->getValue()]);
                        } else {
                            $vendor_rules[] = $this->createRuleFrom($rule, $rule_key, $rule->getValue());
                        }
                    } elseif(isset($rule_name_or_value[$rule->getValue()])) { // Same rule but different vendor value
                        $vendor_rules[] = $this->createRuleFrom($rule, $rule->getRule(), $rule_name_or_value[$rule->getValue()]);
                    }
                } else { // Vendor rule with same value
                    $vendor_rules[] = $this->createRuleFrom($rule, $rule_name_or_value, $rule->getValue());
                }
            }
        } elseif(isset(self::VENDOR_RULE_SET[$rule->getRule()]) && is_string(self::VENDOR_RULE_SET[$rule->getRule()])) { // Single vendor prefix
            $vendor_rules[] = $this->createRuleFrom($rule, self::VENDOR_RULE_SET[$rule->getRule()], $rule->getValue());
        }
        
        return $vendor_rules;
    }
    
    /**
     * Clone rule with new name and value pair
     * @param Sabberworm\CSS\Rule\Rule $from_rule copy rule from
     * @param String $name rule name
     * @param Mixed $value rule value
     * @return Sabberworm\CSS\Rule\Rule new rule
     */
    protected function createRuleFrom($from_rule, $name, $value){
        $rule = clone $from_rule;
        $rule->setRule($name);
        $rule->setValue($value);
        
        return $rule;
    }
    
    /**
     * Compile DeclarationBlock and add vendor selector
     * @param Sabberworm\CSS\RuleSet\DeclarationBlock $content DeclarationBlock
     */
    protected function compileDeclarationBlock($content){
        $m_selectors = $content->getSelectors();
        $total_added = 0;
        foreach($content->getSelectors() as $key => $selector){
            $vendor_selector = $this->createVendorSelector($selector);
            if($vendor_selector){
                array_splice($m_selectors, $key + $total_added, 0, $vendor_selector);
                $total_added += count($vendor_selector);
            }
        }
        $content->setSelectors($m_selectors);
    }
    
    /**
     * Create list of vendor prefixed selectors
     * @param Sabberworm\CSS\Property\Selector $selector generic selector
     * @return Array
     */
    protected function createVendorSelector($selector){
        $vendor_selectors = array();
        
        // Pseudo
        foreach(self::VENDOR_PSEUDO as $generic_pseudo => $vendor_pseudo){
            if(strpos($selector->getSelector(), $generic_pseudo) !== false){
                if(is_array($vendor_pseudo)){
                    foreach($vendor_pseudo as $pseudo_selector){
                        $new_selector = clone $selector;
                        $new_selector->setSelector(str_replace($generic_pseudo, $pseudo_selector, $selector->getSelector()));
                        $vendor_selectors[] = $new_selector;
                    }
                } else {
                    $new_selector = clone $selector;
                    $new_selector->setSelector(str_replace($generic_pseudo, $vendor_pseudo, $selector->getSelector()));
                    $vendor_selectors[] = $new_selector;
                }
            }
        }
        
        return $vendor_selectors;
    }
}

