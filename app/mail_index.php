<?php

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["targets"]) or !isset($_SESSION["email_message"]) or !isset($_SESSION["email_subject"])) {
    die(json_encode(["status" => "invalid", "message" => "Email requirements are not met!"]));
}

$message_to_send = $_SESSION["email_message"];
$email_subject = $_SESSION["email_subject"];


//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV["EMAIL"];                         //SMTP username
    $mail->Password   = $_ENV["STMP_PASSWORD"];                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV["EMAIL"], 'Soutenance');

    if (!$_SESSION["targets"]) die(json_encode(["status" => "no_address", "msg" => "Couldn't find emails address"]));
    foreach($_SESSION["targets"] as $member) {
        $mail->addAddress($member);            //Add a recipient
    }
    
    //Content
    $body = $message_to_send;


    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $email_subject;
    $mail->Body    = $body;
    $mail->AltBody = htmlspecialchars($message_to_send);

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Email have been sent successfully!"]);
} catch (Exception $e) {
    echo json_encode(["status" => "err_msg", "message" => "An error happend while sending email, please report it to the admin!"]);
}


