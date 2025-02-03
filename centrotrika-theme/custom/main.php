<?php

/**
 * App
 */

add_action( 
	'wp_enqueue_scripts', 
	function () {

    wp_enqueue_script(
      'centrotrtika-theme-app-js', 
      get_stylesheet_directory_uri() . '/custom/main.js',
      [
        'jquery'     
      ], 
      filemtime(get_stylesheet_directory() . '/custom/main.js'),
      true
    );

    // CSS

		wp_enqueue_style( 
			'centrotrtika-theme-css',
			get_stylesheet_directory_uri() . '/custom/main.css', 
			array(
        'astra-theme-css'
      ), 
			filemtime(get_stylesheet_directory() . '/custom/main.css'),
			'all' 
		);
	}, 
	999 
);