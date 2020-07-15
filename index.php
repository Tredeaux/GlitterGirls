<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HOME PAGE | Glitter Girls</title>
        <?php
            require "components/meta.php";
        ?>
    </head>
    <body>
        <div class="mainBody">
            <div style="min-height:80vh;">
                <?php
                    require_once 'SQL/dbconnect.php';
                    require "components/header.php";
                    require "components/topnav.php";                
                    require "components/banner_loader.php";
                ?>

                <!-- Latest Products View -->
                <div class="cardSec">
                    <div class="titleTag">
                        <h5>Latest Products</h5>
                        <p>View latest products</p>
                    </div>
                    <br>
                    <div>
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 4"); 
                                $stmt->execute();
                                $results = array();
                                if ($stmt->execute()) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $results[] = $row;
                                    }
                                }
                                echo '<div style="margin:auto;display:flex;">';
                                for ($i = 0; $i < $stmt->rowcount();$i++) {
                                    if (($i % 4) == 0) {
                                        echo '</div>
                                        <div style="margin:auto;display:flex;">';
                                    }
                                echo '<div onclick="showModal(`modal'.$results[$i]["id"].'`)" class="productCard">
                                        <img class="productImg" src="products/'.$results[$i]["img"].'">
                                        <p style="margin-bottom:1px;font-size:20px;">'.$results[$i]["name"].'</p>
                                        <p style="margin-top:1px;margin-bottom:1px;">R'.$results[$i]["price"].'</p>
                                      </div>

                                        <div id="modal'.$results[$i]["id"].'" class="modal">
                                          <div class="modal-content">
                                            <div style="width:790px;">                                        
                                                <span onclick="closeModal(`modal'.$results[$i]["id"].'`)" class="close">&times;</span>
                                            </div>
                                            <br>
                                            <div style="width:800px;display:flex;">
                                                <img style="border:1px solid #333;height:450px;width:450px;" src="products/'.$results[$i]["img"].'">
                                                <div style="padding-left:25px;height:450px;width:350px;">
                                                    <br>
                                                    <h2>'.$results[$i]["name"].'</h2>
                                                    <p style="font-size:18px;">R'.$results[$i]["price"].'</p>
                                                    <div style="padding-left:5px;border-left:2px solid gray;">
                                                        <p>'.$results[$i]["description"].'</p>
                                                    </div>
                                                    <p>'.substr($results[$i]["cr_date"],0,10).'</p>
                                                    <br>
                                                    <br>
                                                    <div style="width:100%;text-align:center;">
                                                        <button onclick="window.location.href=`PHP/addItem.php?product='.$results[$i]["id"].'`" class="subBut">Add to Cart</button>
                                                    </div>';
                                                    if ($_SESSION["admin"] == 1) {
                                                        echo '<div style="text-align:center;margin:auto;">
                                                                <button class="subBut red" onclick="deletePrompt(`'.$results[$i]["name"].'`,`PHP/del_product.php?id='.$results[$i]["id"].'`)">Delete</button>
                                                              </div>';
                                                    }
                                                echo '
                                                </div>
                                            </div>
                                          </div>
                                        </div>';
                                                
                                }
                                echo '</div>';
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }     
                        ?>
                    </div>
                </div>

                <!-- FAQ's -->
                <div class="cardSec">
                    <div class="titleTag">
                        <h5>Questions</h5>
                        <p>Click on a question to view the answer</p>
                    </div>

                    <div style="margin:auto;width:800px;">
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM faqs ORDER BY id DESC"); 
                                $stmt->execute();
                                $results = array();
                                if ($stmt->execute()) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $results[] = $row;
                                    }
                                }
                                echo '<div class="accordion" id="accordionFAQ">';
                                for ($i = 0; $i < $stmt->rowcount();$i++) {
                                echo '<div>
                                        <div class="card-header" style="padding:0px;" classid="heading'.$i.'">
                                            <h2 class="mb-0" style="margin:0px;">
                                                <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                                  '.$results[$i]["question"].'
                                                </button>
                                            </h2>
                                        </div>
                                
                                        <div id="collapse'.$i.'" class="collapse" aria-labelledby="heading'.$i.'" data-parent="#accordionFAQ">
                                          <div class="card-body">
                                            '.$results[$i]["answer"].'
                                          </div>';
                                          if ($_SESSION["admin"] == 1) {
                                            echo '<button class="dangerBut" onclick="deletePrompt(`FAQ`,`PHP/del_faq.php?id='.$results[$i]["id"].'`)">Delete</button>';
                                          }
                                        echo '
                                        </div>
                                      </div>';
                                    
                                }
                                echo '</div>';
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }     
                        ?>
                        <br>
                    </div>
                </div>
                        
            </div>
            <?php
                require "components/footer.php";
            ?>
        </div>

        <script src="JS/javascript.js"></script>
    </body>
</html>