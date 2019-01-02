<?php
namespace Padaliyajay\PHPAutoprefixer\Compile;

class KeyFrame {
    const VENDOR_KEYFRAMES = array('-webkit-keyframes');
    
    /**
     * @type \Sabberworm\CSS\CSSList\KeyFrame
     */
    private $keyFrame;
    
    public function __construct($keyFrame){
        if($keyFrame instanceof \Sabberworm\CSS\CSSList\KeyFrame){
            $this->keyFrame = $keyFrame;
        } else {
            throw new \Exception('Invalid argument! Require instance of \Sabberworm\CSS\CSSList\KeyFrame');
        }
    }
    
    /**
     * Compile KeyFrame
     */
    public function compile(){
        $m_keyframes = array();
        
        foreach(self::VENDOR_KEYFRAMES as $vendor_keyframe){
            if($this->keyFrame->getVendorKeyFrame() !== $vendor_keyframe){
                $m_keyframe = clone $this->keyFrame;
                $m_keyframe->setVendorKeyFrame($vendor_keyframe);
                array_push($m_keyframes, $m_keyframe);
            }
         }
        
        return $m_keyframes;
    }
}

