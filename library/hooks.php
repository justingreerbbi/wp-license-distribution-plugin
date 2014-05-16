<?php
/**
 * License Distribution Hooks
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

// Create a new license 
function ld_create_new_license( $licensee_name, $licensee_email, $product_name, $expiration = ''){
	$new_post = array(
		'post_title' => $licensee_name . ' - '. time(),
		'post_status' => 'private',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => 99999999,
		'post_type' => 'license_distribution'
	);
	$post_id = wp_insert_post($new_post);

	// Add the license information
	$license = ld_generate_license_key();
	add_post_meta( $post_id, "_product_license", $license );
	add_post_meta( $post_id, "_licensee_email", $licensee_email );
	add_post_meta( $post_id, "_licensee_full_name", $licensee_name );
	add_post_meta( $post_id, "_product_name", $product_name );

	$return = new stdClass();
	if($post_id != ''){
		$return->status = "success";
		$return->license_id = $post_id;
		$return->license_key = $license;
		$return->licensee_name = $licensee_name;
		$return->licensee_email = $licensee_email;
		$return->product_name = $product_name;
	}else{
		$return->status = "failed";
	}
	return $return;
}

// Generate License Key
function ld_generate_license_key(){
	$key = md5(uniqid(time()+rand(0,100), true));
	return $key;
}