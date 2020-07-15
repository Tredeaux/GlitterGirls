<?php

$id = $_GET["id"];
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

if ($id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM `biofefqs_maindata`.`userdata` WHERE `id` = :a1"); 
        $stmt->execute([":a1" => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result["admin"] == 1) {
            try {
                $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `admin` = 0 WHERE `id` = :a1"); 
                $stmt->execute([":a1" => $id]);
            } catch(PDOException $e) {
                //echo "Error: " . $e->getMessage();
            }
        } else if ($result["admin"] == 0) {
            try {
                $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `admin` = 1 WHERE `id` = :a1"); 
                $stmt->execute([":a1" => $id]);
            } catch(PDOException $e) {
                //echo "Error: " . $e->getMessage();
            }
        }

    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

header("Location: ../member_man.php");

?>