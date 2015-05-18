<?php
/**
 * Plugin Name: Email Login Attempts
 * Version:     1.1.1
 * Plugin URI:  http://cazimiweb.com/plugin/email-login-attempts
 * Description: This plugin will send an email whenever a someone tries to login via the wordpress login page. 
 * Author:      Alfredo Sanchez Jr
 * Author URI:  http://sanchez.org.ph
 */

add_action( 'plugins_loaded', 'ela_check_login' );

// TODO: add admin page
/*
function login_attempts_menu() {
	add_options_page( 'eMail Login Attempts', 'Login Attempts', 'manage_options', 'login_attempts', 'ela_login_attempts_options' );
}

function ela_login_attempts_options() {
	if ( !isadmin() )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	echo '<div class="wrap">';
	echo '<h2>eMail Login Attempts Settings</h2>';
	echo '<table class="form-table">';
	echo '<tbody>';
	echo '<tr>';
	echo '<th scope="row">Send to Wordpress Admin</th>';
	echo '<td><input name="email_admin" type="checkbox" value="1" checked/>'. $admin_email .'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th scope="row">Additional Recepients</th>';
	echo '<td><input name="recepients" type="text" value="1" checked/>';
	echo '<small>Separate email addresses with comma.</small></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th scope="row">Sender Email</th>';
	echo '<td><input name="recepients" type="text" value="1" checked/>';
	echo '<small>Separate email addresses with comma.</small></td>';
	echo '</tr>';

	echo '</tbody';
	echo '</table>';
	echo '</div>';

	if(hasrecepients()){
		$to = $admin_email.','.$recepients;
	} else {
		$to = $admin_email;
	}
}
add_action( 'admin_menu', 'ela_login_attempts_menu' );
*/
function ela_send_email()
{
	global $current_user;
    get_currentuserinfo();

    $admin_email = get_option("admin_email");

    $to = $admin_email;
    $from = $admin_email;	
    $headers = "From: $admin_email";
    $subject = 'Login Attempt: WordPress login alert from '.ela_get_client_ip();

    $message = "Website: ".get_bloginfo("wpurl")."\r\nTime: ".ela_get_login_time()."\r\nIP: ".ela_get_client_ip()."\r\nUser: ".htmlentities($_POST['log'])."\r\n";

	$success = wp_mail($to,$subject,$message,$headers);
	if ($success) 
	{
		ela_log_me("mail sent");
		ela_log_me($message);
	}
	else 
	{
		ela_log_me("error on send");
	}
}
/*
function ela_isadmin(){
	if ( current_user_can( 'manage_options' ) )  {
		return true;
	} else {
		return false;
	}
}
*/
function ela_get_login_time()
{
	return date('l, F j, Y g:i a');
}
function ela_get_client_ip()
{
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) 
    {
        if (array_key_exists($key, $_SERVER) === true) 
        {
            foreach (explode(',', $_SERVER[$key]) as $ip) 
            {
                $ip = trim($ip);
                if (ela_validate_ip($ip)) 
                {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}
function ela_validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) 
    {
        return false;
    }
    return true;
}
function ela_log_me($message) 
{
    if (WP_DEBUG === true) 
    {
        if (is_array($message) || is_object($message)) 
        {
            error_log(print_r($message, true));
        } else 
        {
            error_log($message);
        }
    }
}
function ela_check_login()
{
	if( isset($_POST['log']))
	{
		ela_send_email();	
	}
}


