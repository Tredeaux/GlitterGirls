<!DOCTYPE html>
<html lang="en">
    <head>
        <title>404 | Glitter Girls</title>
        <?php
            require "components/meta.php";
        ?>
    </head>
    <body>
        <div class="mainBody">
            <?php
                require_once 'SQL/dbconnect.php';
                require "components/header.php";
                require "components/topnav.php";
    
                if (isset($_SESSION["notification"])) {
                    echo '<script>swal("warning!", '.$_SESSION["notification"].', "success");</script>';
                    $_SESSION["notification"] = NULL;
                };
            
                if ($_SESSION["success"] == 1) {
                    echo '<script>swal("Success!", '.$_SESSION["success"].', "success");</script>';
                    $_SESSION["success"] = 0;
                };
            
            ?>
            <br><br><br>
            <div class="cardSec">
                <div class="titleTag">
                    <h5>Error 404: Page not found</h5>
                    <p>View latest products</p>
                </div>
            </div>
            <br><br><br>
            <script>
                swal("warning!", '404 Page not found!', "warning");
            </script>
            <?php
                require "components/footer.php";
            ?>
        </div>
        <script src="JS/javascript.js"></script>
    </body>
</html>