<?php

$id = $_GET["id"];
//echo $id;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION["username"];
$email = $_SESSION["email"];
$subject = "Application Membership";
$message = "Application for :" . $id;
$message = wordwrap($message,70);
$message = date("d F Y") . "<br> NAME: ".$name. "<br>". "EMAIL: ".$email."<br>"."SUBJECT: ".$subject."<br><br>". $message;
$headers = 'From: contact@biofeedbacksa.co.za' . "\r\n" .
    'Reply-To: contact@biofeedbacksa.co.za' . "\r\n" .
    "Content-Type: text/html; charset=ISO-8859-1\r\n".
    'X-Mailer: PHP/' . phpversion();

$to = "contact@biofeedbacksa.co.za"; 
$subject = "MEMBERSHIP | ".$email; 
$body =$message; 
mail($to, $subject, $body, $headers);

$_SESSION["application_made"] = 1;

header('Location: ../dashboard.php');
?>