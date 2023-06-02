<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorien</title>
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

    $stmt = $pdo->query('SELECT * FROM category');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the table of categories
    echo "<h1>Categories</h1>";
    if (count($categories) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";
        foreach ($categories as $category) {
            echo "<tr>";
            echo "<td>" . $category['ID'] . "</td>";
            echo "<td>" . $category['name'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No categories found.</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

</body>
</html>