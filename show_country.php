<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landen lijst</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include_once "./includes/nav.html";

$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT name, code FROM country');
    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the table
    echo "<table>";
    echo "<tr><th>Name</th><th>Code</th></tr>";

    foreach ($tableData as $row) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['code'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
</body>
</html>