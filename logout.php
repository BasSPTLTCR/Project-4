<?php
session_start();
unset($_SESSION['klant_id']);
unset($_SESSION['klant_email']);
unset($_SESSION['admin']);
header("Location:login.php");
?>