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

 $id = $_POST["id"];
 $question = $_POST["q"];
 $answer = $_POST["a"];
 $page = $_POST["page"];
 $loc = $_POST["loc"];



if ($page == "publications") {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`publications` SET `title` = :q1 , `body` = :a1  WHERE `id` = :d1"); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":d1" => $id]);
        header("Location: ../publications.php");
    } catch(PDOException $e) {
        header("Location: ../indexERROR.php");
    }
} else if ($page == "blog"){
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`articles` SET `title` = :q1 , `body` = :a1  WHERE `id` = :d1"); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":d1" => $id]);
        header("Location: ../blog.php");
    } catch(PDOException $e) {
        header("Location: ../indexERROR.php");
    }
} else if ($page == "events"){
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`events` SET `title` = :q1 , `description` = :a1, `location` = :d2  WHERE `id` = :d1"); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":d1" => $id, ":d2"=> $loc]);
        header("Location: ../events.php");
    } catch(PDOException $e) {
        header("Location: ../indexERROR.php");
    }
} else if ($page == "main"){
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`main` SET `title` = :q1 , `body` = :a1  WHERE `id` = :d1"); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":d1" => $id]);
        header("Location: ../index.php");
    } catch(PDOException $e) {
        header("Location: ../indexERROR.php");
    }
}
?>