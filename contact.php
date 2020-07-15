<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CONTACT PAGE | Glitter Girls</title>
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
                ?>
                <div class="cardSec">
                    <div class="titleTag">
                        <h5>Contact us</h5>
                        <p>Fill in the form to email us</p>
                    </div>
                    <div>
                        <div>
                            <form id="captcha_form" class="contact" action="PHP/contact_form.php" method="POST">
                                <br>
                                <input type="text" placeholder="Name" name="name" required>
                                <br>
                                <input type="email" placeholder="Email" name="email" required>
                                <br>
                                <input type="text" placeholder="Subject" name="subject" required>
                                <br>
                                <textarea style="min-height:7em;" name="message" placeholder="Enter Message..." required></textarea>
                                <br>
                                <div style="margin:auto;width:305px;" class="g-recaptcha" data-sitekey="6Lfdh_4UAAAAAHhdqc8pvYePBwsUDNeo6oomJANn"></div>
                                <input class="subBut" style="cursor:pointer;"  type="submit" value="SEND">
                            </form>
                        </div>
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