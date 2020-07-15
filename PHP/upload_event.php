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
$question = (trim($_POST["title"]));
$answer = (trim($_POST["description"]));
$location = (trim($_POST["location"]));
$date = (trim($_POST["date"]));

if ($question && $answer) {
    try {
        $stmt = $conn->prepare("INSERT INTO `biofefqs_maindata`.`events` (`title`, `description`, `location`, `date`) VALUES (:q1, :a1, :l1, :d1)" ); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":l1" => $location, ":d1" => $date]);
        header("Location: ../events.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../events.phpER2");
    }
} else {
    header("Location: ../index.phpER1");
}
?>