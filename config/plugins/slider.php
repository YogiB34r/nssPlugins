<?php
return [
	'settingPage' => [
		'pageTitle' => 'Slider options',
		'menuTitle' => 'Slider options',
		'capability' => 'manage_options',
		'menuSlug' => 'gf_slider_options',
		'template' => 'slider'
	],
	'registerSettings' => [
		'optionGroup' => 'gf_slider_options',
		'options' => [
			'gf_slider_options' =>[]
		]
	],
	'shortCode' => [
		'name' => 'gf_slider',
		'template' => 'slider'
	],
];