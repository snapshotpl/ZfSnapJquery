<?php

namespace ZfSnapJquery\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper as Helper;
use Zend\Form\ElementInterface;

/**
 * AbstractHelper
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 * @copyright 2013 (c) by RedSky Sp. z o.o.
 */
abstract class AbstractHelper extends Helper
{
    /**
     * @var \ZfSnapJquery\View\Helper\Jquery
     */
    private $jquery;

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormInput
     */
    public function __invoke(ElementInterface $element)
    {
        return $this->render($element);
    }

    /**
     * @return \ZfSnapJquery\View\Helper\Jquery
     */
    public function getJquery()
    {
        if (!$this->jquery) {
            $this->jquery = $this->getView()->plugin('jquery');
        }
        return $this->jquery;
    }

    /**
     * @param ElementInterface $element
     * @return \ZfSnapJquery\View\Helper\JqueryCaller
     */
    public function buildCaller(ElementInterface $element = null)
    {
        $jquery = $this->getJquery();
        $caller = $jquery->buildCaller();

        if ($element !== null) {
            $id = $this->getId($element);
            $caller->selectorById($id);
        }
        return $caller;
    }

    /**
     * @return string
     */
    abstract function render(ElementInterface $element);
}
