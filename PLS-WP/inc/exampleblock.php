<?php

if (function_exists('acf_register_block_type')) {
	add_action('acf/init', 'register_acf_block_types');

	function register_acf_block_types() {
		acf_register_block_type ( 
			array(
				'name' => 'block-sample',
				'title' => 'Sample Block',
				'description' => '',
				'render_template' => 'template-parts/blocks/block-sample.php',
				'icon' => '',
				'keywords' => array('theme', 'sample'),
			)
		);
	}
}
?>