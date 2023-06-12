<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>overzicht category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    include "./includes/nav.php";
    ?>
<?php
// Verbinding maken met de database
$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Fout bij het verbinden met de database: " . $e->getMessage();
}

// Query uitvoeren om alle categoryën op te halen
$categoryQuery = "SELECT * FROM category";
$categoryStmt = $conn->query($categoryQuery);
$categorys = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Overzicht van categoryën tonen
if (count($categorys) > 0) {
    echo "<h1>Overzicht van categoryën en gemiddelde prijzen:</h1>";
    echo "<table>";
    echo "<tr><th>category</th><th>Gemiddelde Prijs</th></tr>";

    foreach ($categorys as $category) {
        // Query uitvoeren om de gemiddelde prijs van producten in de category te berekenen
        $avgPriceQuery = "SELECT AVG(price) AS average_price FROM product WHERE categoryid = :categoryId";
        $avgPriceStmt = $conn->prepare($avgPriceQuery);
        $avgPriceStmt->bindParam(':categoryId', $category['ID']);
        $avgPriceStmt->execute();
        $avgPrice = $avgPriceStmt->fetch(PDO::FETCH_ASSOC);

        // Opmaak van de gemiddelde prijs naar twee decimalen
        $formattedAvgPrice = number_format($avgPrice['average_price'], 2);

        echo "<tr>";
        echo "<td>" . $category['name'] . "</td>";
        echo "<td>" . $formattedAvgPrice . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Geen categoryën gevonden.";
}

// Verbinding verbreken
$conn = null;
?>



</body>
</html>