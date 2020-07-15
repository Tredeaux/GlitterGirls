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
    $email = strtolower(trim($_POST["email"]));
    $password = (trim($_POST["password"]));

    try {
        $stmt = $conn->prepare("SELECT * FROM sitedata WHERE id = 1" ); 
        $stmt->execute();
        if ($stmt->rowcount() == 1)
        {
            $result =  $stmt->fetch(PDO::FETCH_ASSOC);
            $hash = $result["password"];

            if (password_verify($password, $hash)) {
                $_SESSION["admin"] = 1;
                $_SESSION["success"] = "Logged in as Admin";
                header("Location: ../dashboard.php");
            } else {
                header("Location: ../signup.php");
            }            
        } else {
            header("Location: ../signup.php");
        }
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../index2Err1.php");
    }
?>