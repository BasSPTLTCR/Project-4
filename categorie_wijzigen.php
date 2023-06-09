<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie wijzigen</title>
    <link rel="stylesheet" href="style.css">
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
                $name = $_POST['name'][$index];

                $stmt = $pdo->prepare('UPDATE category SET name = ? WHERE ID = ?');
                $stmt->execute([$name, $id]);

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

        $stmt = $pdo->query('SELECT * FROM category');
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the table with editable fields
        echo "<form method='POST'>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";

        foreach ($tableData as $row) {
            echo "<tr>";
            echo "<td><input type='hidden' name='ID[]' value='" . $row['ID'] . "'>" . $row['ID'] . "</td>";
            echo "<td><input type='text' name='name[]' value='" . $row['name'] . "'></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<button type='submit' onclick='return confirmSubmission();'>Save Changes</button>";
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