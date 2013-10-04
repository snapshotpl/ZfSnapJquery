<?php

namespace ZfSnapJquery\Form\View\Helper;

use Zend\Form\ElementInterface;

/**
 * Abstract Simple Helper
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
abstract class AbstractSimpleHelper extends AbstractHelper
{
    /**
     * @return string
     */
    abstract function getCallerMethodName();

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $jqueryAttributes = $element->getAttribute('jquery');
        $caller = $this->buildCaller($element)->method($this->getCallerMethodName(), array($jqueryAttributes));

        $jquery = $this->getJquery();
        $jquery->addInlineScript($caller);

        $textHelper = $this->getView()->plugin('formText');
        $element->setAttributes(array(
            'id' => $this->getId($element)
        ));
        $output = $textHelper->render($element);

        return $output;
    }
}
