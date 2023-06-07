<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product verwijderen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// database connection
include_once "./includes/nav.php";

$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // show error on screen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Fout bij verbinden met de database: " . $e->getMessage());
}

// Verify that a POST request was made to change the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvangen gegevens van het formulier
    $ID = $_POST["ID"];

    try {
        // verify if product is not in a order
        $sql_check = "SELECT COUNT(*) AS order_count FROM purchaseline WHERE productid = :ID";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':ID', $ID);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        $orderCount = $row['order_count'];

        if ($orderCount == 0) {
            // Product isn't orderd so it can be deleted
            $sql_delete = "DELETE FROM product WHERE ID = :ID";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':ID', $ID);
            $stmt_delete->execute();

            echo "Product succesvol verwijderd.";
        } else {
            echo "Het product komt voor in lopende bestellingen en kan niet worden verwijderd.";
        }
    } catch(PDOException $e) {
        echo "Fout bij het verwijderen van het product: " . $e->getMessage();
    }
}

// close database connection
$conn = null;
?>


    <h2>Product verwijderen</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="ID">Product ID:</label>
        <input type="text" name="ID" required><br>

        <input type="submit" value="Product verwijderen">
    </form>
</body>
</html>