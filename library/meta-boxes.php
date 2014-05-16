<?php
/**
 * Install License Distribution
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
if( !defined( 'ABSPATH' ) ){ header("HTTP/1.0 404 Not Found"); exit; }
function init_license_distribution_meta_boxes() {
    new license_distribution_meta_boxes();
}
if ( is_admin() ) {
    add_action( 'load-post.php', 'init_license_distribution_meta_boxes' );
    add_action( 'load-post-new.php', 'init_license_distribution_meta_boxes' );
}

class license_distribution_meta_boxes {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		$this->load_scripts();
	}

	public function load_scripts(){
		wp_enqueue_script( 'license-distribution-javascript' );
	}

	public function add_meta_box( $post_type ) {
            $post_types = array('license_distribution');
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'license_distribution_meta_box',
			'License Information',
			array( $this, 'render_meta_box_content' ),
			$post_type,
			'advanced',
			'high'
		);
            }
	}

	public function save( $post_id ) {
		if ( ! isset( $_POST['license_distribution_nonce_box'] ) )
			return $post_id;

		$nonce = $_POST['license_distribution_nonce_box'];

		if ( ! wp_verify_nonce( $nonce, 'license_distribution_nonce' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		// Full Name
		$sanatized_licensee_full_name = sanitize_text_field( $_POST['licensee_full_name'] );
		update_post_meta( $post_id, '_licensee_full_name', $sanatized_licensee_full_name );

		// Full Email
		$sanatized_licensee_full_name = sanitize_text_field( $_POST['licensee_email'] );
		update_post_meta( $post_id, '_licensee_email', $sanatized_licensee_full_name );

		// Product Name
		$sanatized_product_name = sanitize_text_field( $_POST['product_name'] );
		update_post_meta( $post_id, '_product_name', $sanatized_product_name );

		// Product License
		$sanatized_product_license = sanitize_text_field( $_POST['product_license'] );
		update_post_meta( $post_id, '_product_license', $sanatized_product_license );

		// License Experation
		$sanatized_license_expiration = sanitize_text_field( $_POST['license_expiration'] );
		update_post_meta( $post_id, '_license_expiration', $sanatized_license_expiration );

		// License Suspended
		$sanatized_license_suspended = sanitize_text_field( @$_POST['license_suspended'] );
		update_post_meta( $post_id, '_license_suspended', $sanatized_license_suspended );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Load needed Script
		wp_enqueue_script( 'license-distribution-javascript', plugins_url('/js/functions.js', __FILE__) );
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

		// Nonce
		wp_nonce_field( 'license_distribution_nonce', 'license_distribution_nonce_box' );

		// Meta Data
		$licensee_full_name = get_post_meta( $post->ID, '_licensee_full_name', true );
		$licensee_email = get_post_meta( $post->ID, '_licensee_email', true );
		$product_name = get_post_meta( $post->ID, '_product_name', true );
		$product_license = get_post_meta( $post->ID, '_product_license', true );
		$license_expiration = get_post_meta( $post->ID, '_license_expiration', true );
		$license_suspended = get_post_meta( $post->ID, '_license_suspended', true );
		$isSuspended = false;
		if($license_suspended)
			$isSuspended = true;

		echo '<table>';

		// License Name
		echo '<tr>';
		echo '<td>';
		echo '<label for="licensee_full_name">';
		echo 'Licensee Name';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="licensee_full_name" name="licensee_full_name"';
        echo ' value="' . esc_attr( $licensee_full_name ) . '" size="50" />';
        echo '</td>';
        echo '</tr>';

        // License Email
		echo '<tr>';
		echo '<td>';
		echo '<label for="licensee_email">';
		echo 'Licensee Email';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="licensee_email" name="licensee_email"';
        echo ' value="' . esc_attr( $licensee_email ) . '" size="50" />';
        echo '</td>';
        echo '</tr>';

        // Product Name
        echo '<tr>';
		echo '<td>';
		echo '<label for="product_name">';
		echo 'Product Name';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="product_name" name="product_name"';
        echo ' value="' . esc_attr( $product_name ) . '" size="50" />';
        echo '</td>';
        echo '</tr>';

        // Product License
        echo '<tr>';
		echo '<td>';
		echo '<label for="product_license">';
		echo 'Product License';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="product_license" name="product_license"';
        echo ' value="' . esc_attr( $product_license ) . '" size="50" />';
        echo '<a href="#" onclick="license_distribution_generate_license(); return false;" style="font-size: 12px;">Generate License</a>';
        echo '</td>';
        echo '</tr>';

        // Product Expiration
        echo '<tr>';
		echo '<td>';
		echo '<label for="product_expiration">';
		echo 'License Expiration';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="license_expiration" name="license_expiration"';
        echo ' value="' . esc_attr( $license_expiration ) . '" size="50" placeholder="Leave empty if no expiration"/>';
        echo '</td>';
        echo '</tr>';

        // License Suspended
        echo '<tr>';
		echo '<td>';
		echo '<label for="license_suspended">';
		echo 'License Suspended:';
		echo '</label> ';
		echo '</td>';
		echo '<td>';
		echo '<input type="checkbox" id="license_suspended" name="license_suspended"';
		if($isSuspended){
			echo ' value="1" checked="checked"/>';
		}else{
			echo ' value="1" />';
		}
		echo '</td>';

		echo '</table>';
     
	}
}