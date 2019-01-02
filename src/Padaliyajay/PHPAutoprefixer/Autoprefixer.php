<?php
namespace Padaliyajay\PHPAutoprefixer;

// Common
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Renderable.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Settings.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/OutputFormat.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Parser.php';

// Value
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Value.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/PrimitiveValue.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/URL.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/ValueList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CSSFunction.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CalcFunction.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/RuleValueList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CalcRuleValueList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/CSSString.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/LineName.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Color.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Value/Size.php';

// Comment
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Comment/Commentable.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Comment/Comment.php';

// Rule
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Rule/Rule.php';

// Property
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Selector.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Property/AtRule.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Charset.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Property/CSSNamespace.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Property/Import.php';

// RuleSet
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/RuleSet.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/AtRuleSet.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/RuleSet/DeclarationBlock.php';

// CSSList
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/CSSList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/KeyFrame.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/CSSBlockList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/AtRuleBlockList.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/CSSList/Document.php';

// Parsing
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/SourceException.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/OutputException.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/UnexpectedTokenException.php';
require_once '../../../PHP-CSS-Parser/lib/Sabberworm/CSS/Parsing/ParserState.php';

// Vendor compile and parsing
require_once 'Vendor.php';
require_once 'Vendor/Vendor.php';
require_once 'Vendor/IE.php';
require_once 'Vendor/Mozilla.php';
require_once 'Vendor/Webkit.php';

require_once 'Parse/Property.php';
require_once 'Parse/Rule.php';
require_once 'Parse/Selector.php';
require_once 'Compile/AtRule.php';
require_once 'Compile/KeyFrame.php';
require_once 'Compile/RuleSet.php';
require_once 'Compile/DeclarationBlock.php';

class Autoprefixer {
    
    private $css_parser;
    
    public function __construct($css_code){
        $this->css_parser = new \Sabberworm\CSS\Parser($css_code);
    }
    
    public function compile(){
        if($this->css_parser){
            $css_document = $this->css_parser->parse();
            
            $this->compileCSSList($css_document);
            
            return $css_document->render(\Sabberworm\CSS\OutputFormat::createPretty());
        } else {
            return false;
        }
    }
    
    /**
     * Compile CSSList
     * @param \Sabberworm\CSS\CSSList\CSSList $css_list
     */
    protected function compileCSSList($css_list){
        foreach($css_list->getContents() as $content){
            // RuleSet
            if($content instanceof \Sabberworm\CSS\RuleSet\RuleSet) {
                $compile_ruleSet = new Compile\RuleSet($content);
                $compile_ruleSet->compile();
            } 
            
            // DeclarationBlock
            if($content instanceof \Sabberworm\CSS\RuleSet\DeclarationBlock){
                $compile_declarationBlock = new Compile\DeclarationBlock($content);
                $compile_declarationBlock->compile();
            }
            
            // AtRule
            if($content instanceof \Sabberworm\CSS\Property\AtRule){
                $compile_atRule = new Compile\AtRule($content);
                $compile_atRule->compile();
            }
            
            // CSSList
            if($content instanceof \Sabberworm\CSS\CSSList\CSSList) { 
                $this->compileCSSList($content);
            }
            
            // KeyFrame
            if($content instanceof \Sabberworm\CSS\CSSList\KeyFrame) { 
                $compile_keyFrame = new Compile\KeyFrame($content);
                $m_keyframes = $compile_keyFrame->compile();
                
                if($m_keyframes){
                    array_push($m_keyframes, $content);
                    $css_list->replace($content, $m_keyframes);
                }
            }
        }
    }
    
}

