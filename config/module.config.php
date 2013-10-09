<?php

use ZfSnapJquery\Libraries;

return array(
    'zf_snap_jquery' => array(
        'libraries' => array(
            'jquery' => array(
                'version' => Libraries\Jquery::VERSION_DEFAULT,
                'cdnScript' => Libraries\Jquery::CDN_DEFAULT,
                'script' => null,
                'enabled' => true,
                'noConflictMode' => false,
            ),
            'jquery-ui' => array(
                'theme' => Libraries\Jqueryui::THEME_DEFAULT,
                'style' => Libraries\Jqueryui::CDN_STYLE_DEFAULT,
                'version' => Libraries\Jqueryui::VERSION_DEFAULT,
                'cdnScript' => Libraries\Jqueryui::CDN_JQUERY_SCRIPT,
                'script' => null,
                'enabled' => true,
            ),
        ),
        'view-helpers' => array(
            'jquery' => array(
                'appendToOwnHelper' => false,
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'jquery-class' => 'ZfSnapJquery\Libraries\Jquery',
            'jquery-ui-class' => 'ZfSnapJquery\Libraries\Jqueryui',
            'jquery-view-helper-class' => 'ZfSnapJquery\View\Helper\Jquery',
        ),
        'factories' => array(
            'jquery' => 'ZfSnapJquery\Libraries\JqueryFactory',
            'jquery-ui' => 'ZfSnapJquery\Libraries\JqueryuiFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'formJquerySlider' => 'ZfSnapJquery\Form\View\Helper\Slider',
            'formJquerySpinner' => 'ZfSnapJquery\Form\View\Helper\Spinner',
            'formJqueryDatepicker' => 'ZfSnapJquery\Form\View\Helper\Datepicker',
            'formJqueryAutocomplete' => 'ZfSnapJquery\Form\View\Helper\Autocomplete',
        ),
        'factories' => array(
            'jquery' => 'ZfSnapJquery\View\Helper\JqueryFactory',
        ),
    ),
    'form_elements' => array(
        'invokables' => array(
            'slider' => 'ZfSnapJquery\Form\Element\Slider',
            'spinner' => 'ZfSnapJquery\Form\Element\Spinner',
            'datepicker' => 'ZfSnapJquery\Form\Element\Datepicker',
            'autocomplete' => 'ZfSnapJquery\Form\Element\Autocomplete',
        ),
    )
);