
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

    try {
        $stmt = $conn->prepare("SELECT * FROM `biofefqs_maindata`.`userdata`"); 
        $stmt->execute();
        $results = array();
        if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
            }
        }
        $emails = "";
        for ($i = 0; $i < $stmt->rowcount(); $i++) {
            $emails .= " ". $results[$i]["email"];
        }
        echo '<input  onload="myFunction()" style="width:100%;" type="text" value="',$emails,'" id="emailList">';
        echo '    <script>
        function myFunction() {
        var copyText = document.getElementById("emailList");
        copyText.select();
        document.execCommand("copy");
        alert("Text Copied");
    }
        </script>';
        // header("Location: ../member_man.php");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
