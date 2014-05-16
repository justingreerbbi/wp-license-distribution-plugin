<?php
/**
 *  License Distribution Post Types
 *
 * @author Justin Greer Interactive, LLC
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
*/
function create_license_distribution_post_type() {
  $labels = array(
    'name'               => 'Licenses',
    'singular_name'      => 'License',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New License',
    'edit_item'          => 'Edit License',
    'new_item'           => 'New License',
    'all_items'          => 'All Licenses',
    'view_item'          => 'View License',
    'search_items'       => 'Search Licenses',
    'not_found'          => 'No Licenses Found',
    'not_found_in_trash' => 'No License Found in Trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Licenses'
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'license_distribution' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => true,
    'menu_position'      => null,
    'supports'           => array( 'title' )
  );

  register_post_type( 'license_distribution', $args );
}
add_action( 'init', 'create_license_distribution_post_type' );

// Remove permalink for license_distribution
add_action('admin_init', 'license_distribution_remove_permalink');
function license_distribution_remove_permalink() {
    if(isset($_GET['post'])) {
        $post_type = get_post_type($_GET['post']);
        if($post_type == 'license_distribution' && $_GET['action'] == 'edit') {
            echo '<style>#edit-slug-box{display:none;}</style>';
        }
    }
}