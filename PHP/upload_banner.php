<?php
require_once '../SQL/dbconnect.php';
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo "<script> console.log('Connected To DB successfully');</script>"; 
}
catch(PDOException $e)
{
// echo "<script> console.log('ERROR Conecting to DB');</script>";
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$title = trim($_POST["title"]);

$tmp_name = file_get_contents($_FILES['file']['tmp_name']);
$target_dir = '../Banners/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
// echo $_FILES[`file`]["error"];
header("Location: ../dashboard.php");

?>