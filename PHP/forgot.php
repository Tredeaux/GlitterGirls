<?php
require_once '../SQL/dbconnect.php';
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo "<script> console.log('Connected To DB successfully');</script>"; 
}
catch(PDOException $e)
{
//echo "<script> console.log('ERROR Conecting to DB');</script>";
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$email = $_POST["email"];


if ($email) {
    try {
        $stmt = $conn->prepare("SELECT * FROM `biofefqs_maindata`.`userdata` WHERE `email` = :a1"); 
        $stmt->execute([":a1" => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $_SESSION["dont_exist"] = 1;
            header("Location: ../signup.php");
        } else {
            $token = hash('md5', $result["username"].$result["email"].$result["cr_date"]);
            $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `token` = :a1 WHERE `email` = :b1"); 
            $stmt->execute([":a1" => $token, ":b1" => $email]);
            

            $headers = 'From: BiofeedbackSA contact@biofeedbacksa.co.za' . "\r\n" .
                'Reply-To: contact@biofeedbacksa.co.za' . "\r\n" .
                'X-Mailer: PHP/' . phpversion().
                "MIME-Version: 1.0"."\r\n";
                "Content-Type: text/html; charset=ISO-8859-1"."\r\n";
                
                    
            $to = $email; 
            $subject = "Biofeedback Password Reset"; 
            $body = "BIOFEEDBACK SA \r\n To reset your password click on the link below \r\n https://biofeedbacksa.co.za/PHP/fgtpsw.php?fgttkn=".$token; 
            if (mail($to, $subject, $body, $headers)) {
                $_SESSION["success_reset"] = 1;
            }
            
            
            header("Location: ../signup.php");
        }
        
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../signup.php");
    }
} else {
    header("Location: ../signup.php");
}

?>