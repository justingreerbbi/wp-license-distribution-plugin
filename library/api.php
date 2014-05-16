<?php
/**
 * License Distribution Public API
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

add_filter( 'rewrite_rules_array','my_insert_rewrite_rules' );
add_filter( 'query_vars','my_insert_query_vars' );
add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );
	if ( ! isset( $rules['license-validation/([^/]+)/?$'] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
}

// Adding a new rule
function my_insert_rewrite_rules( $rules ){
	$newrules = array();
	$newrules['license-validation/([^/]+)/?$'] = 'index.php?license-validation=$matches[1]';
	return $newrules + $rules;
}

// Adding the id var so that WP recognizes it
function my_insert_query_vars( $vars ){
    array_push($vars, 'license-validation');
    return $vars;
}

// Public API Action for License Validation
function license_validation_plublic_api() {
    global $wp_query;
    if(isset($wp_query->query_vars['license-validation'])) {
        $license = get_query_var('license-validation');
        global $wpdb;
        $prepare = $wpdb->prepare("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_product_license' AND meta_value = '%s'", $license);
        $validate = $wpdb->get_row( $prepare );

        $activeButNotValid='';
        $expiration = get_post_meta( $validate->post_id, '_license_expiration', true);
        $isSuspended = get_post_meta( $validate->post_id, '_license_suspended', true);

        if($isSuspended){
        	$activeButNotValid = "license is suspended.";
        }

        if($expiration != ''){
        	$expires = strtotime($expiration);
        	$now =  strtotime(date("d-m-Y"));
        	if( $now>$expires )
        		$activeButNotValid = "license has expired.";
        }

        if(!$validate)
        	$activeButNotValid = "license unauthorized";

        if( $validate  && $activeButNotValid == ''){
			$output = array("isValid" => true);	
        }else{
        	$output = array("isValid" => false, 'message' => $activeButNotValid);	
        }

        // Header Content Type
        header('Content-type: application/json');
        print json_encode( $output );
        exit;
    }
}
add_action( 'template_redirect', 'license_validation_plublic_api');


