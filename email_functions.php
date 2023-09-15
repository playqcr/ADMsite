<?php
/****************************************************
****   QCR Intranet Project                       ***
****   Designed by: Tom Moore                     ***
****   Written by: Tom Moore                      ***
****   (c) 2008 TEEMOR eBusiness Solutions        ***
****************************************************/
require('email_settings.php');

function hesk_mail($to,$subject,$message){
	global $email_settings, $hesklang;

    // Empty recipient?
    if($to == ''){
        return true;
    }

    // Stop if we find anything suspicious in the headers
    if(preg_match("/\n|\r|\t|%0A|%0D|%08|%09/", $to.$subject)){
        return false;
    }

    // Remove duplicate recipients
    $to_arr = array_unique(explode(',', $to));
    $to_arr = array_values($to_arr);
    $to = implode(',', $to_arr);

    // Use PHP's mail function
	if(!$email_settings['smtp']){
    	// Set additional headers
		$headers = "From: $email_settings[from_header]\n";
		$headers.= "Reply-To: $email_settings[from_header]\n";
		$headers.= "Return-Path: $email_settings[webmaster_mail]\n";
		$headers.= "Date: ".date(DATE_RFC2822)."\n";
        $headers.= "Message-ID: ".hesk_generateMessageID()."\n";
        $headers.= "MIME-Version: 1.0\n";
		$headers.= "Content-Type: text/plain; charset=".$hesklang['ENCODING'];

		// Send using PHP mail() function
        ob_start();
		mail($to,$subject,$message,$headers);
        $tmp = trim(ob_get_contents());
        ob_end_clean();

        return (strlen($tmp)) ? $tmp : true;
    }

    // Use a SMTP server directly instead
	$smtp = new smtp_class;
	$smtp->host_name	= $email_settings['smtp_host_name'];
	$smtp->host_port	= $email_settings['smtp_host_port'];
	$smtp->timeout		= $email_settings['smtp_timeout'];
    $smtp->ssl			= $email_settings['smtp_ssl'];
    $smtp->start_tls	= $email_settings['smtp_tls'];
	$smtp->user			= $email_settings['smtp_user'];
	$smtp->password		= $email_settings['smtp_password'];
    $smtp->debug		= 1;

    // Start output buffering so that any errors don't break headers
    ob_start();

    // Send the e-mail using SMTP
	if(!$smtp->SendMessage($email_settings['noreply_mail'], $to_arr, array(
			"From: webmaster@playqcr.com",
			"To: $to",
			"Reply-To: webmaster@playqcr.com",
			"Return-Path: $email_settings[webmaster_mail]",
			"Subject: " . $subject,
			"Date: " . date(DATE_RFC2822),
			"Message-ID: 1",
			"MIME-Version: 1.0",
			"Content-Type: text/plain; charset=" . $hesklang['ENCODING']
		), $message)){
		// Suppress errors unless we are in debug mode
		if($email_settings['debug_mode']){
			$error = $hesklang['cnsm'].' '.$to.'<br /><br />'.
					 $hesklang['error'].': '.htmlspecialchars($smtp->error).'<br /><br />'.
					 '<textarea name="smtp_log" rows="10" cols="60">'.ob_get_contents().'</textarea>';
			ob_end_clean();
			hesk_error($error);
		}else{
			$_SESSION['HESK_2ND_NOTICE']  = true;
            $_SESSION['HESK_2ND_MESSAGE'] = $hesklang['esf'].' '.$hesklang['contact_webmsater'].' <a href="mailto:'.$email_settings['webmaster_mail'].'">'.$email_settings['webmaster_mail'].'</a>';
        }
    }
    ob_end_clean();
	return true;
} // END hesk_mail()

function hesk_encodeIfNotAscii($str, $escape_header = false){
    // Match anything outside of ASCII range
    if(preg_match('/[^\x00-\x7F]/', $str)){
        return "=?UTF-8?B?".base64_encode($str)."?=";
    }

    // Do we need to wrap the header in double quotes?
    if($escape_header && preg_match("/[^-A-Za-z0-9!#$%&'*+\/=?^_`{|}~\\s]+/",$str)){
        return '"'.str_replace('"','\\"', $str).'"';
    }
    return $str;
} // END hesk_encodeIfNotAscii()
