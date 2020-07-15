<?php

// sleep(3);
try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<script> console.log('Connected To DB successfully');</script>"; 
    }
    catch(PDOException $e) {
        echo "<script> console.log('ERROR Conecting to DB');</script>";
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["notification"])) {
        $_SESSION["notification"] = NULL;
    };

    if (!isset($_SESSION["admin"])) {
        $_SESSION["admin"] = 0;
    };

    if (!isset($_SESSION["id"])) {
        $_SESSION["id"] = NULL;
    };

    if (!isset($_SESSION["success"])) {
        $_SESSION["success"] = NULL;
    };

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    };
    
    if ($_SESSION["success"]) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '".$_SESSION["success"]."',
                })
              </script>";
        $_SESSION["success"] = NULL;
    }

    if ($_SESSION["admin"] == 1) { 
        echo '
                <div style="margin:auto;text-align:center;">
                    <h1 style="color:red;">ADMIN MODE</h1>
                </div>
                <div class="header">
                    <br>
                    <img id="top" alt="GlitterGirls" style="height:18vh;width:auto;" src="Images/gglogo_1.png">
                    <br><br>
                </div>';
    } else {
        echo '
                <div class="header">
                    <br>
                    <img id="top" alt="GlitterGirls" style="height:18vh;width:auto;" src="Images/gglogo_1.png">
                    <br><br>
                </div>';
    }
?>

<!-- <div id="loading" style="height:200%;margin:auto;text-align:center;">
    <div class="spinner-border" style="margin:auto;margin-top:48vh;text-align:center;" role="status">
      <span class="sr-only" style="font-size:50px;margin:auto;text-align:center;">Loading...</span>      
    </div>
    <br>
    <p style="font-size:30px;">Loading</p>
</div> -->

