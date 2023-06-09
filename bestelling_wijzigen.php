<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>bestelling wijzigen</title>
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
        // Ontvangen gegevens van het formulier
        $ID = $_POST["ID"];
        $new_quantity = $_POST["new_quantity"];

        try {
            // Change the data of the order in the database
            $sql = "UPDATE purchaseline SET quantity = :quantity WHERE ID = :ID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quantity', $new_quantity);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();

            echo "Gegevens van bestelling succesvol gewijzigd.";
        } catch (PDOException $e) {
            echo "Fout bij het wijzigen van gegevens: " . $e->getMessage();
        }
    }

    // Close the database connection
    $conn = null;
    ?>

    <h2>Bestelling bewerken</h2>
    <form method="POST" onsubmit="return confirmSubmission();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="ID">Bestelling ID:</label>
        <input type="text" name="ID" required><br>

        <label for="new_quantity">nieuw aantal:</label>
        <input type="text" name="new_quantity" required><br>

        <input type="submit" value="Gegevens wijzigen">
    </form>
    <script>
        function confirmSubmission() {
            return confirm("Are you sure you want to save the changes?");
        }
    </script>

</body>

</html>