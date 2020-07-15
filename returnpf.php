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

              

            <h1>RETURN</h1>
            </div>
            <?php
                require "components/footer.php";
            ?>
        </div>

        <script src="JS/javascript.js"></script>
    </body>
</html>