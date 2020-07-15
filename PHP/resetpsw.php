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

$psw1 = (($_POST["psw1"]));
$psw2 = (($_POST["psw2"]));

if ($psw1 == $psw2) {
    $pass = "1";
    $password = $psw1;
}


if ($pass == "1" && $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `password` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $password, ":id" => $_SESSION['id']]);

    } catch(PDOException $e) {
        //header("Location: ../Error.php");
        //echo "Error: " . $e->getMessage();
    }

} else {
    if ($pass != "1") {
        header("Location: ../ErrorMismAtch.php");
    }
}

$_SESSION["id"] = NULL;
$_SESSION["admin"] = 0;
session_unset();
session_destroy();
header("Location: ../signup.php");

?>