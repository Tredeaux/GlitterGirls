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
    $item = $_GET["product"];

    if ($item) {
        $_SESSION["cart"][] = $item;
        unset($item);
    }

    $_SESSION["success"] = "Item added to cart!";
    header("Location: ../shop.php");
?>