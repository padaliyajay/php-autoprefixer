<?php
namespace Padaliyajay\PHPAutoprefixer;

use Padaliyajay\PHPAutoprefixer\Vendor\IE;
use Padaliyajay\PHPAutoprefixer\Vendor\Mozilla;
use Padaliyajay\PHPAutoprefixer\Vendor\Webkit;

class Vendor {
    public static $vendors = array(
        IE::class,
        Mozilla::class,
        Webkit::class
    );

    public static function getRuleProperty($vendor){
        return $vendor::getRuleProperty();
    }

    public static function getRuleValue($vendor){
        return $vendor::getRuleValue();
    }

    public static function getPseudo($vendor){
        return $vendor::getPseudo();
    }

    public static function getATRule($vendor){
        return $vendor::getATRule();
    }

    public static function getVendors(){
        return self::$vendors;
    }

    public static function setVendors($vendors){
        self::$vendors = $vendors;
    }
}
