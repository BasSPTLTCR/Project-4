<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bestelling wijzigen</title>
</head>

<body>
<?php
include_once "./includes/nav.php";

$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // show errors on screen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met de database: " . $e->getMessage());
}

// Verify that a POST request was made to change the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["lineID"])) {
        // Ontvangen gegevens van het formulier om een bestelregel te wijzigen
        $lineID = $_POST["lineID"];
        $new_quantity = $_POST["new_quantity"];

        try {
            // Wijzig de gegevens van de bestelregel in de database
            $sql = "UPDATE purchaseline SET quantity = :quantity WHERE ID = :lineID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quantity', $new_quantity);
            $stmt->bindParam(':lineID', $lineID);
            $stmt->execute();

            echo "Gegevens van bestelling succesvol gewijzigd.";
        } catch (PDOException $e) {
            echo "Fout bij het wijzigen van gegevens: " . $e->getMessage();
        }
    } elseif (isset($_POST["productID"])) {
        // Ontvangen gegevens van het formulier om een product toe te voegen
        $productID = $_POST["productID"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];

        try {
            // Voeg het product toe aan de bestelling
            $sql = "INSERT INTO purchaseline (purchaseid, productid, price, quantity) VALUES (:purchaseID, :productID, :price, :quantity)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':purchaseID', $_GET['edit']);
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();

            echo "Product succesvol toegevoegd aan bestelling.";
        } catch (PDOException $e) {
            echo "Fout bij het toevoegen van het product: " . $e->getMessage();
        }
    } elseif (isset($_POST["deleteLineID"])) {
        // Ontvangen gegevens van het formulier om een bestelregel te verwijderen
        $deleteLineID = $_POST["deleteLineID"];

        try {
            // Verwijder de bestelregel uit de database
            $sql = "DELETE FROM purchaseline WHERE ID = :lineID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lineID', $deleteLineID);
            $stmt->execute();

            echo "Bestelregel succesvol verwijderd.";
        } catch (PDOException $e) {
            echo "Fout bij het verwijderen van de bestelregel: " . $e->getMessage();
        }
    }
}

try {
    // Haal bestellingen op die nog niet zijn afgeleverd
    $sql = "SELECT DISTINCT p.ID, p.clientid, p.purchasedate
            FROM purchase p 
            INNER JOIN purchaseline pl ON p.ID = pl.purchaseid 
            WHERE p.delivered = 0";
    $stmt = $conn->query($sql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Bestellingen wijzigen</h2>";
    if (count($orders) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Client ID</th><th>Aankoopdatum</th><th>Action</th></tr>";
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order['ID'] . "</td>";
            echo "<td>" . $order['clientid'] . "</td>";
            echo "<td>" . $order['purchasedate'] . "</td>";
            echo "<td><form method='GET' action='" . $_SERVER['PHP_SELF'] . "'><input type='hidden' name='edit' value='" . $order['ID'] . "'><button type='submit'>Aanpassen</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Geen bestellingen die nog niet zijn afgeleverd.</p>";
    }

    if (isset($_GET['edit'])) {
        $editID = $_GET['edit'];

        // Haal de bestelgegevens op voor bewerking
        $editStmt = $conn->prepare("SELECT pl.ID as lineID, pl.productid, pl.price, pl.quantity, pr.productname 
                                    FROM purchaseline pl 
                                    INNER JOIN purchase p ON p.ID = pl.purchaseid 
                                    INNER JOIN product pr ON pr.ID = pl.productid
                                    WHERE pl.purchaseid = :editID");
        $editStmt->bindParam(':editID', $editID);
        $editStmt->execute();
        $orderDetails = $editStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($orderDetails) {
            echo "<h3>Bestelling bewerken</h3>";
            echo "<table>";
            echo "<tr><th>Product</th><th>Prijs</th><th>Aantal</th><th>Action</th></tr>";
            foreach ($orderDetails as $order) {
                echo "<tr>";
                echo "<td>" . $order['productname'] . "</td>";
                echo "<td>" . $order['price'] . "</td>";
                echo "<td>" . $order['quantity'] . "</td>";
                echo "<td>";
                echo "<form method='POST' onsubmit='return confirmSubmission();' action='" . $_SERVER['PHP_SELF'] . "'>";
                echo "<input type='hidden' name='lineID' value='" . $order['lineID'] . "'>";
                echo "<input type='text' name='new_quantity' required>";
                echo "<button type='submit'>Wijzigen</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // Formulier toevoegen om producten aan de bestelling toe te voegen
            echo "<h3>Product toevoegen</h3>";
            echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
            echo "<input type='hidden' name='edit' value='" . $editID . "'>";
            echo "<label for='productID'>Product:</label>";
            echo "<select name='productID' required>";
            // Haal de beschikbare producten op
            $productStmt = $conn->query("SELECT * FROM product");
            $products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                echo "<option value='" . $product['ID'] . "'>" . $product['productname'] . "</option>";
            }
            echo "</select>";
            echo "<label for='price'>Prijs:</label>";
            echo "<input type='number' name='price' required>";
            echo "<label for='quantity'>Aantal:</label>";
            echo "<input type='number' name='quantity' required>";
            echo "<button type='submit'>Toevoegen</button>";
            echo "</form>";

            // Formulier toevoegen om bestelregels te verwijderen
            echo "<h3>Bestelregel verwijderen</h3>";
            echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
            echo "<input type='hidden' name='edit' value='" . $editID . "'>";
            echo "<label for='deleteLineID'>Bestelregel:</label>";
            echo "<select name='deleteLineID' required>";
            foreach ($orderDetails as $order) {
                echo "<option value='" . $order['lineID'] . "'>" . $order['productname'] . "</option>";
            }
            echo "</select>";
            echo "<button type='submit'>Verwijderen</button>";
            echo "</form>";
        } else {
            echo "<p>Ongeldige bestelling ID voor bewerking.</p>";
        }
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen van bestellingen: " . $e->getMessage();
}

// Sluit de databaseverbinding
$conn = null;
?>

<script>
    function confirmSubmission() {
        return confirm("Weet je zeker dat je de wijzigingen wilt opslaan?");
    }
</script>

</body>

</html>