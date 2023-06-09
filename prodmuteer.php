<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Muteren</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    session_start();

    include_once "./includes/nav.php";

    require 'db-connection.php';

    if ($_SESSION['admin'] == 1) {
        echo "Welkom " . $_SESSION['klant_naam'] . "";
    } else {
        header('location: index.php');
        exit();
    }

    try {
        if (isset($_POST["active"])) {
            $productId = $_POST["active"];
            $productName = $_POST["productName"];
            // Stap 1: Toon bevestigingsbericht en verwijderingsformulier
            echo "Weet je zeker dat je " . $productName . " actief wil zetten?";
            echo "<br>";
            echo '<form method="post">';
            echo '<input type="hidden" name="productId" value="' . $productId . '">';
            echo '<input type="submit" name="confirmActive" value="Ja">';
            echo '<input type="submit" name="confirmActive" value="Nee">';
            echo '</form>';
        } elseif (isset($_POST["confirmActive"])) {
            if ($_POST["confirmActive"] == "Ja") {
                // Stap 2: Voer categorie verwijdering uit
                $productId = $_POST["productId"];
                $deleteStatement = $conn->prepare("UPDATE `product` SET `active` = 1 WHERE `ID` = :productId;");
                $deleteStatement->bindValue(':productId', $productId);
                $deleteStatement->execute();
                echo "Product succesvol geactiveerd!";
            } else {
                // Stap 3: Verwijdering geannuleerd
                echo "Product actief zetten geannuleerd.";
            }
        }

        if (isset($_POST["inactive"])) {
            $productId = $_POST["inactive"];
            $productName = $_POST["productName"];
            // Stap 1: Toon bevestigingsbericht en verwijderingsformulier
            echo "Weet je zeker dat je " . $productName . " inactief wil zetten?";
            echo "<br>";
            echo '<form method="post">';
            echo '<input type="hidden" name="productId" value="' . $productId . '">';
            echo '<input type="submit" name="confirmInactive" value="Ja">';
            echo '<input type="submit" name="confirmInactive" value="Nee">';
            echo '</form>';
        } elseif (isset($_POST["confirmInactive"])) {
            if ($_POST["confirmInactive"] == "Ja") {
                // Stap 2: Voer categorie verwijdering uit
                $productId = $_POST["productId"];
                $deleteStatement = $conn->prepare("UPDATE `product` SET `active` = 0 WHERE `ID` = :productId;");
                $deleteStatement->bindValue(':productId', $productId);
                $deleteStatement->execute();
                echo "Product succesvol gedeactiveerd!";
            } else {
                // Stap 3: Verwijdering geannuleerd
                echo "Product inactief zetten geannuleerd.";
            }
        }
    
        } catch (PDOException $e) {
            die("Fout bij verbinden met de database: " . $e->getMessage());
        }

        // if (isset($_POST["active"])) {
        //     $productId = $_POST["active"];
            
        //     $query = $conn->prepare("UPDATE `product` SET `active` = 1 WHERE `ID` = :productId;");
        //     $query->bindValue(':productId', $productId);
        //     $query->execute();
        // }
        
        // if (isset($_POST["inactive"])) {
        //     $productId = $_POST["inactive"];
            
        //     $query = $conn->prepare("UPDATE `product` SET `active` = 0 WHERE `ID` = :productId;");
        //     $query->bindValue(':productId', $productId);
        //     $query->execute();
        // }
        
        try {
            $query = $conn->prepare("SELECT * FROM `product`;");
        } catch(PDOException $e) {
            die("Fout bij verbinden met de database: " . $e->getMessage());
        }

        $query->execute();

        if ($query->RowCount() < 0)
        $result1 = $query->FetchAll(PDO::FETCH_ASSOC);

    ?>


    <table class="prodmuteer">
        <tr>
            <th class="first">Active</th>
            <th class="second">Naam</th>
            <th class="third">Prijs</th>
        </tr>
        <?php
            foreach ($query as $rij) {
                $activeClass = ($rij["active"] == 1) ? "active" : "inactive";
                echo "<form method='post' class='muteer-prod'>";
                echo "<tr>";
                echo "<td class='" . $activeClass . "'><input type='hidden' name='productName' value " . $rij["productname"] . ">";
                echo "<button type='submit' name='active' value='" . $rij["ID"] . " onclick='return confirm(\"Are you sure you want to activate this product?\")'>Active</button>";
                echo "<button type='submit' name='inactive' value='" . $rij["ID"] . " onclick='return confirm(\"Are you sure you want to Deactivate this product?\")'>Inactive</button></td>";
                echo "<td class='" . $activeClass . "'>". $rij["productname"] ."</td>";
                echo "<td class='" . $activeClass . "'>€". $rij["price"] ."</td>";
                echo "</tr>";
                echo "</form>";
            }
        ?>
    </table>



</body>

</html>