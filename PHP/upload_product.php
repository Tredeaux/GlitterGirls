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
$price = (trim($_POST["price"]));
$description = (trim($_POST["description"]));


$target_dir = "../products/";
$target_file = $target_dir . basename($_FILES["customFile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

move_uploaded_file($_FILES["customFile"]["tmp_name"], $target_file);

    if ($name && $price && $description) {
        try {
            $stmt = $conn->prepare("INSERT INTO products (`name`, `price`, `img` , `description`) VALUES (:q1, :a1, :p1, :d1)" ); 
            $stmt->execute([":q1" => $name, ":a1" => $price, ":p1" => basename( $_FILES["customFile"]["name"]), ":d1" => $description]);
            $_SESSION["success"] = "Product Added";
            header("Location: ../dashboard.php");
        } catch(PDOException $e) {
            //echo "Error: " . $e->getMessage();
            header("Location: ../index.phpER1");
        }
    } else {
        header("Location: ../index.phpER2");
    }

?>