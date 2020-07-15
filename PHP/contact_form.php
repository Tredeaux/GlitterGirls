<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }

    $name = strtolower(trim($_POST["name"]));
    $email = (trim($_POST["email"]));
    $subject = (trim($_POST["subject"]));
    $message = ($_POST["message"]);
    $message = wordwrap($message,70);
    $message = "<h1>Website Query</h1>"."<strong>NAME: </strong>".$name. "<br>". "<strong>EMAIL: </strong>".$email."<br>"."<strong>SUBJECT: </strong>".$subject."<br><hr><br>". $message . "<hr>" . date("d F Y");
    $headers = 'From: contact@glittergirls.co.za' . "\r\n" .
        'Reply-To: contact@glittergirls.co.za' . "\r\n" .
        "Content-Type: text/html; charset=ISO-8859-1\r\n".
        'X-Mailer: PHP/' . phpversion();

    $to = "glittergirls.za@gmail.com"; 
    $subject = "QUERY | ".$name; 
    $body =$message; 

    if(!$captcha){
        $_SESSION["notification"] = "Captcha Fail";
        header('Location: ../contact.php');
        exit;
    }

    $fields = array(
        'secret'    =>  "6Lfdh_4UAAAAAD4x0BsM341E6dMr1vtkQE5_vk0S",
        'response'  =>  $captcha,
        'remoteip'  =>  $_SERVER['REMOTE_ADDR']
    );
    $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
    $response = json_decode(curl_exec($ch));

    if($response->success == 1) {
        if (mail($to, $subject, $body, $headers)) {
            $_SESSION["success"] = "Email Sent!";
        } else {
            $_SESSION["notification"] = "Email did not send!";
        }    
    } else {
        $_SESSION["notification"] = "Email did not send!";
    }

    header('Location: ../contact.php');
?>