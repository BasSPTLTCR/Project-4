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
        include_once "./includes/nav.html";
        
        require 'db-connection.php';
        
        // $email = "";
        // ^ dit als voorbeeld zonder inlog gegevens
        // $email = "sem@piekar.nl";
        // ^ deze is admin
        // $email = "csalzenbs@ehow.com";
        // ^ deze is geen admin

        $client = $conn->prepare("SELECT * FROM `client` WHERE email = :email;");
        $client->bindParam(':email', $email);
        $client->execute();
        
        $result = $client->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($result)) {
            $adminCheck = $result[0]['admin'];
            if ($adminCheck == "0") {
                header('location: index.php');
                exit();
            } else {
                echo "<br> You are an admin signed in as " . $result[0]["first_name"];
            }
        } else {
            header('location: index.php');
            exit();
        }
        
        try {
            $query = $conn->prepare("SELECT * FROM `product`;");
        } catch(PDOExeption $e) {
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
            echo "<form method='post' class='muteer-prod'>";
            echo "<tr><td class='check'><input type='checkbox'></td>";
            echo "<td>". $rij["productname"] ."</td>";
            echo "<td>€". $rij["price"] ."</td></tr>";
            echo "</form>";
        }
        
    ?>
    </table>



</body>

</html>