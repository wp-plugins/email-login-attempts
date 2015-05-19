=== Plugin Name ===
Contributors: tildemark
Donate link: 
Tags: email, login, alerts, security, brute force, login attempt
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will send an email whenever a someone tries to login via the WordPress login page.

== Description ==

This plugin will send an email whenever a someone tries to login via the WordPress login page.

= Todos =

*   Add admin page
*   Specify recipient email addresses
*   determine if failed or success login attempt
*   Limit login attempts before sending email
*   Do not send email on Whitelisted ip addresses
*   Ability provide or change the default sender address
*   Ability to block IP addresses
*   Determine the location where the IP is coming from
*   open to suggestions

== Installation ==

1. Upload `email-login-attempts` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Test the plugin by logging out and logging back in your wordpress install

== Frequently Asked Questions ==

= I did not receive any email notice =

If you are using free email accounts, chances are your client has marked the emails as spam, please check your spam folders.

== Screenshots ==
1. Email alert as seen via the GMail email client.

== Changelog ==

= 1.1.1 =
* Fixed bug, user name not listed on email

= 1.1 =
* Initial release.
