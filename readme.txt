=== License Distribution ===
Contributors: justingreerbbi
Donate link: http://justin-greer.com/
Tags: license, license distribution
Requires at least: 3.8
Tested up to: 3.8
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows your WordPress website to manage, distribute and validate licenses for your desktop  software, mobile apps and web applications.

== Description ==

This plugin allows you to manage, distribute and validate licenses for your software and programs that your sell or simple just require a license for. This plugin is super easy to use and comes with a simple API that allows you to create a license on the fly using one simple function. 

Features:

* Secure license validation using the HTTP/HTTPS API which returns JSON for cross platform use (Software, Scripts, Plugins, Themes, Apps).
* Create a license using WordPress admin or use the API to create a license on the fly.
* Ability to suspend a license.
* Ability to add an expiration for a license (perfect for 30 day trials).

= How to use =

To validate a license you will use the HTTP/HTTPS API. Make a call to 
`
http://yourwebsite.com/license-validation/license-key-here
`

The return of the API will present JSON object containing information about the license.

If the license is valid, the response will look like below
`
{"isValid": true}
`

If the license is invalid, expired or suspended the following response will be presented

`
{"isValid":false,"message":"Message-why-the-license-failed"}
`

Full documentation is coming soon. The plugin will be updated with links shortly when the documentation is finished. Until then you can contact, justin@justin-greer.com questions or concerns.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `License Distribution` plugin to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a license manually just like you would create a post or use the API hook to create a license of the fly

== Frequently Asked Questions ==

= How to create a license using the API hook =

The License distribution plugin comes two main ways to create a license. To use the API hook, you simply make sure the plugin is installed and activated. You then can use the API hook to create a license on the fly. 

`
// $createLicense = ld_create_new_license( $licensee_name, $licensee_email, $product_name);
$create_license = ld_create_new_license( 'Justin Greer', 'justin@justin-greer.com', 'Test Product');
`

The above function will create a license for "Justin Greer" and the product "Test Product". The function also returns information about the license which you can use to send or display to the user. Refer to the documentation for more details on how to use `ld_create_new_license()`.

= Does the plugin send notification emails when a license is created? =

Short answer, No. The plugin is meant to be bare bones so you can integrate seamlessly how you need it. With this said, I do plan on added email notifications in future releases.

= How do I validate a license in my products =

To validate a license you will use the HTTP/HTTPS API. Make a call to 
`
http://youwebsite.com/icense-validation/license-key-here
`

The return of the API will present JSON object containing information about the license.

If the license is valid the response will look like below
`
{"isValid": true}
`

If the license is invalid, expired or suspended the following response will be presented

`
{"isValid":false,"message":"Message-why-the-license-failed"}
`

== Screenshots ==

1. Create a new license just like you would create post or page. Almost No learning curve.

== Changelog ==

= 1.0.0 =
* Initial Build

= 1.0.1 =
* Patch for header issue when calling API

== Upgrade Notice ==

= 1.0.0 =
	Nothing because it is the first time you will be installing.

== Arbitrary section ==

If you modify the plugin with features that you feel would be good for future releases please feel free to contact me and share the love.