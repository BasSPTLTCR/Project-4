<?php 
require "db-connection.php";

$query = "DELETE FROM country WHERE idcountry = :idcountry";

// Prepare the statement
$statement = $conn->prepare($query);

// Bind the name and code parameter
$statement->bindParam(':idcountry', $_GET["id"]);

// Execute the statement
$statement->execute();

// Redirect back to show country page.
header('location: show_country.php');
?>