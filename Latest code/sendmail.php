<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendEmail($email, $header, $message, $boolhtmlmessage) {
     echo '<p>sendEmail Start</p>'; 
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "ctnursetraining@gmail.com";
    $mail->Password = "Fairfield";
    $mail->setFrom('ctnursetraining@gmail.com.com', 'Nurse Training');
    $mail->addAddress($email, 'CT Nurse Training');
    $mail->Subject = $header;
    $mail->Body    = $message;
    $mail->IsHTML($htmlmessage);
    //$mail->AltBody = convert_html_to_text($htmlmessage);
     echo '<p>sendEmail Sending</p>';
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}

