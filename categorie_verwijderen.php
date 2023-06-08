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
        exit; // Add exit after header redirect to stop executing the rest of the code
    }

    if (isset($_POST["catDel"])) {
        $categoryID = $_POST["catDel"];
        try {
            $deleteStatement = $conn->prepare("DELETE FROM category WHERE ID = :categoryID");
            $deleteStatement->bindParam(':categoryID', $categoryID);
            $deleteStatement->execute();
            echo "Categorie succesvol verwijderd!";
        } catch (PDOException $e) {
            die("Fout bij verbinden met de database: " . $e->getMessage());
        }
    }

    try {
        $sql = $conn->prepare("
            SELECT category.ID, category.name, COUNT(purchase.delivered) AS not_delivered
            FROM category
            LEFT JOIN product ON category.ID = product.categoryid
            LEFT JOIN purchaseline ON product.ID = purchaseline.productid
            LEFT JOIN purchase ON purchaseline.purchaseid = purchase.ID AND (purchase.delivered = 0 OR purchase.delivered IS NULL)
            GROUP BY category.ID, category.name
            ");
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }

    ?>

    <table>
        <tr>
            <th>Naam</th>
            <th>Niet bezorgd</th>
            <th></th>
        </tr>
        <?php
        foreach ($result as $rij) {
            echo "<tr><td>" . $rij["name"] . "</td>";
            echo "<td>" . $rij["not_delivered"] . "</td>";
            echo "<td>";
            if ($rij["not_delivered"] <= 0) {
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='catDel' value='" . $rij["ID"] . "'>";
                echo "<button type='submit'>Verwijder</button>";
                echo "</form>";
            }
            echo "</td></tr>";
        }
        ?>
    </table>
</body>

</html>
