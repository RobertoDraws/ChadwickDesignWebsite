<?php
///////////////////////////// TO BE REPLACED WITH USERS SETTINGS - START //////////////////////////////////
$mails_assoc = array(
"ContactForms3" => "roberto@chadwickdesign.net",

"ContactForms2" => "roberto@chadwickdesign.net",

"ContactForms1" => "roberto@chadwickdesign.net",
);

$phpmails_assoc = array(
"ContactForms3" => "admin@chadwickdesign.net"
);

///////////////////////////// TO BE REPLACED WITH USERS SETTINGS - END //////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__) . '/swift_mail/swift_required.php';
// Create the Transport
$transport = Swift_MailTransport::newInstance();

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

//specify the email address you are sending to, and the email subject
$email = $mails_assoc[$_POST["contactForm"]];
if (!isset($email)) {
	echo "0";
}

//Plain text body
$plain_text_mail = '';
$plain_text_mail = (isset($_POST["useautoresponse"]) && $_POST["useautoresponse"] === true) ? file_get_contents('plain_text_autoresponse.php') : file_get_contents('plain_text_mail.php');
$formdataString = "";
$obj = $_POST["formdata"];

foreach ($obj as $prop => $value) {
	if ($prop == 'name') {
		$plain_text_mail = str_replace("@name", $value, $plain_text_mail);
	}

	if ($prop == 'message') {
		$plain_text_mail = str_replace("@message", $value, $plain_text_mail);
	}

	if ($prop != 'captcha' && $prop != 'message') {
		$formdataString .= $prop . " : " . $value . "\r";
	}

}
$plain_text_mail = str_replace("@contact_details", $formdataString, $plain_text_mail);

//Html body
$html_mail = '';
$html_mail .= (isset($_POST["useautoresponse"]) && $_POST["useautoresponse"] === true) ? file_get_contents('html_autoresponse.php') : file_get_contents('html_mail.php');
$formdataString = "";
foreach ($obj as $prop => $value) {
	if ($prop == 'name') {
		$html_mail = str_replace("@name", $value, $html_mail);
	}

	if ($prop == 'message') {
		$html_mail = str_replace("@message", nl2br($value), $html_mail);
	}

	if ($prop != 'captcha' && $prop != 'message') {
		$formdataString .= '<tr><td align="left" style="font-family: arial,sans-serif; font-size: 14px; font-weight:bold; line-height: 20px !important; color: #00C2FF; padding-bottom: 20px;border-top:1px solid #ccc;padding-top:20px;">' . $prop . ':&nbsp; <span style="color: #000000;">' . $value . '</td></tr>';
	}

}
$html_mail = str_replace("@contact_details", $formdataString, $html_mail);

$defaultFrom = ini_get('sendmail_from');
if ($defaultFrom) {
	$from = $defaultFrom;
} else {
	$from = @$phpmails_assoc[$_POST["contactForm"]];
	if(empty($from)) { 
		if (!empty($phpmails_assoc)) {
		  $from_arr = array_values($phpmails_assoc);
		  $from = $from_arr[0];
		}
	}
}
if (empty($from)) {
	$from = 'admin@' . str_replace("www.", "", $_SERVER['SERVER_NAME']);
}
// Create a message
$message = Swift_Message::newInstance('Contact form message')
	->setFrom(array($from => 'Website Contact Form'))
	->setTo(array($email))
	->setBody($html_mail, 'text/html')
	->addPart($plain_text_mail, 'text/plain');

if ($mailer->send($message)) {
	echo "1";
} else {
	// fallback to admin@domain;
	$from = 'admin@' . str_replace("www.", "", $_SERVER['SERVER_NAME']);
	$message->setFrom(array($from => 'Website Contact Form'));
	if ($mailer->send($message)) {
		echo "1";
	} else {
		$_subject = 'Contact form message';
		$_header = 'MIME-Version: 1.0' . "\r\n";
		$_header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$_header .= 'From: Website Contact Form <' . $from . '>' . "\r\n";
		$mailerResponse = mail($email, $_subject, $html_mail, $_header);
		if ($mailerResponse) {
			echo "1";
		} else {
			echo "00";
		}
	}
}
