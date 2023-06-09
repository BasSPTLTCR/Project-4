<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>klant verwijderen</title>
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
    $id = $_POST["id"];

    try {
        // Verify if there is a active order
        $sql_check = "SELECT COUNT(*) AS order_count FROM purchase WHERE clientid = :id";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':id', $id);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        $orderCount = $row['order_count'];

        if ($orderCount == 0) {
            // no active order so client can be deleted
            $sql_delete = "DELETE FROM client WHERE id = :id";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':id', $id);
            $stmt_delete->execute();

            echo "Klant succesvol verwijderd.";
        } else {
            echo "De klant heeft actieve bestellingen en kan niet worden verwijderd.";
        }
    } catch(PDOException $e) {
        echo "Fout bij het verwijderen van de klant: " . $e->getMessage();
    }
}

// disconnect database
$conn = null;
?>

<body>
    <h2>Klant verwijderen</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="id">Klant ID:</label>
        <input type="text" name="id" required><br>

        <input type="submit" value="Klant verwijderen">
    </form>
</body>
</html>
