<?php

if( function_exists( 'register_block_style' ) ){
	// Add custom style to Heroic TOC for KnowAll
	register_block_style(
		'ht/block-toc',
		array(
			'name'         => 'knowall-default',
			'label'        => __( 'KnowAll Default', 'knowall' ),
		)
	);

	// Add custom style to Heroic Glossary for KnowAll
	register_block_style(
		'htgb/block-glossary',
		array(
			'name'         => 'knowall-default',
			'label'        => __( 'KnowAll Default', 'knowall' ),
		)
	);
}