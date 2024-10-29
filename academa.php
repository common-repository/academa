<?php
/*
Plugin Name: Academa
Description: Custom post types targetted towards showing an academic profile on a Wordpress website
Author: Ankit Gupta <ankit.gupta2801@gmail.com>
Author URI: http://ankit-gupta.com
Version: 0.1
Text Domain: academa
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

/*
Ensuring that the code here is only executed in the Wordpress context
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/*
===============================
Custom Scripts and Stylesheets
===============================
*/
function add_academa_admin_css(){
  wp_enqueue_style('academa-admin', plugins_url('/assets/css/publication-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'add_academa_admin_css');


function academa_style_and_js(){
  wp_enqueue_style('academa-main', plugins_url('/assets/css/main.css', __FILE__));
	wp_enqueue_script('academa-bibtex_js', plugins_url('/assets/js/bibtex_js.js', __FILE__));
}
add_action('wp_enqueue_scripts', 'academa_style_and_js');
/*
===============================
Custom Post Type
===============================
*/

// Register Custom Post Type
function academa_publication_type() {

	$labels = array(
		'name'                  => _x( 'Publications', 'Post Type General Name', 'academa' ),
		'singular_name'         => _x( 'Publication', 'Post Type Singular Name', 'academa' ),
		'menu_name'             => __( 'Publications', 'academa' ),
		'name_admin_bar'        => __( 'Publication', 'academa' ),
		'archives'              => __( 'Publication Archives', 'academa' ),
		'attributes'            => __( 'Publication Attributes', 'academa' ),
		'parent_item_colon'     => __( '', 'academa' ),
		'all_items'             => __( 'All Publications', 'academa' ),
		'add_new_item'          => __( 'Add new publication', 'academa' ),
		'add_new'               => __( 'Add New', 'academa' ),
		'new_item'              => __( 'New Publication', 'academa' ),
		'edit_item'             => __( 'Edit Publication', 'academa' ),
		'update_item'           => __( 'Update Publication', 'academa' ),
		'view_item'             => __( 'View Publication', 'academa' ),
		'view_items'            => __( 'View Publications', 'academa' ),
		'search_items'          => __( 'Search Publication', 'academa' ),
		'not_found'             => __( 'Not found', 'academa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'academa' ),
		'featured_image'        => __( 'Featured Image', 'academa' ),
		'set_featured_image'    => __( 'Set featured image', 'academa' ),
		'remove_featured_image' => __( 'Remove featured image', 'academa' ),
		'use_featured_image'    => __( 'Use as featured image', 'academa' ),
		'insert_into_item'      => __( 'Insert into item', 'academa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'academa' ),
		'items_list'            => __( 'Items list', 'academa' ),
		'items_list_navigation' => __( 'Items list navigation', 'academa' ),
		'filter_items_list'     => __( 'Filter items list', 'academa' ),
	);
	$args = array(
		'label'                 => __( 'Publication', 'academa' ),
		'description'           => __( 'Adding publications using bibtex', 'academa' ),
		'labels'                => $labels,
		'supports'              => array('title'),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true
	);
	register_post_type( 'publication', $args );

}
add_action( 'init', 'academa_publication_type', 0 );

function academa_bibtex_mbox(){
  $screens = ['publication'];
  foreach ($screens as $screen) {
    add_meta_box(
      'academa_bibtex_container',
      'Bibtex',
      'academa_bibtex_callback',
      $screen,
			'normal',
			'high'
    );
  }
}

/*
This callback functions generates the HTML for the bibtex meta box
*/
function academa_bibtex_callback($post){
	//academa_save_bibtex is the function which is called when saving the bibtex data
	//academa_bibtex_metabox_nonce is the name of the nonce field
	wp_nonce_field('academa_save_bibtex', 'academa_bibtex_metabox_nonce');
	$value = get_post_meta($post->ID, '_bibtex', true);
  ?>
  <textarea id="academa_bibtex_field" name="academa_bibtex_field" size="25"><?php echo esc_attr($value) ?></textarea>
  <?php

}
add_action('add_meta_boxes', 'academa_bibtex_mbox');


function academa_save_bibtex($post_id){
	if( ! isset($_POST['academa_bibtex_metabox_nonce']) ){
		return;
	}

	if( ! wp_verify_nonce($_POST['academa_bibtex_metabox_nonce'], 'academa_save_bibtex')){
		return;
	}

	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

	if(! current_user_can('edit_post', $post_id)){
		return;
	}

	if(! isset($_POST['academa_bibtex_field'])){
		return;
	}

	// perform validations for validity of bibtex

	$my_data = sanitize_text_field($_POST['academa_bibtex_field']);

	update_post_meta($post_id, '_bibtex', $my_data);
}
add_action( 'save_post', 'academa_save_bibtex');

add_filter('single_template', 'academa_publication_single_template');
function academa_publication_single_template($template){
	global $wp_query, $post;

	if($post->post_type == 'publication') {
		$template = dirname(__FILE__).'/templates/single-publication.php';
	}
	return $template;
}

add_filter('template_include', 'academa_publication_archive_template');
function academa_publication_archive_template($template){
	if(is_post_type_archive(array('publication'))) {
		$template = dirname(__FILE__).'/templates/archive-publication.php';
	}
	return $template;
}
?>
