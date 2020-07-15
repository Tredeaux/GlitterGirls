<?php

$id = $_GET["id"];
//echo $id;

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

if ($id) {
    try {
        $stmt = $conn->prepare("DELETE FROM `biofefqs_maindata`.`publications` WHERE `id` = :a1"); 
        $stmt->execute([":a1" => $id]);
        header("Location: ../publications.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../publications.php");
    }
} else {
    header("Location: ../index.php");
}
?>