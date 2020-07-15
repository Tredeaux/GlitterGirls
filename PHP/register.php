<?php
    require_once '../SQL/dbconnect.php';
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ////echo "<script> console.log('Connected To DB successfully');</script>"; 
    }
    catch(PDOException $e)
    {
    ////echo "<script> console.log('ERROR Conecting to DB');</script>";
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $password = "admin";
    $email = "admin@admin";

    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO sitedata (`password`, `email`) VALUES (:a1, :p1)" );
        $stmt->execute([":a1" => $password, ":p1" => $email]);
    
    } catch(PDOException $e) {
        header("Location: ../index.php");
    }
?>