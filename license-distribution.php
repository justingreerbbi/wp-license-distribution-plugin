<?php
/**
 * Plugin Name: License Distribution
 * Plugin URI: http://justin-greer.com
 * Version: 1.0.1
 * Description: Gives the functionality to distribute , manage and validate licenses for your software and programs.
 * Author: <a href="http://justin-greer.com" target="_blank">Justin Greer Interactive, LLC</a>
 * Author URI: http://justin-greer.com
 * License: GPL2
 *
*/
/*  Copyright 2013  Justin Greer  (email : justin@justin-greer.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if( !defined( 'ABSPATH' ) ){ header("HTTP/1.0 404 Not Found"); exit; }

// Install License Distribution
require_once( dirname(__FILE__) . '/library/install.php');

// Post Type Registration
require_once( dirname(__FILE__) . '/library/post-types.php');

// Meta Boxes
require_once( dirname(__FILE__) . '/library/meta-boxes.php');

// Hooks
require_once( dirname(__FILE__) . '/library/hooks.php');

// Public API
require_once( dirname(__FILE__) . '/library/api.php');