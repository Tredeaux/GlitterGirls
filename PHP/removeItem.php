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
        if (($key= array_search($item, $_SESSION["cart"])) !== false) {
            unset($_SESSION["cart"][$key]);
        }
    }

    $_SESSION["success"] = "Item deleted";
    header("Location: ../cart.php");
?>


