<?php

namespace ZfSnapJquery\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Json\Expr;
use Zend\Form\Element\Hidden;

/**
 * Slider
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 * @copyright 2013 (c) by RedSky Sp. z o.o.
 */
class Slider extends AbstractHelper
{

    /**
     *
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $name = $element->getName();
        $valueTemp = $element->getValue();

        $value = ($valueTemp == '' ? -1 : $valueTemp);
        $id = $this->getId($element);

        $queryAttributes = $element->getAttribute('jquery');
        $sliderId = $element->getAttribute('slider-id');

        if ($sliderId === null) {
            $sliderId = $id . '-slider';
        }

        if (!is_array($queryAttributes)) {
            $queryAttributes = array();
        }

        $sliderCaller = $this->buildCaller();

        $paramsDefault = array();
        $params = array_merge($paramsDefault, $queryAttributes);

        if (!array_key_exists('slide', $params)) {
            $callerSlide = clone $sliderCaller;
            $callerSlide->selectorById($id);
            $callerSlide->method('val', array(new Expr('ui.value')));

            $slideFunction = 'function(event, ui) {' . $callerSlide . '}';
            $params['slide'] = new Expr($slideFunction);
        }
        $params['value'] = $value;

        $sliderCaller->selectorById($sliderId);
        $sliderCaller->method('slider', array($params));
        $jquery = $this->getJquery();
        $jquery->addInlineScript($sliderCaller);

        $output = '<div id="' . $sliderId . '"></div>';

        $elementHidden = new Hidden($name);
        $elementHidden->setAttributes(array(
            'value' => $value,
            'id' => $id,
        ));
        $hiddenHelper = $this->getView()->plugin('formHidden');
        $output .= $hiddenHelper->render($elementHidden);
        return $output;
    }
}
