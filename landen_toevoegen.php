<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C01-02 Landen Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
    include "./includes/nav.php";
    ?>
    <?php
    require 'db-connection.php';

    if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
        if (isset($_POST['agreed'])) { //User heeft dus nog geen akkoord gegeven...
            ?>

            U staat op het punt om
            <?php echo $_POST['name']; ?> met code
            <?php echo $_POST['code']; ?> aan te maken.

            Weet u dat zeker?
            <form method="post">
                <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">

                <input type="hidden" name="code" value="<?php echo $_POST['code']; ?>">

                <input type="hidden" nme="agreed" value="1" />
                <input type="submit" value="JA" name="JA">
                <button value="NEE" onclick="javascript:history.go(-1);">NEE</button>
            </form>

            <?php
        } else {
            if (isset($_POST['JA'])) {
                $name = $_POST["name"];
                $code = $_POST["code"];

                // Prepare the query
                $query = "SELECT name FROM country WHERE name = :name";
                $query2 = "SELECT code FROM country WHERE code = :code";

                // Prepare the statement
                $statement = $conn->prepare($query);
                $statement2 = $conn->prepare($query2);

                // Bind the name and code parameter
                $statement->bindParam(':name', $name);
                $statement2->bindParam(':code', $code);

                // Execute the statement
                $statement->execute();
                $statement2->execute();

                if ($statement->RowCount() === 0) {
                    if ($statement2->RowCount() === 0) {
                        $sql = "INSERT INTO country (name, code) VALUES (:name, :code)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':code', $code);

                        try {
                            $stmt->execute();
                            echo "Land succesvol toegevoegd.";
                        } catch (PDOException $e) {
                            echo "Fout bij het toevoegen van het land: " . $e->getMessage();
                        }
                    } else {
                        echo "Er bestaat al een land met deze code.";
                    }
                } else {
                    echo "Er bestaat al een land met deze naam";
                }
            }
        }
    } else {
        ?>
        <form method="post">
            <label>Naam:</label>
            <input type="text" name="name" required><br>

            <label>Code:</label>
            <input type="text" name="code" required><br>

            <input type="submit" name="agreed" value="Landen toevoegen">
        </form>
        <?php

    }
    ?>


</body>

</html>