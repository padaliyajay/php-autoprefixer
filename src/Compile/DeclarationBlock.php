<?php
namespace Padaliyajay\PHPAutoprefixer\Compile;

class DeclarationBlock {
    /**
     * @type \Sabberworm\CSS\RuleSet\DeclarationBlock
     */
    private $declarationBlock;
    
    public function __construct($declarationBlock){
        if($declarationBlock instanceof \Sabberworm\CSS\RuleSet\DeclarationBlock){
            $this->declarationBlock = $declarationBlock;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\RuleSet\DeclarationBlock');
        }
    }
    
    /**
     * Compile \Sabberworm\CSS\RuleSet\DeclarationBlock
     */
    public function compile(){
        $m_selectors = $this->declarationBlock->getSelectors();
        
        $total_added = 0;
        $_vendors_selector = [];

        foreach($this->declarationBlock->getSelectors() as $key => $selector){
            $parse_selector = new \Padaliyajay\PHPAutoprefixer\Parse\Selector($selector);
            $vendors_selector = $parse_selector->getVendorsSelector();
            
            // Remove already existing value
            $_vendors_selector = array_merge($_vendors_selector, array_filter($vendors_selector, function ($vendor_selector) use ($m_selectors) {
                if(!in_array((string)$vendor_selector, array_map('strval', $m_selectors))){
                    return true;
                } else {
                    return false;
                }
            }));
            
            if($_vendors_selector){
                array_splice($m_selectors, $key + $total_added, 0, $vendors_selector);
                $total_added += count($_vendors_selector);
            }
        }
        
        if ($total_added){
             $vendor_contents = [];

             foreach ($_vendors_selector as $key => $selector){
                  $p_declarationBlock = clone $this->declarationBlock;
                  $p_declarationBlock->setSelectors($selector->getSelector());
                  $vendor_contents[] = $p_declarationBlock;
             }

             return $vendor_contents;
        }

        $this->declarationBlock->setSelectors($m_selectors);
    }
}

