<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['formConfigPath'] = 'config/form/'

$config['defaultCSSFwk'] = 'bootstrap';

$config['css_framework']['bootstrap'] = array(
    'form' => 'form-horizontal',
    'input' => 'form-control',
    'inputWrapper' => 'col-sm-10 input-group',
    'groupWrapper' => 'form-group',
    'label' => 'col-sm-2 control-label',
    'offset' => 'col-sm-offset-2',
    'radio' => 'radio-inline',
    'checkbox' => 'checkbox-inline',
    'help' => 'help-block'
);

$config['css_framework']['foundation'] = array(
    'form' => '',
    'input' => '',
    'inputWrapper' => 'small-9 columns',
    'groupWrapper' => 'row',
    'label' => 'right inline',
    'labelWrapper' => 'small-3 columns',
    'offset' => 'col-sm-offset-2',
    'radio' => '',
    'checkbox' => '',
    'help' => 'help-block'
);

$config['css_framework']['purecss'] = array(
    'form' => 'pure-form pure-form-aligned',
    'input' => '',
    'inputWrapper' => '',
    'fieldset' => '',
    'groupWrapper' => 'pure-control-group',
    'label' => 'right inline',
    'offset' => 'col-sm-offset-2',
    'radio' => 'pure-radio',
    'checkbox' => 'pure-checkbox',
    'help' => 'help-block'
);