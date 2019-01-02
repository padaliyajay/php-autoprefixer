<?php
namespace Padaliyajay\PHPAutoprefixer\Parse;

class Selector {
    const VENDOR_PSEUDO = array(
        '::placeholder' => array('::-webkit-input-placeholder', '::-moz-placeholder', '::-ms-input-placeholder', ':-ms-input-placeholder'),
    );
    
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
    public function getVendorSelector(){
        $vendor_selectors = array();
        
        // Pseudo
        foreach(self::VENDOR_PSEUDO as $generic_pseudo => $vendor_pseudo){
            if(strpos($this->selector->getSelector(), $generic_pseudo) !== false){
                if(is_array($vendor_pseudo)){
                    foreach($vendor_pseudo as $pseudo_selector){
                        $new_selector = clone $this->selector;
                        $new_selector->setSelector(str_replace($generic_pseudo, $pseudo_selector, $this->selector->getSelector()));
                        $vendor_selectors[] = $new_selector;
                    }
                } else {
                    $new_selector = clone $this->selector;
                    $new_selector->setSelector(str_replace($generic_pseudo, $vendor_pseudo, $this->selector->getSelector()));
                    $vendor_selectors[] = $new_selector;
                }
            }
        }
        
        return $vendor_selectors;
    }
}

