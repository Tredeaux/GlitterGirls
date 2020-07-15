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
$question = (trim($_POST["question"]));
$answer = (trim($_POST["answer"]));

if ($question && $answer) {
    try {
        $stmt = $conn->prepare("INSERT INTO faqs (`question`, `answer`) VALUES (:q1, :a1)" ); 
        $stmt->execute([":q1" => $question, ":a1" => $answer]);
        $_SESSION["success"] = "FAQ Added";
        header("Location: ../dashboard.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../index.phpER1");
    }
} else {
    header("Location: ../index.phpER2");
}
?>