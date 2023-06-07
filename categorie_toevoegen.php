<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D01-02 Category Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.php";
    require 'db-connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];

        // Controleren of de categorie al bestaat in de database
        $checkSql = "SELECT COUNT(*) FROM category WHERE name = :name";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':name', $name);
        $checkStmt->execute();
        $categoryCount = $checkStmt->fetchColumn();

        if ($categoryCount > 0) {
            echo "Deze categorie bestaat al in de database.";
        } else {
            if (isset($_POST["confirm"]) && $_POST["confirm"] == "Ja") {
                $sql = "INSERT INTO category (name) VALUES (:name)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);

                try {
                    $stmt->execute();
                    echo "Categorie succesvol toegevoegd.";
                } catch (PDOException $e) {
                    echo "Fout bij het toevoegen van de categorie: " . $e->getMessage();
                }
            } elseif (isset($_POST["confirm"]) && $_POST["confirm"] == "Nee") {
                echo "Categorie toevoegen geannuleerd.";
            } else {
                // Gebruiker om bevestiging vragen
                echo "Weet je zeker dat je de volgende categorie wilt toevoegen: " . $name . "?";
                echo "<br>";
                echo '<form method="post">';
                echo '<input type="hidden" name="name" value="' . $name . '">';
                echo '<input type="submit" name="confirm" value="Ja">';
                echo '<input type="submit" name="confirm" value="Nee">';
                echo '</form>';
            }
        }
    }
    ?>

    <form method="post">
        <label>Naam:</label>
        <input type="text" name="name" required><br>

        <input type="submit" value="Categorie toevoegen">
    </form>






</body>

</html>