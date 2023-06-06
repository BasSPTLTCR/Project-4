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

        if ($_SESSION['admin'] == 1) {
            echo "Welkom ".$_SESSION['klant_naam']."";
            $userEmail = $_SESSION['klant_email'];
        } else {
            echo "Je bent niet ingelogt!";
        }

        if (isset($_POST["adminDel"])) {
            $id = $_POST["adminDel"];
            
            $query = $conn->prepare("UPDATE `client` SET `admin` = 0 WHERE `id` = :id;");
            $query->bindValue(':id', $id);
            $query->execute();
        }

        try {
            $query = $conn->prepare("SELECT * FROM client WHERE admin = 1 AND email != :email;");
            $query->bindValue(':email', $userEmail);
            $query->execute();

            if ($query->rowCount() > 0) {
                $result1 = $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "Geen resultaat";
            }
        } catch(PDOException $e) {
            die("Fout bij verbinden met de database: " . $e->getMessage());
        }
    ?>

    <table class="beheerRechten">
        <tr>
            <th>id</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Email</th>
            <!-- <th>Adres</th>
            <th>Postcode</th>
            <th>Stad</th>
            <th>Provincie</th>
            <th>Land</th>
            <th>Telefoon nr.</th> -->
            <th>Admin</th>
        </tr>
        <?php
            // Itereer over elk resultaat en genereer de tabelrijen
            foreach ($result1 as $rij) {
                $admin = ($rij["admin"] == 1) ? "1" : "0";
                echo "<form method='post' class='beheerRecht'>";
                echo "<tr><td>".$rij["id"]."</td>";
                echo "<td>".$rij["first_name"]."</td>";
                echo "<td>".$rij["last_name"]."</td>";
                echo "<td>". $rij["email"] ."</td>";
                // echo "<td>". $rij["address"] ."</td>";
                // echo "<td>". $rij["zipcode"] ."</td>";
                // echo "<td>". $rij["city"] ."</td>";
                // echo "<td>". $rij["state"] ."</td>";
                // echo "<td>". $rij["country"] ."</td>";
                // echo "<td>". $rij["telephone"] ."</td>";
                echo "<td>". $rij["admin"] ."</td>";
                // echo "<td><button name='adminAdd' value='".$rij["id"]."'>Make admin</button></td>";
                echo "<td><button name='adminDel' value='".$rij["id"]."'>Remove admin</button></td>";
                echo "</tr>";
                echo "</form>";
            }
        ?>
</body>
</html>