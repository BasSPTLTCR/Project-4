<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A02-03 Klanten zien</title>
    <link rel="stylesheet" href="./style.css">  
</head>

<body>
<?php
    session_start();
    include_once "./includes/nav.php";

    require 'db-connection.php';

    // Check if the user is logged in as an admin
    if ($_SESSION['admin'] == 1) {
        echo "Welkom ".$_SESSION['klant_naam']."";
    } else {
        echo "Je bent niet ingelogd!";
        // header('location: index.php');
        // exit();
    }

    try {
        $query = $conn->prepare("SELECT * FROM `client` WHERE admin = 0;");
    } catch(PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }

    $query->execute();

    if ($query->rowCount() == 0) {
        echo "Geen resultaten";
    }
    $result1 = $query->fetchAll(PDO::FETCH_ASSOC);

?>

    <br>
    <table>
        <tr>
            <th>id</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Email</th>
            <th>Adres</th>
            <th>Postcode</th>
            <th>Stad</th>
            <th>Provincie</th>
            <th>Land</th>
            <th>Telefoon nr.</th>
        </tr>

    
    <?php 
        foreach ($result1 as $rij) {
            echo "<tr>";
            echo "<td>" . $rij["id"] . "</td>";
            echo "<td>" . $rij["first_name"] . "</td>";
            echo "<td>" . $rij["last_name"] . "</td>";
            echo "<td>" . $rij["email"] . "</td>";
            echo "<td>" . $rij["address"] ."</td>";
            echo "<td>" . $rij["zipcode"] . "</td>";
            echo "<td>" . $rij["city"] . "</td>";
            echo "<td>" . $rij["state"] . "</td>";
            echo "<td>" . $rij["country"] . "</td>";
            echo "<td>" . $rij["telephone"] . "</td>";
            echo "</tr>";
        }
    ?>

    </table>

</body>

</html>
