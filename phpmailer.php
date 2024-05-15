<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
function sendmail($tomail, $totmailname , $subject, $message)
{
	include("dbconnection.php");
	$sqledit = "SELECT * FROM mail_setting where settingtype='SMTP'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
	$smtpdetails = unserialize($rsedit['settingdetails']);
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	// Load Composer's autoloader
	echo "<pre>11";
	print_r($smtpdetails);
	echo "</pre>";
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try
	{
		//Server settings
		$mail->SMTPDebug = false; // SMTP::DEBUG_SERVER; // Enable verbose debug output
		$mail->isSMTP();          // Send using SMTP
		$mail->Host       = $smtpdetails['smtpserver']; // Set the SMTP server to send through
		$mail->SMTPAuth   = true;  // Enable SMTP authentication
		$mail->Username   = $smtpdetails['loginid']; // SMTP username
		$mail->Password   = $smtpdetails['password'];  // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$mail->Port       = $smtpdetails['smtpport'];
		$mail->SMTPOptions = array (
			'ssl' => array (
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		//Recipients
		$mail->setFrom($smtpdetails['loginid'], $smtpdetails['mailsender']);
		$mail->addAddress($tomail, $totmailname);     // Add a recipient
		$mail->addAddress($tomail);               // Name is optional
		$mail->addReplyTo($tomail, $totmailname);
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		// Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		// Content
		$mail->isHTML(true);        // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = 'Mail Receieved';

		$mail->send();
		//	echo 'Message has been sent';
	}
	catch (Exception $e) 
	{
		echo "Message could not be sent. Mailer Error: {
			$mail->ErrorInfo}";
	}
}
//sendmail("studentprojects.live@gmail.com", "Shiva Prasad", "Hello", "Thank you");
?>