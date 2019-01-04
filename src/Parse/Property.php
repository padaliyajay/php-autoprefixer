<?php
namespace Padaliyajay\PHPAutoprefixer\Parse;

use Padaliyajay\PHPAutoprefixer\Vendor;

class Property {
    /**
     * @type String
     */
    private $pName;
    
    public function __construct($pName){
        $this->pName = $pName;
    }
    
//    public function getVendorsProperty(){
//        $vendor_properties = array();
//        
//        foreach(Vendor::getVendors() as $vendor){
//            $vendor_property_set = Vendor::getRuleProperty($vendor);
//            
//            if(isset($vendor_property_set[$this->pName])) {
//                $vendor_properties[] = new Property($vendor_property_set[$this->pName]);
//            }
//        }
//        
//        return $vendor_properties;
//    }
    
    public function getVendorProperty($vendor){
        $vendor_property_set = Vendor::getRuleProperty($vendor);

        if(isset($vendor_property_set[$this->pName])) {
            return new Property($vendor_property_set[$this->pName]);
        } else {
            return false;
        }
    }
    
//    public function getVendorValue($generic_value, $vendor){
//        $vendor_values = array();
//        
//        // Get vendor list
//        $vendors = array();
//        if($vendor){
//            $vendors[] = $vendor;
//        } else {
//            $vendors = Vendor::getVendors();
//        }
//        
//        foreach($vendors as $vendor){
//            $vendor_value_set = Vendor::getRuleValue($vendor);
//            
//            if(isset($vendor_value_set[$this->pName][$generic_value])) {
//                $vendor_values[] = $vendor_value_set[$this->pName][$generic_value];
//            }
//        }
//        
//        return $vendor_values;
//    }
    
    public function getVendorValue($generic_value, $vendor){
        $vendor_value_set = Vendor::getRuleValue($vendor);

        if(is_string($generic_value) && isset($vendor_value_set[$this->pName][$generic_value])) {
            
            return $vendor_value_set[$this->pName][$generic_value];
        } elseif(is_string($generic_value)) { // parse value as property
            
            $vendor_property_set = Vendor::getRuleProperty($vendor);
            if(isset($vendor_property_set[$generic_value])){
                return $vendor_property_set[$generic_value];
            }
        } elseif($generic_value instanceof \Sabberworm\CSS\Value\ValueList){
            
            $vendor_value = clone $generic_value;
            
            $list_components = $vendor_value->getListComponents();
            foreach($list_components as $key => $component){
                $vendor_component = $this->getVendorValue($component, $vendor);
                if($vendor_component){
                    $list_components[$key] = $vendor_component;
                }
            }
            $vendor_value->setListComponents($list_components);
            
            if($vendor_value != $generic_value){
                return $vendor_value;
            }
        }
        
        return false;
    }
    
    public function __toString() {
        return $this->pName;
    }
    
}

