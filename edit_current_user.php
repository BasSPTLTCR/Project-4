<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huidige gebruiker wijzigen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.php";
    ini_set('display_errors', 1);
    $host = 'localhost';
    $dbname = 'befs';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = "UPDATE `client` SET ";
            $query .= "`first_name`=:first_name,";
            $query .= "`last_name`=:last_name,";
            $query .= "`address`=:address,";
            $query .= "`zipcode`=:zipcode,";
            $query .= "`city`=:city,";
            $query .= "`state`=:state,";
            $query .= "`country`=:country,";
            $query .= "`telephone`=:telephone ";
            $query .= "WHERE id = :id";

            $statement = $pdo->prepare($query);
            $statement->bindParam(':id', $_SESSION["klant_id"]);
            $statement->bindParam(':first_name', $_POST['firstname']);
            $statement->bindParam(':last_name', $_POST['lastname']);
            $statement->bindParam(':address', $_POST["address"]);
            $statement->bindParam(':zipcode', $_POST["zipcode"]);
            $statement->bindParam(':city', $_POST["city"]);
            $statement->bindParam(':state', $_POST["state"]);
            $statement->bindParam(':country', $_POST["country"]);
            $statement->bindParam(':telephone', $_POST["telephone"]);
            $statement->execute();
        }

        $query = "SELECT first_name, last_name, address, zipcode, city, state, country, telephone FROM client WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $_SESSION["klant_id"]);
        $statement->execute();
        $currentUser = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
        <form method="POST">
            <div">
                <input type="text" name="firstname" value="<?php echo $currentUser['first_name'] ?>" required>
                <span></span>
                <label>First Name</label>
            </div>
            <div>
                <input type="text" name="lastname" value="<?php echo $currentUser['last_name'] ?>" required>
                <span></span>
                <label>Last Name</label>
            </div>
            <div>
                <div>
                    <input type="text" name="address" value="<?php echo $currentUser['address'] ?>" required>
                    <span></span>
                    <label>Address</label>
                </div>
                <div>
                    <input type="text" name="zipcode" value="<?php echo $currentUser['zipcode'] ?>" required>
                    <span></span>
                    <label>Zipcode</label>
                </div>
            </div>
            <div>
                <div>
                    <input type="text" name="city" value="<?php echo $currentUser['city'] ?>" required>
                    <span></span>
                    <label>City</label>
                </div>
                <div >
                    <input type="text" name="state" value="<?php echo $currentUser['state'] ?>" required>
                    <span></span>
                    <label>State</label>
                </div>
                <div>
                    <input type="text" name="telephone" value="<?php echo $currentUser['telephone'] ?>" required>
                    <span></span>
                    <label>Telephone number</label>
                </div>
            </div>
            <select class="txt_field2" name="country" value="<?php echo $currentUser['country'] ?>" id="countryname">
                <option value="">Country</option>
                <?php
                foreach ($pdo->query("SELECT name FROM country") as $rij) {
                    if ($currentUser['country'] === $rij['name']) {
                        echo "<option selected value=\"" . $rij['name'] . "\">" . $rij["name"] . "</option>";
                    } else {
                        echo "<option value=\"" . $rij['name'] . "\">" . $rij["name"] . "</option>";
                    }
                }
                ?>
            </select>
            <input class="gegevens_submit" type="submit" value="Gegevens Wijzigen">
        <?php

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
        ?>

</body>

</html>