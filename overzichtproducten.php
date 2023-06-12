<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>overzicht producten</title>
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

// Query uitvoeren om alle producten op te halen
$query = "SELECT * FROM product";
$stmt = $conn->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Overzicht van producten tonen
if (count($products) > 0) {
    echo "<h1>Overzicht van producten en bestellingen:</h1>";
    echo "<form method='post' action=''>";
    echo "<label for='product'>Selecteer een product:</label>";
    echo "<select name='product' id='product'>";
    foreach ($products as $product) {
        echo "<option value='" . $product['ID'] . "'>" . $product['productname'] . "</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Toon bestellingen'>";
    echo "</form>";

    if (isset($_POST['product'])) {
        $selectedProduct = $_POST['product'];

        // Query uitvoeren om bestellingen voor het geselecteerde product op te halen
        $orderQuery = "SELECT p.purchasedate, c.first_name, c.last_name FROM purchase p
                       INNER JOIN purchaseline pl ON p.ID = pl.purchaseid
                       INNER JOIN client c ON p.clientid = c.id
                       WHERE pl.productid = :productId";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->bindParam(':productId', $selectedProduct);
        $orderStmt->execute();
        $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($orders) > 0) {
            echo "<h2>Bestellingen voor het geselecteerde product:</h2>";
            echo "<table>";
            echo "<tr><th>Datum</th><th></th><th>Klantnaam</th></tr>";

            foreach ($orders as $order) {
                echo "<tr>";
                echo "<td>" . $order['purchasedate'] . "</td>";
                echo "<td>&nbsp;</td>";
                echo "<td>" . $order['first_name'] . " " . $order['last_name'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Geen bestellingen gevonden voor het geselecteerde product.";
        }
    }
} else {
    echo "Geen producten gevonden.";
}

// Verbinding verbreken
$conn = null;
?>


</body>
</html>