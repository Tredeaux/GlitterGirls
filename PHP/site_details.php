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
$num1 = (($_POST["num1"]));
$num2 = (($_POST["num2"]));
$email = (trim($_POST["email"]));
$location = ($_POST["loc"]);

if ($num1) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`site` SET `num1` = :q1 WHERE `id` = 1");
        $stmt->execute([":q1" => $num1]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($num2) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`site` SET `num2` = :q1 WHERE `id` = 1");
        $stmt->execute([":q1" => $num2]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($email) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`site` SET `email` = :q1 WHERE `id` = 1");
        $stmt->execute([":q1" => $email]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($location) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`site` SET `location` = :q1 WHERE `id` = 1");
        $stmt->execute([":q1" => $location]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

header("Location: ../index.php");
?>