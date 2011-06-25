<?php

//$Id$

// To make future upgrades easier
if (!defined('PROTOTYPE_DIR')) define ('PROTOTYPE_DIR', 'prototype-1.7');
if (!defined('SCRIPTACULOUS_DIR')) define ('SCRIPTACULOUS_DIR', 'scriptaculous-1.9.0');

//package names and its contents (files relative to the current directory)
$packages = array(
	'prado' => array(
		PROTOTYPE_DIR.'/prototype.js',
		SCRIPTACULOUS_DIR.'/builder.js',
		'prado/prado.js',
		'prado/scriptaculous-adapter.js',
		'prado/controls/controls.js',
		'prado/ratings/ratings.js',
	),

	'effects' => array(
		SCRIPTACULOUS_DIR.'/effects.js'
	),

	'logger' => array(
		'prado/logger/logger.js',
	),

	'validator' => array(
		'prado/validator/validation3.js'
	),

	'datepicker' => array(
		'prado/datepicker/datepicker.js'
	),

	'colorpicker' => array(
		'prado/colorpicker/colorpicker.js'
	),

	'ajax' => array(
		SCRIPTACULOUS_DIR.'/controls.js',
		'prado/activecontrols/json2.js',
		'prado/activecontrols/ajax3.js',
		'prado/activecontrols/activecontrols3.js',
		'prado/activecontrols/inlineeditor.js'
	),

	'dragdrop'=>array(
		SCRIPTACULOUS_DIR.'/dragdrop.js',
		'prado/activecontrols/dragdrop.js'
	),

	'dragdropextra'=>array(
		'prado/activecontrols/dragdropextra.js',
	),

	'slider'=>array(
		'prado/controls/slider.js'
	),

	'keyboard'=>array(
		'prado/controls/keyboard.js'
	),

	'tabpanel'=>array(
		'prado/controls/tabpanel.js'
	),
	
	'activedatepicker' => array(
		'prado/activecontrols/activedatepicker.js'
	),
	
	'activefileupload' => array(
		'prado/activefileupload/activefileupload.js'
	),

	'accordion'=>array(
		'prado/controls/accordion.js'
	),

);


//package names and their dependencies
$dependencies = array(
		'prado'				=> array('prado'),
		'effects'			=> array('prado', 'effects'),
		'validator'			=> array('prado', 'validator'),
		'logger'			=> array('prado', 'logger'),
		'datepicker'			=> array('prado', 'datepicker'),
		'colorpicker'			=> array('prado', 'colorpicker'),
		'ajax'				=> array('prado', 'effects', 'ajax'),
		'dragdrop'			=> array('prado', 'effects', 'ajax', 'dragdrop'),
		'slider'			=> array('prado', 'slider'),
		'keyboard'			=> array('prado', 'keyboard'),
		'tabpanel'			=> array('prado', 'tabpanel'),
		'activedatepicker'		=> array('prado', 'datepicker', 'ajax', 'activedatepicker'),
		'activefileupload'		=> array('prado', 'effects', 'ajax', 'activefileupload'),
		'dragdropextra'			=> array('prado', 'effects', 'ajax', 'dragdrop','dragdropextra'),
		'accordion'			=> array('prado', 'effects', 'accordion'),
);

return array($packages, $dependencies);

