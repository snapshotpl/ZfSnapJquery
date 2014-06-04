<?php

namespace ZfSnapJquery\View\Helper;

use ZfSnapJquery\Libraries\Jquery as JqueryLib;
use ZfSnapJquery\View\Helper\Jquery as JqueryHelper;
use Zend\Json\Json;
use Zend\Json\Expr;

/**
 * JqueryCaller
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 * @copyright 2013 (c) by RedSky Sp. z o.o.
 */
class JqueryCaller
{
    const CONFLICT_MODE_ENABLE_SUFFIX = 'jQuery';
    const CONFLICT_MODE_DISABLE_SUFFIX = '$';

    /**
     * @var ZfSnapJquery\Libraries\Jquery
     */
    private $jquery;

    /**
     * @var array
     */
    private $call = array();

    /**
     * @param Jquery $jquery
     */
    public function __construct(JqueryHelper $jquery)
    {
        foreach ($jquery->getLibraries() as $lib) {
            if ($lib instanceof JqueryLib) {
                $this->jquery = $lib;
                break;
            }
        }
    }

    /**
     * @return string
     */
    public function getGodFunctionName()
    {
        $conflictMode = $this->jquery->isNoConflictMode();
        return $conflictMode ? self::CONFLICT_MODE_ENABLE_SUFFIX : self::CONFLICT_MODE_DISABLE_SUFFIX;
    }

    /**
     *
     * @param string $selector
     * @return JqueryCaller
     */
    public function selector($selector)
    {
        if (!$selector instanceof Expr) {
            $selector = '"'. $selector .'"';
        }
        $this->call[] = $this->getGodFunctionName() . '('.$selector.')';

        return $this;
    }

    /**
     *
     * @param string $id
     * @return JqueryCaller
     */
    public function selectorById($id)
    {
        $escapedId = $this->escapeId($id);

        return $this->selector('#'. $escapedId);
    }

    /**
     * Escapes ID selector via http://learn.jquery.com/using-jquery-core/faq/how-do-i-select-an-element-by-an-id-that-has-characters-used-in-css-notation/
     *
     * @param string $id
     * @return string
     */
    public function escapeId($id)
    {
        return preg_replace('/(:|\.|\[|\])/', '\\\\\\\$0', $id);
    }

    /**
     * @param string $name
     * @param array $params
     * @return \ZfSnapJquery\View\Helper\JqueryCaller
     */
    public function method($name, array $params = array())
    {
        $methodParams = array();
        foreach ($params as $param) {
        	foreach ($param as $key => $value) {
				if (stripos($value, 'function') === 0) {
					$methodParam = (string) $key . ': ' . $value;
				} else {
					$methodParam = (string) $key . ': ' . $this->jsonEncode($value);
				}
				$methodParams[] = $methodParam;
        	}
        }
        $arguments = join(', ', $methodParams);

        $this->call[] = $name .'({'. $arguments .'})';
        return $this;
    }

    /**
     * @return string
     */
    public function assemble()
    {
        $output = join('.', $this->call) .';';
        $this->call = array();

        return $output;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->assemble();
    }

    /**
     * @param mixed $data
     * @return string
     */
    private function jsonEncode($data)
    {
        return Json::encode($data, false, array('enableJsonExprFinder' => true));
    }
}
