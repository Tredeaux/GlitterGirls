<?php

$fgttkn = $_GET["fgttkn"];
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

    try {
        $stmt = $conn->prepare("SELECT * FROM `biofefqs_maindata`.`userdata` WHERE `token` = :a1"); 
        $stmt->execute([":a1" => $fgttkn]);

            $result =  $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION["id"] = $result["id"];
            $_SESSION["surname"] = $result["surname"];
            $_SESSION["name"] = $result["name"];
            $_SESSION["username"] = $result["username"];
            $_SESSION["member"] = $result["member"];
            if ($result["admin"] == 1) {
                $_SESSION["admin"] = 1;
            }
            

            try {
                $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `token` = NULL  WHERE `id` = :id"); 
                $stmt->execute([":id" => $_SESSION['id']]);
                $_SESSION["reset"] = 1;
                header("Location: ../pswrst.php");
            } catch(PDOException $e) {
                header("Location: ../index2ERROR101.php");
                //echo "Error: " . $e->getMessage();
            }
            
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../index2ERROR3.php");
    }


?>