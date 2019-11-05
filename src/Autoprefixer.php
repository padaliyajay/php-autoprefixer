<?php
namespace Padaliyajay\PHPAutoprefixer;

class Autoprefixer {

    private $css_parser;

    public function __construct($css_code){
        $this->css_parser = new \Sabberworm\CSS\Parser($css_code);
    }

    /**
     * @param bool $prettyOutput
     * @return bool
     */
    public function compile($prettyOutput = true) {
        if($this->css_parser){
            $css_document = $this->css_parser->parse();

            $this->compileCSSList($css_document);

            $outputFormat = $prettyOutput ?
                \Sabberworm\CSS\OutputFormat::createPretty() :
                \Sabberworm\CSS\OutputFormat::createCompact();

            return $css_document->render($outputFormat);
        } else {
            return false;
        }
    }

    /**
     * Compile CSSList
     * @param \Sabberworm\CSS\CSSList\CSSList $css_list
     */
    protected function compileCSSList($css_list){
        $m_contents = $css_list->getContents();
        $total_added = 0;

        foreach($css_list->getContents() as $key => $content){
            $vendor_contents = array();

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
                $m_atRules = $compile_atRule->compile();

                if($m_atRules){
                    $vendor_contents = array_merge($vendor_contents, $m_atRules);
                }
            }

            // CSSList
            if($content instanceof \Sabberworm\CSS\CSSList\CSSList) {
                $this->compileCSSList($content);
            }

            // Remove already existing vendor content
            $vendor_contents = array_filter($vendor_contents, function($vendor_content) use($m_contents){
                if(!in_array((string)$vendor_content, array_map('strval', $m_contents))){
                    return true;
                } else {
                    return false;
                }
            });

            // Add vendor content
            if($vendor_contents){
                array_splice($m_contents, $key + $total_added, 0, $vendor_contents);
                $total_added += count($vendor_contents);
            }
        }

        $css_list->setContents($m_contents);
    }

}

