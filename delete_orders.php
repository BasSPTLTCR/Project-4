<?php 
require "db-connection.php";

$query = "DELETE FROM purchase WHERE ID = :id";

// Prepare the statement
$statement = $conn->prepare($query);

// Bind the name and code parameter
$statement->bindParam(':id', $_GET["id"]);

// Execute the statement
$statement->execute();

// Redirect back to show country page.
header('location: show_orders.php');
?>