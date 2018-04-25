<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


function sendEmail($email, $header, $message, $boolhtmlmessage) {
/*  Below is for local testing
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "ctnursetraining@gmail.com";
    $mail->Password = "Fairfield";
    $mail->setFrom('ctnursetraining@gmail.com', 'Nurse Training');
    $mail->addAddress($email, 'CT Nurse Training');
    $mail->Subject = $header;
    $mail->Body    = $message;
    $mail->IsHTML($boolhtmlmessage);
    //$mail->AltBody = convert_html_to_text($htmlmessage);
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
*/    

/* Below is for the production server */
	$to = $email;
	$subject = $header;
	$txt = $message;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: team2@sw516.com" . "\r\n" .	"CC: ctnursetraining@gmail.com";
	mail($to,$subject,$txt,$headers);
}

