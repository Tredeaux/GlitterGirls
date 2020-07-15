<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $name = (trim($_POST["name"]));
    $id = (trim($_POST["id"]));
    $email = (($_POST["email"]));
    $date = (($_POST["date"]));    
    $subject = $name." Order: #".$id;
    $message = ($_POST["message"]);

    $message = wordwrap($message,70);

    $message = "<h1>Hello  ".$name."</h1>"."<p><strong>NAME: </strong>".$name. "<br>". "<strong>EMAIL: </strong>".$email."<br>"."<strong>SUBJECT: </strong>".$subject."<br><hr><br>". $message . "<br></p><p style='font-size:12px;'>Order placed on: ".$date."</p><hr>" . date("d F Y");
    $headers = 'From: contact@glittergirls.co.za' . "\r\n" .
        'Reply-To: contact@glittergirls.co.za' . "\r\n" .
        "Content-Type: text/html; charset=ISO-8859-1\r\n".
        'X-Mailer: PHP/' . phpversion();

    $to = $email; 
    $body =$message; 


    if (mail($to, $subject, $body, $headers)) {
        $_SESSION["success"] = "Email Sent!";
    } else {
        $_SESSION["notification"] = "Email did not send!";
    }    

    header('Location: ../contact.php');
?>