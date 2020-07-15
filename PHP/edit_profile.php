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
$name = (trim($_POST["name"]));
$surname = (trim($_POST["surname"]));
$title = (trim($_POST["title"]));
$website = (trim($_POST["website"]));
$location = (trim($_POST["location"]));
$email = (trim($_POST["Email"]));
$certified = (($_POST["certified"]));
$province = (($_POST["province"]));
$long = (($_POST["long"]));
$lat = (($_POST["lat"]));


$psw1 = (($_POST["psw1"]));
$psw2 = (($_POST["psw2"]));

if ($psw1 == $psw2) {
    $pass = "1";
    $password = $psw1;
}


$tmp_name = file_get_contents($_FILES['file']['tmp_name']);

$target_dir = '../uploads/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

if ($name) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `name` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $name, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($surname) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `surname` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $surname, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($title) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `title` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $title, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($website) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `website` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $website, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($email) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `bemail` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $email, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}


if ($location) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `location` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $location, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($certified) {

    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `certified` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $certified, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($province) {

    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `province` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $province, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($long) {

    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `longitude` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $long, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($lat) {

    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `latitude` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $lat, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if (basename($_FILES["file"]["name"])) {
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `image` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => basename($_FILES["file"]["name"]), ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }
}

if ($pass == "1" && $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    try {
        $stmt = $conn->prepare("UPDATE `biofefqs_maindata`.`userdata` SET `password` = :n  WHERE `id` = :id"); 
        $stmt->execute([":n" => $password, ":id" => $_SESSION['id']]);
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
    }

    header("Location: /logout.php");

}

header("Location: ../dashboard.php");

?>