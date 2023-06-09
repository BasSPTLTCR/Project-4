<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product wijzigen</title>
    <link rel="stylesheet" href="./style.css">

</head>

<body>
<?php
include_once "./includes/nav.php";

$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update each row individually
        $changesMade = false; // Flag to track if any changes were made

        foreach ($_POST['ID'] as $index => $id) {
            $productname = $_POST['productname'][$index];
            $ingredients = $_POST['ingredients'][$index];
            $allergens = $_POST['allergens'][$index];
            $price = $_POST['price'][$index];
            $categoryid = $_POST['categoryid'][$index];
            $supplierid = $_POST['supplierid'][$index];

            $stmt = $pdo->prepare('UPDATE product SET productname = ?, ingredients = ?, allergens = ?, price = ?, categoryid = ?, supplierid = ? WHERE ID = ?');
            $stmt->execute([$productname, $ingredients, $allergens, $price, $categoryid, $supplierid, $id]);

            // Check if any rows were affected by the update
            if ($stmt->rowCount() > 0) {
                $changesMade = true;
            }
        }

        if ($changesMade) {
            echo "Changes have been saved.<br><br>";
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT * FROM product');
    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the table with editable fields
    echo "<form method='POST' onsubmit='return confirmSubmission();'>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Product Name</th><th>Ingredients</th><th>Allergens</th><th>Price</th><th>Category ID</th><th>Supplier ID</th></tr>";

    foreach ($tableData as $row) {
        echo "<tr>";
        echo "<td><input type='hidden' name='ID[]' value='" . $row['ID'] . "'>" . $row['ID'] . "</td>";
        echo "<td><input type='text' name='productname[]' value='" . $row['productname'] . "'></td>";
        echo "<td><input type='text' name='ingredients[]' value='" . $row['ingredients'] . "'></td>";
        echo "<td><input type='text' name='allergens[]' value='" . $row['allergens'] . "'></td>";
        echo "<td><input type='text' name='price[]' value='" . $row['price'] . "'></td>";
        echo "<td><input type='text' name='categoryid[]' value='" . $row['categoryid'] . "'></td>";
        echo "<td><input type='text' name='supplierid[]' value='" . $row['supplierid'] . "'></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<button type='submit'>Save Changes</button>";
    echo "</form>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<script>
    function confirmSubmission() {
        return confirm("Are you sure you want to save the changes?");
    }
</script>







</body>

</html>