<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CART PAGE | Glitter Girls</title>
        <?php
            require "components/meta.php";
        ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>
    </head>
    <body>
        <div class="mainBody">
            <div style="min-height:80vh;">    
                <?php
                    require_once 'SQL/dbconnect.php';
                    require "components/header.php";
                    require "components/topnav.php";

                    if (isset($_SESSION["notification"])) {
                        echo '<script>swal("warning!", '.$_SESSION["notification"].', "success");</script>';
                        $_SESSION["notification"] = NULL;
                    };
                

                    if ($_SESSION["success"]) {
                        echo '<script>swal("Success!", "'.$_SESSION["success"].'", "success");</script>';
                        $_SESSION["success"] = NULL;
                    };

                    if(isset($_SESSION["pf"])) {
                        header("Location: https://www.glittergirls.co.za/PHP/notifyPF.php");
                    }
                ?>

                <div class="cardSec">
                    <div class="titleTag">
                        <h5>Place an order</h5>
                        <p>Order the items in your cart</p>
                    </div>
                    <br>
                    <div style="margin:auto;width:800px;">
                        <table style="width:100%">
                            <tr>
                              <th style="width:200px;">Product</th>
                              <th style="width:50px;">Product ID</th>
                              <th style="width:50px;">Price</th>
                              <th style="width:100px;">Remove</th>
                            </tr>
                        <?php
                            $priceTotal = 0;
                            foreach($_SESSION["cart"] as $item) {
                                try {
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id"); 
                                    $stmt->execute([":id"=>$item]);
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($stmt->rowcount() == 0) {
                                        if ($item) {
                                            if (($key= array_search($item, $_SESSION["cart"])) !== false) {
                                                unset($_SESSION["cart"][$key]);
                                            }
                                        }
                                    }
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }  
                            }
                            
                            foreach($_SESSION["cart"] as $item) {    

                                echo '<tr>';                    
                                try {
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id"); 
                                    $stmt->execute([":id"=>$item]);
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo '<td>'.$result["name"].'</td>';
                                    echo '<td style="text-align:center;" >#'.$result["id"].'</td>';
                                    echo '<td style="text-align:right;" >R '.number_format((float)($result["price"]), 2, '.', ',').'</td>';
                                    echo '<td style="text-align:center;" ><button class="btn btn-link" onclick="deletePrompt(`'.$result["name"].'`,`PHP/removeItem.php?product='.$result["id"].'`)">Remove</button></td>';

                                    // echo '<td style="text-align:center;" ><button class="btn btn-link" onclick="window.location.href=`PHP/removeItem.php?product='.$result["id"].'`">Remove</button></td>';
                                    $priceTotal += $result["price"];
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }  
                                echo '</tr>';                       
                            }

                            echo '</table>';
                            echo "<h2 style='font-size:40px;'>Total: R".$priceTotal."</h2>";
                        ?>
                        <div class="card" style="padding:20px;text-align:center;margin:auto;">
                            <?php
                                require "components/payfast.php";
                            ?>
                        </div>
                        <br>
                    </div>
                </div>
                <br>  
            </div>                  
            <?php
                require "components/footer.php";
            ?>
        </div>
        <script src="JS/javascript.js"></script>
    </body>
</html>