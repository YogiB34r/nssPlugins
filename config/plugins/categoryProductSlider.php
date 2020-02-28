<?php
return [
	'settingPage' => [
		'pageTitle' => 'Slajder sa proizvodima',
		'menuTitle' => 'Slajder sa proizvodima',
		'capability' => 'manage_options',
		'menuSlug' => 'gf_category_product_slider_options',
		'template' => 'categoryProductSlider'
	],
	'registerSettings' => [
		'optionGroup' => 'gf_category_product_slider_options',
		'options' => [
			'gf_category_product_slider_options' =>[]
		]
	],
	'shortCode' => [
		'name' => 'gf_category_product_slider',
		'template' => ''
	],
];