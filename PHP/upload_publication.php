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
$question = (trim($_POST["a"]));
$answer = (trim($_POST["b"]));


if ((trim($_POST["member"]))) {
    $permission = (trim($_POST["member"]));
} else {
    $permission = ("0");
}

if ((trim($_POST["c"]))) {
    $link = (trim($_POST["c"]));
} else {
    $link = ("");
}

if ($question && $answer) {

     try {
        $stmt = $conn->prepare("INSERT INTO `biofefqs_maindata`.`publications` (`title`, `body`, `permission`,`link`) VALUES (:q1, :a1, :c1, :l1)" ); 
        $stmt->execute([":q1" => $question, ":a1" => $answer, ":c1" => $permission, ":l1" => $link]);
        $_SESSION["publication_success"] = 1;
        header("Location: ../publications.php");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        //header("Location: ../publicationsERROR.php");
    }
} else {
    header("Location: ../index.php");
  //echo "<br><br>TITLE: ".$question,"<br>";
  //echo $answer;
}
?>