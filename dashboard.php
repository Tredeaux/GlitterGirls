<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DASHBOARD PAGE | Glitter Girls</title>
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

                    if ($_SESSION["admin"] != 1) {
                        header("Location: index.php");
                    }                     
                ?>

                <div class="cardSec" style="width:100%;">
                    <div class="titleTag">
                        <h5>Dashboard</h5>
                        <p>Perform admin actions</p>
                    </div>
                    <br>

                    <div style="margin:auto;width:95%;">
                        <div class="accordion" id="accordionDashboard">
                            <div>
                            <!-- VIEW ACTIVE ORDERS -->
                                <div class="card-header" style="padding:0px;" classid="headingActiveOrders">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseActiveOrders" aria-expanded="true" aria-controls="collapseActiveOrders">
                                          View Active Orders
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseActiveOrders" class="collapse" aria-labelledby="headingActiveOrders" data-parent="#accordionDashboard">
                                    <div class="card-body">                                        
                                        <?php
                                            function getDay($dateVar) {
                                                $now = time(); // or your date as well
                                                $date = strtotime($dateVar);
                                                $datediff = $now - $date;
                                                $days = round($datediff / (60 * 60 * 24));
                                                if ($days < 1) {
                                                    $days = 0;
                                                }
                                                if ($days > 1) {
                                                    // $day = join(strval($days)," Days");
                                                    $day = strval($days)." Days";
                                                } else if ($days == 1) {
                                                    // $day = join(strval($days)," Day");
                                                    $day = strval($days)." Day";
                                                } else {
                                                    $day = "Today";
                                                }
                                                return $day;
                                            }

                                            try {
                                                $stmt = $conn->prepare("SELECT * FROM orders WHERE status = 0 ORDER BY id DESC"); 
                                                $stmt->execute();
                                                $results = array();
                                                if ($stmt->execute()) {
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    $results[] = $row;
                                                    }
                                                }
                                                $activeOrders = $stmt->rowcount();
                                                echo '
                                                      <table id="myTable" style="margin:auto;width:750px">
                                                        <tr>
                                                            <th onclick="sortTable(`0`)">#</th>
                                                            <th onclick="sortTable(`1`)">Name</th>
                                                            <th onclick="sortTable(`2`)">Email</th>
                                                            <th>Info</th>
                                                            <th>Total</th>
                                                            <th>Wait</th>
                                                        </tr>';
                                                for ($i = 0; $i < $stmt->rowcount();$i++) {
                                                    echo '<tr>';
                                                    echo '  <td style="text-align:center;">'.$results[$i]["id"].'</td>';
                                                    echo '  <td>'.$results[$i]["customer_name"].'</td>';
                                                    echo '  <td>'.$results[$i]["customer_email"].'</td>';
                                                    echo '  <td style="text-align:center;"><button onclick="showModal(`modal'.$results[$i]["id"].'`); genMap'.$i.'();" class="btn btn-link">View Info</button></td>';
                                                    echo '  <td style="text-align:right;">R '.number_format((float)($results[$i]["total"]), 2, '.', ',').'</td>';
                                                    echo '  <td style="text-align:center;">'.getDay($results[$i]["cr_date"]).'</td>';
                                                    echo '</tr>';
                                                }
                                                echo '</table>';
                                                
                                                for ($i = 0; $i < $stmt->rowcount();$i++) {
                                                    echo '<div id="modal'.$results[$i]["id"].'" class="modal">
                                                              <div class="modal-content">
                                                                  <div style="width:790px;">                                        
                                                                      <span onclick="closeModal(`modal'.$results[$i]["id"].'`)" class="close">&times;</span>
                                                                  </div>
                                                                  <div style="text-align:center;">
                                                                    <p>Order Information</p>
                                                                    <table style="margin:auto;width:600px;">
                                                                      <tr>
                                                                        <th>Order ID</th>
                                                                        <td>'.$results[$i]["id"].'</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <th>Email</th>
                                                                        <td>'.$results[$i]["customer_email"].'</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <th>Total</th>
                                                                        <td>R '.number_format((float)($results[$i]["total"]), 2, '.', ',').'</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <th>Order Date</th>
                                                                        <td>'.$results[$i]["cr_date"].' ('.getDay($results[$i]["cr_date"]).')</td>
                                                                      </tr>
                                                                    </table>   
                                                                    <br>
                                                                    
                                                                    <div class="card" style="text-align:center;margin:auto;width:600px;">    
                                                                        <iframe
                                                                          width="100%"
                                                                          height="300"
                                                                          frameborder="0" style="border:0"
                                                                           src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCrG_beoa7OIeg1CPTl4pyLSVfYcW0eKeU
                                                                            &q='.preg_replace('/\s+/', '%20',  $results[$i]["address"]).'" allowfullscreen>
                                                                        </iframe>                    
                                                                        <br>
                                                                        <a class="subBut" style="margin:auto;" href="https://www.google.com/maps/place/'.$results[$i]["address"].'">View Location</a>
                                                                        <br>
                                                                    </div>
                                                                    <br>
                                                                    <div class="card" style="text-align:center;margin:auto;width:600px;">
                                                                        <br>
                                                                        <p>Set status</p>
                                                                        <button class="subBut green" style="margin:auto;">Completed</button>                                                                        
                                                                        <br>
                                                                        <button class="subBut red" style="margin:auto;">Cancelled</button>   
                                                                        <br>                                                                 
                                                                    </div>
                                                                    <br>
                                                                    <div class="card" style="padding-top:10px;width:600px;margin:auto;"> 
                                                                        <form action="PHP/email_customer.php" method="POST">
                                                                            <p>Send email</p>
                                                                            <textarea name="message" style="width:550px;margin-top:5px;" placeholder="Enter email"></textarea>
                                                                            <br>
                                                                            <input type="hidden" name="date" value="'.$results[$i]["cr_date"].'">
                                                                            <input type="hidden" name="id" value="'.$results[$i]["id"].'">
                                                                            <input type="hidden" name="name" value="'.$results[$i]["customer_name"].'">
                                                                            <input type="hidden" name="email" value="'.$results[$i]["customer_email"].'">
                                                                            <input class="subBut" type="submit" value="Send">
                                                                        </form>  
                                                                    </div>                                                                  
                                                                  </div>                                                    
                                                              </div>
                                                          </div>';
                                                }
                                            } catch(PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }                    
                                        ?>
                                    </div>
                                </div>
                            <!-- ---------------------------------------------------- -->
                            
                            <!-- ADD FAQS -->
                                <div class="card-header" style="padding:0px;" classid="headingFAQ">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseFAQ" aria-expanded="true" aria-controls="collapseFAQ">
                                          Add FAQ'S
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseFAQ" class="collapse" aria-labelledby="headingFAQ" data-parent="#accordionDashboard">
                                    <div class="card-body">                                        
                                        <form style="text-align:center;" action="PHP/upload_faq.php" method="POST">
                                            <input type="text" name="question" placeholder="Enter Question" required>
                                            <br>
                                            <input type="text" name="answer" placeholder="Enter Answer" required>
                                            <br>
                                            <input class="subBut" type="submit" value="Add">
                                        </form>
                                    </div>
                                </div>
                            <!-- ------------------------------------------------------- -->

                            <!-- ADD PRODUCT -->
                                <div class="card-header" style="padding:0px;" classid="headingProduct">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
                                          Add Product
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct" data-parent="#accordionDashboard">
                                    <div class="card-body">                                        
                                        <form style="text-align:center;" enctype="multipart/form-data" action="PHP/upload_product.php" method="POST" >
                                            <input type="text" name="name" placeholder="Enter name" required>
                                            <br>    
                                            <div style="width:600px;text-align:center;margin:auto;display:flex;">
                                                <div style="display:flex;margin:auto;">
                                                    <p style="font-weight:bolder;color:#EB7C95;font-size:20px;margin:10px;margin-right:0px;">R</p>
                                                    <input style="float:right;width:565px;" type="number" name="price" placeholder="Enter price" required>
                                                </div>    
                                            </div> 
                                            <textarea name="description" placeholder="Enter description" required></textarea>
                                            <div class="custom-file" style="margin:auto;width:600px;">
                                              <input name="customFile" type="file" class="custom-file-input" style="border:2px solid #EB7C95;" id="customFile">
                                              <label class="custom-file-label" style="height:40px;border:2px solid #EB7C95;" for="customFile">Select a Picture</label>
                                            </div>
                                            <br><br>
                                            <img style="border:2px solid #EB7C95;margin:auto;width:200px;height:200px;object-fit:cover;" id="output_image" src="Images/gglogo_1.png">                               
                                            <br>
                                            <input class="subBut" type="submit" value="Add">
                                        </form>
                                    </div>
                                </div>
                            <!-- -------------------------------------------------------- -->

                            <!-- Show Stats -->
                                <div class="card-header" style="padding:0px;" classid="headingStats">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseStats" aria-expanded="true" aria-controls="collapseStats">
                                          Show past weeks orders
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseStats" class="collapse" aria-labelledby="headingStats" data-parent="#accordionDashboard">
                                    <div class="card-body">                                        
                                        <canvas id="myChart" width="500" height="200"></canvas>
                                        <script>
                                            <?php 
                                                $date = strtotime("-7 day");
                                                echo "var day1 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-6 day");
                                                echo "var day2 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-5 day");
                                                echo "var day3 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-4 day");
                                                echo "var day4 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-3 day");
                                                echo "var day5 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-2 day");
                                                echo "var day6 = '".date('M,d, Y', $date)."';";
                                                $date = strtotime("-1 day");
                                                echo "var day7 = '".date('M,d, Y', $date)."';";                                                            
                                            ?>
                                            var ctx = document.getElementById('myChart').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: [day1, day2, day3, day4, day5, day6, day7],
                                                    datasets: [{
                                                        label: '# of Order',
                                                        data: [6, 7, 3, 5, 2, 3, 8],
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                            'rgba(255, 206, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(153, 102, 255, 0.6)',
                                                            'rgba(255, 159, 64, 0.6)',
                                                            'rgba(20, 20, 20, 0.6)'
                                                        ],
                                                        borderColor: [
                                                            'white',
                                                            'white',
                                                            'white',
                                                            'white',
                                                            'white',
                                                            'white'
                                                        ],
                                                        borderWidth: 2
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            <!-- -------------------------------------------------------- -->
                            
                            <!-- Show Stats2 -->
                                <div class="card-header" style="padding:0px;" classid="headingStats2">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseStats2" aria-expanded="true" aria-controls="collapseStats">
                                          Show product sales
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseStats2" class="collapse" aria-labelledby="headingStats2" data-parent="#accordionDashboard">
                                    <div class="card-body">                                        
                                        <canvas id="myChart2" width="500" height="200"></canvas>
                                        <script>
                                            var ctx = document.getElementById('myChart2').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                                    datasets: [{
                                                        label: 'Product B',
                                                        data: [12, 19, 3, 5, 2, 3],
                                                        backgroundColor: [
                                                            'rgba(54, 162, 235, 0.1)',
                                                            'rgba(255, 99, 132, 0.1)',
                                                            
                                                            'rgba(255, 206, 86, 0.1)',
                                                            'rgba(75, 192, 192, 0.1)',
                                                            'rgba(153, 102, 255, 0.1)',
                                                            'rgba(255, 159, 64, 0.1)'
                                                        ],
                                                        borderColor: [
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 99, 132, 1)',
                                                            
                                                            'rgba(255, 206, 86, 1)',
                                                            'rgba(75, 192, 192, 1)',
                                                            'rgba(153, 102, 255, 1)',
                                                            'rgba(255, 159, 64, 1)'
                                                        ],
                                                        borderWidth: 5
                                                    },{
                                                        label: 'Product A',
                                                        data: [5, 4, 1, 12, 7, 1],
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.1)',
                                                            'rgba(54, 162, 235, 0.1)',
                                                            'rgba(255, 206, 86, 0.1)',
                                                            'rgba(75, 192, 192, 0.1)',
                                                            'rgba(153, 102, 255, 0.1)',
                                                            'rgba(255, 159, 64, 0.1)'
                                                        ],
                                                        borderColor: [
                                                            'rgba(255, 99, 132, 1)',
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 206, 86, 1)',
                                                            'rgba(75, 192, 192, 1)',
                                                            'rgba(153, 102, 255, 1)',
                                                            'rgba(255, 159, 64, 1)'
                                                        ],
                                                        borderWidth: 5
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            <!-- -------------------------------------------------------- -->
                            
                            <!-- Show Stats3 -->
                                <div class="card-header" style="padding:0px;" classid="headingStats3">
                                    <h2 class="mb-0" style="margin:0px;">
                                        <button class="faqBtn" type="button" data-toggle="collapse" data-target="#collapseStats3" aria-expanded="true" aria-controls="collapseStats">
                                          Show order states
                                        </button>
                                    </h2>
                                </div>
                        
                                <div id="collapseStats3" class="collapse" aria-labelledby="headingStats3" data-parent="#accordionDashboard">
                                    <div class="card-body">  
                                        <div style="width:200px;margin:auto;text-align:center;display:flex;">   
                                            <h5 style="margin:auto;">Active orders:  </h5><h5 style="margin:auto;font-weight:bolder;color:rgb(54, 162, 235);"><?php echo $activeOrders; ?></h5>      
                                        </div> 
                                                                       
                                        <canvas id="myChart3" width="500" height="200"></canvas>
                                        <script>
                                            var ctx = document.getElementById('myChart3').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: ['Active','Completed','Cancelled'],
                                                    datasets: [{
                                                        label: 'Orders Status',
                                                        data: [12, 19, 3],
                                                        backgroundColor: [
                                                            'rgba(54, 162, 235, 0.9)',
                                                            'rgba(96,225,188, 0.9)',
                                                            'rgba(255, 99, 132, 0.9)',
                                                            
                                                            
                                                            'rgba(75, 192, 192, 0.9)',
                                                            'rgba(153, 102, 255, 0.9)',
                                                            'rgba(255, 159, 64, 0.9)'
                                                        ],
                                                        borderColor: [
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 99, 132, 1)',
                                                            
                                                            'rgba(255, 206, 86, 1)',
                                                            'rgba(75, 192, 192, 1)',
                                                            'rgba(153, 102, 255, 1)',
                                                            'rgba(255, 159, 64, 1)'
                                                        ],
                                                        borderWidth: 0
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            <!-- -------------------------------------------------------- -->
                            </div>                         
                        </div>
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