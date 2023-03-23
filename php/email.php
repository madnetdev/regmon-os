<?php // Email Function

require (__DIR__.'/../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function SendEmail($EmailTo, $Subject, $Message) {
	global $CONFIG;
	$CE = $CONFIG['EMAIL'];

	if ($CE['Username'] == '' OR $CE['Username'] == 'email@domain.com' OR
		$EmailTo == '' OR $EmailTo == 'email@domain.com') {
		echo ('Please change Demo Email accounts "email@domain.com"<br>');
		error_log('Please change Demo Email accounts "email@domain.com"');
		return 'ERROR';
	}

	//TODO: @@@@@ this need to go to configuration
	date_default_timezone_set('Europe/Berlin');

	///////////////////////////////////////////////////////////////////////////
	$mail             = new PHPMailer(true);
	$mail->IsSMTP(); 								// telling the class to use SMTP
	$mail->SMTPAuth   = true;               	 	// enable SMTP authentication
	//$mail->SMTPDebug  = 2; // enables SMTP debug information	1=errors and messages  2=messages only
	
	//for PHP Fatal error:  Uncaught PHPMailer\\PHPMailer\\Exception: SMTP Error: Could not connect to SMTP host.
	//and for self sign certificate uncomment this
	/*$mail->SMTPOptions = array ( 
		'ssl' => array(
			'verify_peer'  => false,
			'verify_peer_name'  => false,
			'allow_self_signed' => true
		)
	);*/
	$mail->Host       = $CE['Host']; // sets the SMTP server (localhost)
	$mail->SMTPSecure = $CE['SMTPSecure']; //('ssl', 'tls')
	$mail->Port       = $CE['Port']; // set the SMTP port for the server (25, 465 or 587)
	$mail->Username   = $CE['Username']; // SMTP account username
	$mail->Password   = $CE['Password']; // SMTP account password
	$mail->CharSet    = $CE['CharSet']; //'utf-8'
	$mail->SetFrom($CE['Username'], $CE['From_Name']);
	//$EmailTo can be an array comma seperated
	//$mail->AddAddress($EmailTo);
	array_map(array($mail, 'AddAddress'), explode(',', $EmailTo));

	$mail->Subject = $Subject;
	$mail->MsgHTML($Message);

	try {
		if(!$mail->Send()) {
			return 'ERROR';
		} else {
			return 'OK';
		}
	}
	catch (Exception $e) {
		//if (!substr_count($e->errorMessage(), 'client has exceeded the configured limit')) {}
		error_log($e->errorMessage());
		return $e->getMessage(); //Boring error messages from anything else!
	}
}
?>