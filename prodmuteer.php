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

        if ($_SESSION['admin'] == 1) {
            $email = $_SESSION['klant_email'];
            echo "Welkom ".$_SESSION['klant_naam']."";
        } else {
            // header('location: index.php');
            // exit();
            echo "Je bent niet ingelogt!";
        }


        include_once "./includes/nav.php";
        
        require 'db-connection.php';


        // $email = "";
        // ^ dit als voorbeeld zonder inlog gegevens
        // $email = "sem@piekar.nl";
        // ^ deze is admin
        // $email = "csalzenbs@ehow.com";
        // ^ deze is geen admin
        




        if (isset($_POST["active"])) {
            // $productId = $_POST["active"];
            session_abort();
            // $query = $conn->prepare("UPDATE `product` SET `active` = 1 WHERE `ID` = :productId;");
            // $query->bindValue(':productId', $productId);
            // $query->execute();
        }
        
        if (isset($_POST["inactive"])) {
            $productId = $_POST["inactive"];
            
            $query = $conn->prepare("UPDATE `product` SET `active` = 0 WHERE `ID` = :productId;");
            $query->bindValue(':productId', $productId);
            $query->execute();
        }
        
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
                echo "<td class='" . $activeClass . "'><button type='submit' name='active' value='" . $rij["ID"] . " onclick='return confirm(\"Are you sure you want to activate this product?\")'>Active</button>";
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