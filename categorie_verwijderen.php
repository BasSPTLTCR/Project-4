<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEFS</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php
    session_start(); // Start de sessie

    include_once "./includes/nav.php";

    require 'db-connection.php'; // Zorg ervoor dat het pad naar db-connection.php correct is

    if ($_SESSION['admin'] != 1) {
        echo "Je bent geen admin!";
        header('location: index.php');
        exit; // Voeg 'exit' toe na het doorsturen met 'header' om de rest van de code te stoppen
    }

    try {
        if (isset($_POST["catID"])) {
            $catID = $_POST["catID"];
            $catName = $_POST["catName"];

            // Stap 1: Toon bevestigingsbericht en verwijderingsformulier
            echo "Weet je zeker dat je de volgende categorie wilt verwijderen met de naam: " . $catName . "?";
            echo "<br>";
            echo '<form method="post">';
            echo '<input type="hidden" name="categoryID" value="' . $catID . '">';
            echo '<input type="submit" name="confirm" value="Ja">';
            echo '<input type="submit" name="confirm" value="Nee">';
            echo '</form>';
        } elseif (isset($_POST["confirm"])) {
            if ($_POST["confirm"] == "Ja") {
                // Stap 2: Voer categorie verwijdering uit
                $categoryID = $_POST["categoryID"];
                $deleteStatement = $conn->prepare("DELETE FROM category WHERE ID = :categoryID");
                $deleteStatement->bindValue(':categoryID', $categoryID);
                $deleteStatement->execute();
                echo "Categorie succesvol verwijderd!";
            } else {
                // Stap 3: Verwijdering geannuleerd
                echo "Categorie verwijderen geannuleerd.";
            }
        }

    try {
        $sql = $conn->prepare("SELECT category.ID, category.name, COUNT(purchase.delivered) AS not_delivered
            FROM category
            LEFT JOIN product ON category.ID = product.categoryid
            LEFT JOIN purchaseline ON product.ID = purchaseline.productid
            LEFT JOIN purchase ON purchaseline.purchaseid = purchase.ID AND (purchase.delivered = 0 OR purchase.delivered IS NULL)
            GROUP BY category.ID, category.name");
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th></th>
        </tr>
        <?php
        foreach ($result as $rij) {
            echo "<tr><td>" . $rij["category_id"] . "</td>";
            echo "<td>" . $rij["nameCat"] . "</td>";
            echo "<td>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='catID' value='" . $rij["category_id"] . "'>";
            echo "<input type='hidden' name='catName' value='" . $rij["nameCat"] . "'>";
            echo "<button type='submit'>Verwijder</button>";
            echo "</form>";
            echo "</td></tr>";
        }
        ?>
    </table>
</body>

</html>
