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

    
    $id = $_GET["id"];

    if ($id) {
        try {
            $stmt = $conn->prepare("DELETE FROM faqs WHERE `id` = :a1"); 
            $stmt->execute([":a1" => $id]);
            header("Location: ../index.php");
            $_SESSION["success"] = "FAQ Deleted";
        } catch(PDOException $e) {
            //echo "Error: " . $e->getMessage();
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }
?>