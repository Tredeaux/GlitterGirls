<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["id"] = NULL;
$_SESSION["admin"] = 0;
session_unset();
session_destroy();
header("Location: ../index.php");
?>