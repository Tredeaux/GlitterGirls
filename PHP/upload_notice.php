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
$permission = $_POST["member"];
$author = $_SESSION["name"];
if (empty($_POST["member"])) {
    $permission = 0;
}

if ($question && $answer) {
    try {
        $stmt = $conn->prepare("INSERT INTO `biofefqs_maindata`.`articles` (`title`, `body`, `permission`, `author`) VALUES (:q1, :a1, :c1, :d1)" ); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":c1" => $permission, ":d1" => $author]);
        header("Location: ../blog.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../blog.php");
    }
} else {
    header("Location: ../index.php");
}

?>