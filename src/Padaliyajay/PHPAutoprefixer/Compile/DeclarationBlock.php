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
        foreach($this->declarationBlock->getSelectors() as $key => $selector){
            $parse_selector = new \Padaliyajay\PHPAutoprefixer\Parse\Selector($selector);
            $vendor_selector = $parse_selector->getVendorSelector();
            
            if($vendor_selector){
                array_splice($m_selectors, $key + $total_added, 0, $vendor_selector);
                $total_added += count($vendor_selector);
            }
        }
        
        $this->declarationBlock->setSelectors($m_selectors);
    }
}

