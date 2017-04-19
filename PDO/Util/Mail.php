<?php
/**
 * This example shows sending a message using PHP's mail() function.
 */

require 'PHPMailerAutoload.php';

class Notificacion {

	private $mail;
	private $correoEditorial = 'editorial@editorial.com';

	public funtion_construct(){		
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Set who the message is to be sent from
		$mail->setFrom('from@example.com', 'First Last');
		//Set an alternative reply-to address
		$mail->addReplyTo('replyto@example.com', 'First Last');
	}

	public function enviarNotificacion($para){
		//Set who the message is to be sent to
		$mail->addAddress('whoto@example.com', 'John Doe');
		//Set the subject line
		$mail->Subject = 'PHPMailer mail() test';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		//Replace the plain text body with one created manually
		$mail->AltBody = NOTIFICACIONARTICULO;
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
}



?>