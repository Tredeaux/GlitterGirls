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
$name = strtolower(trim($_POST["name"]));
$name[0] = strtoupper(trim($_POST["name"][0]));
$surname = (trim($_POST["surname"]));

print_r($_FILES["file"]);
$tmp_name = file_get_contents($_FILES['file']['tmp_name']);

$target_dir = '../uploads/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
//$image = base64_encode(file_get_contents($_FILES['file']['tmp_name']));

if ($name && $surname) {
   try {
        $stmt = $conn->prepare("INSERT INTO `biofefqs_maindata`.`userdata` (`name`, `surname`, `instructor`, `image`) VALUES (:q1, :a1, '1' , :d1)" ); 
        $stmt->execute([":q1" => $name, ":a1" => $surname, ":d1" => basename($_FILES["file"]["name"])]);
        header("Location: ../index.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../index.php");
   }
} else {
    header("Location: ../index.php");
}
?>