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
$geolocation = (trim($_POST["geolocation"]));
$longitude = (trim($_POST["longitude"]));
$latitude = (trim($_POST["latitude"]));
$name = (trim($_POST["name"]));
$email = (trim($_POST["email"]));
$address = (trim($_POST["address"]));
$total = ($_POST["total"]);

if ($name && $email && $address && $total) {
    try {
        $stmt = $conn->prepare("INSERT INTO orders (customer_email, customer_name, total, address, geolocation, longitude, latitude) VALUES (:1, :2, :3, :4, :5, :6, :7)" ); 
        $stmt->execute([":1" => $email,":2" => $name,":3" => $total,":4" => $address,":5" => $geolocation,":6" => $longitude,":7" => $latitude]);        

        $_SESSION["success"] = "Order placed!";

        $subject = "Order Placed! ".$name;

        $body = "<h1>Dear ". $name . "</h1><br> We have received your order!<br><br><hr>";
        $body .= "<table>
                    <tr>
                      <th>Product</th>
                      <th>Product ID</th>
                      <th>Price</th>
                    </tr>";
        
        foreach($_SESSION["cart"] as $item) {    
            $body .='<tr>';                    
            try {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id"); 
                $stmt->execute([":id"=>$item]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $body .= '<td>'.$result["name"].'</td>';
                $body .= '<td>#'.$result["id"].'</td>';
                $body .= '<td>R '.number_format((float)($result["price"]), 2, '.', ',').'</td>';
                $priceTotal += $result["price"];
                // echo '<td style="text-align:center;" ><button class="btn btn-link" onclick="window.location.href=`PHP/removeItem.php?product='.$result["id"].'`">Remove</button></td>';
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }  
            $body .= '</tr>';                       
        }

        $body .= '</table>';
        $body .= "<h2 style='color:#EB7C95;'>Total: R".$priceTotal."</h2>
        <br><hr>
        <a href='www.glittergirls.co.za'>Go to website</a><br>";
        $body .= date("d F Y");

        $headers = 'From: service@glittergirls.co.za' . "\r\n" .
            'Reply-To: contact@glittergirls.co.za' . "\r\n" .
            "Content-Type: text/html; charset=ISO-8859-1\r\n".
            'X-Mailer: PHP/' . phpversion();
    
        $to = $email; 
    
        mail($to, $subject, $body, $headers);
        unset($_SESSION["cart"]);
        
        header("Location: ../index.php");
    } catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        header("Location: ../index.phpER1");
    }
} else {
    header("Location: ../index.phpER2");
}
?>