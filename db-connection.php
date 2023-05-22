<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "befs"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connectie gelukt!";
} catch(PDOException $e) {
    echo "Database connectie mislukt: " . $e->getMessage();
}
?>