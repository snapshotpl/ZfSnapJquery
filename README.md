ZfSnapJquery
============

jQuery and jQuery UI helpers and form elements for Zend Framework 2

Version 0.5.0 Created by Witold Wasiczko

Features
========

* jQuery UI elements
  * [Slider](http://jqueryui.com/slider/)
  * [Spinner](http://jqueryui.com/spinner/)
  * [Datepicker](http://jqueryui.com/datepicker/)
  * [Autocomplete](http://jqueryui.com/autocomplete/)
* Auto include js and css files with libs (using public cdn)
* Highly configurable
* Ready to use without configuration

Usage
=====

Create form:

```php
<?php

namespace Application\Form;

use Zend\Form\Form;

class Jquery extends Form
{
    public function init()
    {
        $this->add(array(
            'name' => 'slider',
            'type' => 'Slider',
        ));

        $this->add(array(
            'name' => 'spinner',
            'type' => 'Spinner',
        ));

        $this->add(array(
            'name' => 'datepicker',
            'type' => 'Datepicker',
        ));

        $this->add(array(
            'name' => 'autocomplete',
            'type' => 'Autocomplete',
            'attributes' => array(
                'jquery' => array(
                    'source' => array(
                        'Zend Framework',
                        'Symfony2',
                        'CakePHP',
                        'Kohana',
                        'Yii',
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
        ));
    }
}
```

Assign form to view in controller:

```php
public function indexAction()
{
    $sl = $this->getServiceLocator();

    $form = $sl->get('FormElementManager')->get('\Application\Form\Jquery');

    return new ViewModel(array(
        'form' => $form,
    ));
}
```
and print it in view:
```php
<?php echo $this->form()->openTag($this->form); ?>

<div class="form_element">
<?php echo $this->formJquerySlider($this->form->get('slider')); ?>
</div>

<div class="form_element">
<?php echo $this->formJquerySpinner($this->form->get('spinner')); ?>
</div>

<div class="form_element">
<?php echo $this->formJqueryDatepicker($this->form->get('datepicker')); ?>
</div>

<div class="form_element">
<?php echo $this->formJqueryAutocomplete($this->form->get('autocomplete')); ?>
</div>

<div class="form_element">
<?php echo $this->formSubmit($this->form->get('submit')); ?>
</div>

<?php echo $this->form()->closeTag() ?>
```
That's it!
Oh, and you need to print Zend's headLink(), headScript() and inlineScript() in your layout.

Customization
=============
Custom jQuery UI element property
----------------------------------
To change jquery options use jquery attribute:
```php
$this->add(array(
    'name' => 'autocomplete',
    'type' => 'Autocomplete',
    'attributes' => array(
        'jquery' => array(
            'source' => 'data-source.php',
        ),
    ),
));
```
Custom version, theme or CDN
----------------------------
If you need to change version, theme or default CDN - overwrite configuration:
```php
return array(
    'zf_snap_jquery' => array(
        'libraries' => array(
            'jquery' => array(
                'version' => '2.0.3',
                'cdnScript' => \ZfSnapJquery\Libraries\Jquery::CDN_GOOGLE,
            ),
            'jquery-ui' => array(
                'version' => '1.10.0',
                'theme' => 'black-tie',
            ),
        ),
    ),
);
```
Custom scripts and styles
-------------------------
You can use your own script or style:
```php
return array(
    'zf_snap_jquery' => array(
        'libraries' => array(
            'jquery' => array(
                'script' => 'url/to/script/jquery.min.js',
            ),
            'jquery-ui' => array(
                'script' => 'other/url/to/script/jquery-ui.min.js',
                'style' => 'url/to/style/jquery-ui.min.css',
            ),
        ),
    ),
);
```

Custom helper
-------------
If you don't want to use headLink(), headScript() and inlineScript() to include scripts and styles:
```php
return array(
    'zf_snap_jquery' => array(
        'view-helpers' => array(
            'jquery' => array(
                'appendToOwnHelper' => false,
            ),
        ),
    ),
);
```
And then in your layout:
```php
echo $this->jquery();
```
Custom way to append scripts or styles
--------------------------------------
To disable appending scripts and styles:
```php
return array(
    'zf_snap_jquery' => array(
        'libraries' => array(
            'jquery' => array(
                'enable' => false,
            ),
            'jquery-ui' => array(
                'enable' => false,
            ),
        ),
    ),
);
```

To see what you can customize see source of [module.config.php](config/module.config.php).

How to install?
===============
Via [composer.json](https://getcomposer.org/)
```json
{
    "require": {
        "snapshotpl/zf-snap-jquery": "dev-master"
    }
}
```
