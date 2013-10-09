<?php

namespace ZfSnapJquery\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfSnapJquery\Libraries\LibraryIterface;
use ZfSnapJquery\Libraries\Jquery as JqueryLib;
use Zend\Json\Expr;

/**
 * Jquery view helper
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Jquery extends AbstractHelper
{
    /**
     * @var array
     */
    private $inlineScripts = array();

    /**
     * @var bool
     */
    private $appendToOwnHelpers = true;

    /**
     * @var array
     */
    private $libraries = array();

    /**
     * @var array
     */
    private $helpers = array();

    /**
     * @var JqueryLib
     */
    private $jquery;

    /**
     * @param bool $appendToOwnHelper
     * @return Jquery
     */
    public function setAppendToOwnHelper($appendToOwnHelper)
    {
        $this->appendToOwnHelpers = (bool) $appendToOwnHelper;
        return $this;
    }

    /**
     * @param string $script
     * @return Jquery
     */
    public function addInlineScript($script)
    {
        $this->inlineScripts[] = (string) $script;
        $this->headScriptFile();
        $this->headScriptInline();
        $this->headStyle();

        return $this;
    }

    /**
     * @return string
     */
    private function getMergetInlineScripts()
    {
        return implode("\n", $this->inlineScripts);
    }

    /**
     * @param LibraryIterface $library
     * @return Jquery
     */
    public function addLibrary(LibraryIterface $library)
    {
        $this->libraries[] = $library;

        if ($library instanceof JqueryLib) {
            $this->jquery = $library;
        }
        return $this;
    }

    /**
     * @return Jquery
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return \Zend\View\Helper\HeadScript
     */
    public function headScriptFile()
    {
        $headScript = $this->getContainer('headScript');
        foreach ($this->libraries as $library) {
            $scripts = $library->getScripts();

            if ($scripts) {
                if (is_array($scripts)) {
                    foreach ($scripts as $script) {
                        $headScript->appendFile($script);
                    }
                } else {
                    $headScript->appendFile($scripts);
                }
            }
        }
        return $headScript;
    }

    protected function inlineWrapper($script)
    {
        $output = 'function() {
    ' . $script . '
}';

        $caller = new JqueryCaller($this);
        $caller->selector(new Expr($output));
        $output = (string) $caller;

        if ($this->jquery->isNoConflictMode()) {
            $output = 'jQuery.noConflict();'."\n". $output;
        }

        return $output;
    }

    /**
     * @return \Zend\View\Helper\InlineScript
     */
    public function headScriptInline()
    {
        $script = $this->getMergetInlineScripts();

        if ($script) {
            $inlineScript = $this->inlineWrapper($script);

            $headScript = $this->getContainer('inlineScript');
            $headScript('script', $inlineScript, 'set');
        }
        return $headScript;
    }

    /**
     * @return \Zend\View\Helper\HeadStyle
     */
    public function headStyle()
    {
        $headLink = $this->getContainer('headLink');
        foreach ($this->libraries as $library) {
            $styles = $library->getStyles();

            if ($styles) {
                if (is_array($styles)) {
                    foreach ($styles as $style) {
                        $headLink->appendStylesheet($style);
                    }
                } else {
                    $headLink->appendStylesheet($styles);
                }
            }
        }
        return $headLink;
    }

    /**
     * @return \Zend\View\Helper\AbstractHelper
     */
    public function getContainer($name)
    {
        $helper = $this->getHelper($name);
        if ($helper === null) {
            $helper = $this->getView()->plugin($name);

            if ($this->appendToOwnHelpers) {
                $helper = clone $helper;
                $helper->exchangeArray(array());
                $helper->deleteContainer();
            }
            $this->helpers[$name] = $helper;
        }

        return $helper;
    }

    /**
     * @return array
     */
    public function getLibraries()
    {
        return $this->libraries;
    }

    /**
     * @return JqueryCaller
     */
    public function buildCaller()
    {
        $caller = new JqueryCaller($this);

        return $caller;
    }

    /**
     * @return \Zend\View\Helper\AbstractHelper
     */
    private function getHelper($name)
    {
        if (key_exists($name, $this->helpers)) {
            $helper = $this->helpers[$name];
        } else {
            $helper = null;
        }
        return $helper;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = "\n";

        $headLink = $this->getHelper('headLink');
        $headScript = $this->getHelper('headScript');
        $inlineScript = $this->getHelper('inlineScript');

        if ($headLink) {
            $output .= (string) $headLink . "\n";
        }
        if ($headScript) {
            $output .= (string) $headScript . "\n";
        }
        if ($inlineScript) {
            $output .= (string) $inlineScript . "\n";
        }

        return $output;
    }
}
