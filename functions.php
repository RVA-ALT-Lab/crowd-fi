<?php

add_theme_support('post-thumbnails');
// Add custom styles and scripts
// Add custom taxonomy for map points
function create_taxonomy() {
    register_taxonomy(
        'map-point-category',
        array('map-point'),
        array(
            'label' => __('Map Point Category'),
            'rewrite' => array('slug' => 'map-point-category'),
            'capabilities' => array(
                'assign_terms' => 'list_users',
                'edit_terms' => 'list_users',
                'manage_terms' => 'list_users',
                'delete_terms' => 'list_users',
            ),
            'public' => true,
            'show_in_rest' => true,
            'query_var' => true
            )
        );
}

add_action('init', 'create_taxonomy');

// Create custom post types for mapping theme
function create_posttype() {
    register_post_type( 'map-point',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Map Points' ),
                'singular_name' => __( 'Map Point' )
            ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'comments',
                'author',
                'revisions',
                'custom-fields'
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'map-point'),
            'taxonomies' => array('map-point-category'),
            'show_in_rest' => true
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

//Add lat/long custom fields to REST API

add_action('rest_api_init', function(){
    $object_type = 'post';
    $latLngArgs = array( // Validate and sanitize the meta value.
        // Note: currently (4.7) one of 'string', 'boolean', 'integer',
        // 'number' must be used as 'type'. The default is 'string'.
        'type'         => 'string',
        // Shown in the schema for the meta key.
        'description'  => 'A meta key associated with a string meta value.',
        // Return a single value of the type.
        'single'       => true,
        // Show in the WP REST API response. Default: false.
        'show_in_rest' => true,
    );
    register_meta( $object_type, 'latitude', $latLngArgs );
    register_meta( $object_type, 'longitude', $latLngArgs );
});

// Collect Current User Info


function map_tool_add_scripts () {

    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_register_script('vue_js', get_template_directory_uri() . '/dist/main.js', null, null, true );
    wp_enqueue_script('vue_js');
    wp_localize_script('vue_js', 'WP_OPTIONS', array(
      'google_api_key' => get_option('map_general_options')['google_maps_api_key'],
      'siteurl' => get_option('siteurl')
  ));

}

add_action( 'wp_enqueue_scripts', 'map_tool_add_scripts' );


// Here we bootstrap all of the pages necessary to display the map tool elements
// without any configuration
// This should be /add-point, /map, /points
// The root index / should automatically use <front-page class="php">
// programmatically create some basic pages, and then set Home and Blog
// setup a function to check if these pages exist
function the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}
// create the map page
if (isset($_GET['activated']) && is_admin()){
    $map_page_title = 'Map';
    $map_page_content = 'This is a placeholder for the map page. Nothin you put here will be shown.';
    $map_page_check = get_page_by_title($map_page_title);
    $map_page = array(
	    'post_type' => 'page',
	    'post_title' => $map_page_title,
	    'post_content' => $map_page_content,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'map'
    );
    if(!isset($map_page_check->ID) && !the_slug_exists('map')){
        $map_page_id = wp_insert_post($map_page);
        update_post_meta( $map_page_id, '_wp_page_template', 'map.php' );

    }
}
// create the points page
if (isset($_GET['activated']) && is_admin()){
    $points_page_title = 'Points';
    $points_page_content = 'This is a placeholder for the map points page. Nothing you put here will be shown.';
    $points_page_check = get_page_by_title($points_page_title);
    $points_page = array(
	    'post_type' => 'page',
	    'post_title' => $points_page_title,
	    'post_content' => $points_page_content,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'points'
    );
    if(!isset($points_page_check->ID) && !the_slug_exists('points')){
        $points_page_id = wp_insert_post($points_page);
        update_post_meta( $points_page_id, '_wp_page_template', 'points.php' );
    }
}
// create add point page
if (isset($_GET['activated']) && is_admin()){
    $add_point_page_title = 'Add Point';
    $add_point_page_content = 'This is a placeholder for the add point page. Nothing you put here will be shown.';
    $add_point_page_check = get_page_by_title($add_point_page_title);
    $add_point_page = array(
	    'post_type' => 'page',
	    'post_title' => $add_point_page_title,
	    'post_content' => $add_point_page_content,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'add-point'
    );
    if(!isset($add_point_page_check->ID) && !the_slug_exists('add-point')){
        $add_point_page_id = wp_insert_post($add_point_page);
        update_post_meta( $add_point_page_id, '_wp_page_template', 'add-point.php' );
    }
}

// change the Sample page to the home page
if (isset($_GET['activated']) && is_admin()){
    $home_page_title = 'Home';
    $home_page_content = '';
    $home_page_check = get_page_by_title($home_page_title);
    $home_page = array(
	    'post_type' => 'page',
	    'post_title' => $home_page_title,
	    'post_content' => $home_page_content,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'ID' => 2,
	    'post_slug' => 'home'
    );
    if(!isset($home_page_check->ID) && !the_slug_exists('home')){
        $home_page_id = wp_insert_post($home_page);
    }
}

if (isset($_GET['activated']) && is_admin()){
	// Set the blog page
	$blog = get_page_by_title( 'Blog' );
	update_option( 'page_for_posts', $blog->ID );

	// Use a static front page
	$front_page = 2; // this is the default page created by WordPress
	update_option( 'page_on_front', $front_page );
	update_option( 'show_on_front', 'page' );
}


/***
 *
 * Start Theme Settings Stuff Here
 *
 ***/
add_action('admin_menu', 'map_create_menu_page');

function map_create_menu_page () {
    add_submenu_page('themes.php', 'map-tool', 'Map Tool Settings', 'list_users', 'map-tool', 'create_map_settings_menu');
}

function create_map_settings_menu (){
    require 'map-options-menu.php';
}

add_action('admin_init', 'map_create_settings');

function map_create_settings (){

    register_setting('map_general_options', 'map_general_options', 'map_validate_settings');
    add_settings_section( 'text_section', 'General Options', 'map_display_section', 'map-tool' );
    $field_args = array(
        'type'      => 'text',
        'id'        => 'google_maps_api_key',
        'name'      => 'google_maps_api_key',
        'desc'      => 'Add your google maps API key here',
        'std'       => '',
        'label_for' => 'google_maps_api_key',
        'class'     => 'css_class'
      );

    add_settings_field( 'google_maps_api_key', 'Google Maps API Key', 'map_display_setting', 'map-tool', 'text_section', $field_args );
}

function map_validate_settings($input)
{

    if (isset($input)){
        foreach($input as $k => $v)
        {
            $newinput[$k] = trim($v);

            // Check the input is a letter or a number
            if(!preg_match('/^[A-Z0-9 _]*$/i', $v)) {
            $newinput[$k] = '';
            }
        }

        return $newinput;
    }
}

function map_display_section($section){

    }

function map_display_setting($args)
{
    extract( $args );

    $option_name = 'map_general_options';

    $options = get_option( $option_name );

    switch ( $type ) {
          case 'text':
              $options[$id] = stripslashes($options[$id]);
              $options[$id] = esc_attr( $options[$id]);
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
              break;
          case 'checkbox':
             if (isset($options[$id])){
              $options[$id] = stripslashes($options[$id]);
              $options[$id] = esc_attr( $options[$id]);
              $checked = checked('1', $options[$id], false);
             } else {
                 $checked = '';
             }
              echo "<input class='$class' type='checkbox' id='$id' name='" . $option_name . "[$id]' value='1'". $checked ."/>";
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
          break;
    }
}



?>