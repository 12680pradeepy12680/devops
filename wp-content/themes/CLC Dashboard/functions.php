<?php
 
//featured images support to custom post type
add_theme_support( 'post-thumbnails', array( 'courses' ) );

add_action('after_setup_theme', 'your_theme_features');

function your_theme_features()
{
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 1280, 720 );
};

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Header & Footer Settings',
		'menu_title'	=> 'Header & Footer Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

function allow_svg_upload( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_upload' );

add_filter('template_redirect', function () {
  ob_start(null, 0, 0);
});