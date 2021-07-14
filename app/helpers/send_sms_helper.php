<?php

require_once(__DIR__."/sms/lib/AdnSmsNotification.php");

use AdnSms\AdnSmsNotification;


function send_single_sms($data){

	$message     = $data['message'];
	$recipient   = $data['mobile'];       // For SINGLE_SMS or OTP
	$requestType = 'SINGLE_SMS';    // options available: "SINGLE_SMS", "OTP"
	$messageType = 'UNICODE';         // options available: "TEXT", "UNICODE"

	/*
	* Sending Single SMS or OTP with sendSms() method
	* ----------
	* Params:
	* ----------
	* $requestType   : Required, Must contain any of the two values: "SINGLE_SMS", "OTP"
	* $message       : Required
	* $recipient     : Required
	* $messageType   : Must contain any of the two values: "TEXT", "UNICODE"
	*/

	$sms = new AdnSmsNotification();
	$sms->sendSms($requestType, $message, $recipient, $messageType);
}

function bulk_sms($data){
	
	$message =  $data['message'];
	$recipient= $data['recipient']; // For bulk sms i.e. general campaign 

	$requestType = 'GENERAL_CAMPAIGN';
	$messageType = 'UNICODE'; // option available: "TEXT", "UNICODE"
	$campaignTitle = $data['message_title']; // set a meaningful campaign title

	/*
	* Sending SMS with sendBulkSms() method
	* ---------
	* Params:
	* ---------
	* $message       : Required
	* $recipient     : Required
	* $messageType   : Must contain any of the two values: "TEXT", "UNICODE"
	* $campaignTitle : Required
	*/
	$sms = new AdnSmsNotification();
	$sms->sendBulkSms($message, $recipient, $messageType, $campaignTitle);
}

