<?php
namespace Padaliyajay\PHPAutoprefixer;

class Vendor {
    const Vendors = array('IE', 'Mozilla', 'Webkit');
    
    public static function getRuleProperty($vendor){
        $vendor_class = 'Padaliyajay\PHPAutoprefixer\Vendor\\' . $vendor;
        return $vendor_class::getRuleProperty();
    }
    
    public static function getRuleValue($vendor){
        $vendor_class = 'Padaliyajay\PHPAutoprefixer\Vendor\\' . $vendor;
        return $vendor_class::getRuleValue();
    }
    
    public static function getPseudo($vendor){
        $vendor_class = 'Padaliyajay\PHPAutoprefixer\Vendor\\' . $vendor;
        return $vendor_class::getPseudo();
    }
    
    public static function getATRule($vendor){
        $vendor_class = 'Padaliyajay\PHPAutoprefixer\Vendor\\' . $vendor;
        return $vendor_class::getATRule();
    }
    
    public static function getVendors(){
        return self::Vendors;
    }
}

