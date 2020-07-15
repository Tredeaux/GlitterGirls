<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // $_SESSION["success"] = "Payment was successful";
    $_SESSION["pf"] = 1;
    header("Location: ../cart.php");
?>