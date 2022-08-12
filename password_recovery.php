<?php


include 'connection.php';

$user_email_address = $_POST['email'];



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.sendgrid.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'platletedonate@gmail.com';                     //SMTP username
    $mail->Password   = 'nbsg2022';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('platletedonate@gmail.com', 'platletedonate');

    $mail->addAddress($user_email_address, 'User');     //Add a recipient
   
    $mail->addReplyTo('platletedonate@gmail.com', 'platletedonate');


    //Content
    $mail->IsHTML(true);
    $mail->Subject = "nb-sg platlete donate Password Recovery"; // Email subject 
    $mail->Body = 'Hello! <br>
                    Someone has requested a link to change your password. 
                    You can do this through the link below.<br>
                    <a href=http://localhost/Code/password_email_recovery_form.php> Change my password </a>.
    
                    If you didn\'t request this, please ignore this email.<br>
    
                    Your password won\'t change until you access the link above and create a new one.';

    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>