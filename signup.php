<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A01-01 Klant Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    require 'db-connection.php';

    function sanitizeInput($value)
    {
        // Sanitize user input
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    if (isset($_POST["register"])) {
        $filteredFirstname = sanitizeInput($_POST["firstname"]);
        $filteredLastname = sanitizeInput($_POST["lastname"]);
        $filteredPassword = sanitizeInput($_POST["password"]);
        $filteredPasswordVeri = sanitizeInput($_POST["passwordVerify"]);
        $filteredEmail = sanitizeInput($_POST["email"]);
        $filteredAddress = sanitizeInput($_POST["address"]);
        $filteredZipcode = sanitizeInput($_POST["zipcode"]);
        $filteredCity = sanitizeInput($_POST["city"]);
        $filteredState = sanitizeInput($_POST["state"]);
        $filteredCountry = sanitizeInput($_POST["country"]);
        $filteredTelephone = sanitizeInput($_POST["telephone"]);

        try {
            $hashedpw = password_hash($filteredPassword, PASSWORD_DEFAULT);
            $admin = "0";

            // Prepare the query
            $query = "SELECT COUNT(email) AS count_email FROM client WHERE email = :filteredEmail";

            // Prepare the statement
            $statement = $conn->prepare($query);

            // Bind the email parameter
            $statement->bindParam(':filteredEmail', $filteredEmail);

            // Execute the statement
            $statement->execute();

            // Fetch the result
            $countEmail = $statement->rowCount();

            if ($countEmail >= 0) {
                if ($filteredPassword == $filteredPasswordVeri) {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO client (email, first_name, last_name, password, address, zipcode, city, state, country, telephone, admin)
                            VALUES (:filteredEmail, :filteredFirstname, :filteredLastname, :hashedpw, :filteredAddress, :filteredZipcode, :filteredCity, :filteredState, :filteredCountry, :filteredTelephone, :admin)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':filteredEmail', $filteredEmail);
                    $stmt->bindParam(':filteredFirstname', $filteredFirstname);
                    $stmt->bindParam(':filteredLastname', $filteredLastname);
                    $stmt->bindParam(':hashedpw', $hashedpw);
                    $stmt->bindParam(':filteredAddress', $filteredAddress);
                    $stmt->bindParam(':filteredZipcode', $filteredZipcode);
                    $stmt->bindParam(':filteredCity', $filteredCity);
                    $stmt->bindParam(':filteredState', $filteredState);
                    $stmt->bindParam(':filteredCountry', $filteredCountry);
                    $stmt->bindParam(':filteredTelephone', $filteredTelephone);
                    $stmt->bindParam(':admin', $admin);
                    $stmt->execute();

                    echo "Gebruiker succesvol aangemaakt!";
                } else {
                    echo "Wachtwoord klopt niet";
                }
            } else {
                echo "Email is al in gebruik.";
            }
        } catch (PDOException $e) {
            echo "Fout bij verbinden met de database: " . $e->getMessage();
        }
    }
    ?>

    <form method="post">
        <input type="text" name="firstname" placeholder="Voornaam" required><br>
        <input type="text" name="lastname" placeholder="Achternaam" required><br>
        <input type="text" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <input type="password" name="passwordVerify" placeholder="Herhaal wachtwoord" required><br>
        <input type="text" name="address" placeholder="Adres" required><br>
        <input type="text" name="zipcode" placeholder="Postcode" required><br>
        <input type="text" name="city" placeholder="Stad" required><br>
        <input type="text" name="state" placeholder="Provincie/Staat" required><br>
        <select name="country" id="countryname">
            <option value="">--------------------------- Land ---------------------------</option>

            <?php
                    foreach($oneQuery as $rij) 
                    {
                        echo "<option>".$rij["countryname"]."</option>";
                    }
                ?>
        </select><br>
        <input type="text" name="telephone" placeholder="Telefoon nummer" required><br>

        <input type="submit" value="Klant toevoegen" name="register">
    </form>


</body>

</html>