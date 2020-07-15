<?php

$file = $_GET["file"];
// echo $file;
unlink("../".$file);
header("Location: ../dashboard.php");

?>

