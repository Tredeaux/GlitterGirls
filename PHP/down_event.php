<?php

$id = $_GET["id"];
$weight = $_GET["weight"];
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
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`events` SET `weight` = :a1 WHERE `id` = :b1"); 
        $stmt->execute([":a1" => $weight-1, ":b1"=>$id]);
        header("Location: ../events.php");
        // $_SESSION["del_event"] = 1;
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../events.php");
    }
} else {
    header("Location: ../events.php");
}
?>