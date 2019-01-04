<?php
namespace Padaliyajay\PHPAutoprefixer\Parse;

use Padaliyajay\PHPAutoprefixer\Vendor;

class Selector {
    /**
     * @type \Sabberworm\CSS\Property\Selector
     */
    private $selector;
    
    public function __construct($selector){
        if($selector instanceof \Sabberworm\CSS\Property\Selector){
            $this->selector = $selector;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\Property\Selector');
        }
    }
    
    /**
     * Create list of vendor prefixed selectors
     * @return Array
     */
    public function getVendorsSelector(){
        $vendor_selectors = array();
        
        foreach(Vendor::getVendors() as $vendor){
            $vendor_selector = $this->getVendorSelector($vendor);
            
            if($vendor_selector instanceof \Sabberworm\CSS\Property\Selector){
                $vendor_selectors[] = $vendor_selector;
            }
        }
        
        return $vendor_selectors;
    }
    
    /**
     * Get vendor selector of generic selector
     * @return Mixed
     */
    public function getVendorSelector($vendor){
        return $this->getVendorPseudo($vendor);
    }
    
    public function getVendorPseudo($vendor){
        $vendor_pseudos = Vendor::getPseudo($vendor);
        
        $m_generic_selector = $this->selector->getSelector();
        
        // Pseudo
        foreach($vendor_pseudos as $generic_pseudo => $vendor_pseudo){
            if(strpos($m_generic_selector, $generic_pseudo) !== false){
                $m_generic_selector = str_replace($generic_pseudo, $vendor_pseudo, $m_generic_selector);
            }
        }
        
        if($m_generic_selector !== $this->selector->getSelector()){
            $new_selector = clone $this->selector;
            $new_selector->setSelector($m_generic_selector);
            
            return $new_selector;
        } else {
            return false;
        }
    }
}

