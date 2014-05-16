<?php
/**
 * License Distribution Install
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

register_activation_hook( __FILE__, 'license_distribution_install');
function license_distribution_install(){
	$license_distribution_settings['license_distribution_settings'];
	$license_distribution_settings['license_distribution_settings']['activation_status'] = 'not_activated';
	$license_distribution_settings['license_distribution_settings']['authorization_key'] = '';
	//delete_option('license_distribution_settings'); 
	//add_option('license_distribution_settings', $license_distribution_settings);
}