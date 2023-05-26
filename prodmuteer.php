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
        $email = "sem@piekar.nl";
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
        
        $result1 = $query->fetchAll(PDO::FETCH_ASSOC);
        
        ?>
        
        <table class="prodmuteer">
            <tr>
                <th class="first">Active</th>
                <th class="second">Naam</th>
                <th class="third">Prijs</th>
                <!-- <th class="fourth"></th> -->
            </tr>
            <?php
                foreach ($result1 as $rij) {
                    if ($rij["active"] == "1") {  
                        $active = "1";
                        $activeValue = "Active";
                    } else {
                        $active = "0";
                        $activeValue = "Inactive";
                    }
                    echo "<form method='post' class='muteer-prod'>";
                    echo "<tr><td class='check'><input type='submit' name='activeToggle' value='".$activeValue."'></td>";
                    echo "<td>". $rij["productname"] ."</td>";
                    echo "<td>€". $rij["price"] ."</td>";
                    // echo "<td><input class='submit' type=submit name=`submit` value='Pas toe'></td>";
                    echo "</tr></form>";
                }

                
                
                if (ISSET($_POST["activeToggle"])) {
                    $activeToggle = $_POST["activeToggle"];
                    if ($active == "1") {
                        $active = "0";
                    } else {
                        $active = "1";
                    }
                
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO product (active) VALUES ('$active')";
                    $conn->exec($sql);
                } 
        ?>
        </table>
        


</body>

</html>