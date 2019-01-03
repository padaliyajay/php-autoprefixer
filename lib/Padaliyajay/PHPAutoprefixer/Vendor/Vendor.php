<?php
namespace Padaliyajay\PHPAutoprefixer\Vendor;

abstract class Vendor {
    protected static $RULE_PROPERTY = array();
    
    protected static $RULE_VALUE = array();
    
    protected static $PSEUDO = array();
    
    protected static $AT_RULE = array();
    
    public static function getRuleProperty(){
        return static::$RULE_PROPERTY;
    }
    
    public static function getRuleValue(){
        return static::$RULE_VALUE;
    }
    
    public static function getPseudo(){
        return static::$PSEUDO;
    }
    
    public static function getATRule(){
        return static::$AT_RULE;
    }
}

