<?php
session_start();
unset($_SESSION['klant_id']);
unset($_SESSION['klant_email']);
header("Location:login.php");
?>