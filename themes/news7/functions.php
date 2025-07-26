<?php

function news7_setup_theme() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce');
}

add_action('after_setup_theme', 'news7_setup_theme');


function news7_enqueue_scripts(){
    $url= get_template_directory_uri();

 
    wp_enqueue_style('news7.bootstrap', $url.'/assets/css/bootstrap.min.css');
    wp_enqueue_style('news7.fonts.googleapis', '//fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    //wp_enqueue_style('swiper', $url.'/assets/css/swiper.min.css');
    wp_enqueue_style('news7.custom.style', $url.'/assets/css/news7.style.css', [], time());
    wp_enqueue_style('news7.style', get_stylesheet_uri(), [], time());

    wp_enqueue_script('news7.bootstrap',$url . '/assets/js/bootstrap.bundle.min.js',array('jquery'), null,null, true );
    //wp_enqueue_script('swiper',$url . '/assets/js/swiper.min.js',array('jquery'), null,null, true );
    wp_enqueue_script('news7.main',$url . '/assets/js/news7.main.js?tm='.time(),array('jquery'), null,null, true );
    

    // Localize the script with new data
    $translation_array = array(
	    'ajax_url' => admin_url('admin-ajax.php'),
        'action'=>'bgcontact',
        '_bgnonce'=> wp_create_nonce('bgnonce'),
    );
    wp_localize_script( 'news7.main', 'OPTION', $translation_array );

}

add_action( 'wp_enqueue_scripts', 'news7_enqueue_scripts' );


require_once "inc/post-metabox.php";
require_once "inc/category-metabox.php";
require_once "inc/custom-login.php";
require_once "inc/custom-registration-fields.php";
require_once "inc/custom-user-avatar-upload.php";

function news7_custom_upload_mimes($existing_mimes = array()) {
    $existing_mimes['webp'] = 'image/webp';
    $existing_mimes['ico'] = 'image/x-icon';
    $existing_mimes['svg'] = 'image/svg+xml';
    
    return $existing_mimes;
}
add_filter('mime_types', 'news7_custom_upload_mimes');
add_filter('upload_mimes', 'news7_custom_upload_mimes');

/*add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;


  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );*/