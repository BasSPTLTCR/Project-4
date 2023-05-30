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
    include_once "./includes/nav.html";

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
            $statement->bindValue(':filteredEmail', $filteredEmail);
            
            // Execute the statement
            $statement->execute();
            
            // Fetch the result
            $countEmail = $statement->rowCount();
            
            if ($countEmail >= 0) {
                if ($filteredPassword == $filteredPasswordVeri) {
                    $sql = "INSERT INTO client (email, first_name, last_name, password, address, zipcode, city, state, country, telephone, admin)
                            VALUES (:filteredEmail, :filteredFirstname, :filteredLastname, :hashedpw, :filteredAddress, :filteredZipcode, :filteredCity, :filteredState, :filteredCountry, :filteredTelephone, :admin)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':filteredEmail', $filteredEmail);
                    $stmt->bindValue(':filteredFirstname', $filteredFirstname);
                    $stmt->bindValue(':filteredLastname', $filteredLastname);
                    $stmt->bindValue(':hashedpw', $hashedpw);
                    $stmt->bindValue(':filteredAddress', $filteredAddress);
                    $stmt->bindValue(':filteredZipcode', $filteredZipcode);
                    $stmt->bindValue(':filteredCity', $filteredCity);
                    $stmt->bindValue(':filteredState', $filteredState);
                    $stmt->bindValue(':filteredCountry', $filteredCountry);
                    $stmt->bindValue(':filteredTelephone', $filteredTelephone);
                    $stmt->bindValue(':admin', $admin);
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

    try {
        $oneQuery = $conn->prepare("SELECT name AS 'countryname' FROM `country`;");
    } catch(PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }
    $oneQuery->execute();
    
    $result1 = $oneQuery->fetchAll(PDO::FETCH_ASSOC);
    
    ?>
    
    <div class="register-container">
        <form action="" class="form-register" method="POST">
            <ul class="register-nav">
                <li class="register-nav__item active">
                    <a href="./login.php">Registreren</a>
                </li>
                <li class="register-nav__item">
                    <a href="./signup.php">Aanmelden</a>
                </li>
            </ul>
            <label for="register-input-firstname" class="register__label">
                Voornaam
            </label>
            <input id="register-input-firstname" class="register__input" type="text" name="firstname"
                placeholder="Voornaam" required />
            <label for="register-input-lastname" class="register__label">
                Achternaam
            </label>
            <input id="register-input-lastname" class="register__input" type="text" name="lastname"
                placeholder="Achternaam" required />
            <label for="register-input-email" class="register__label">
                E-mail
            </label>
            <input id="register-input-email" class="register__input" type="email" name="email" placeholder="E-mail"
                required />
            <label for="register-input-password" class="register__label">
                Wachtwoord
            </label>
            <input id="register-input-password" class="register__input" type="password" name="password"
                placeholder="Wachtwoord" required />
            <label for="register-input-password-verify" class="register__label">
                Bevestig Wachtwoord
            </label>
            <input id="register-input-password-verify" class="register__input" type="password" name="passwordVerify"
                placeholder="Bevestig Wachtwoord" required />
            <label for="register-input-address" class="register__label">
                Adres
            </label>
            <input id="register-input-address" class="register__input" type="text" name="address" placeholder="Adres"
                required />
            <label for="register-input-zipcode" class="register__label">
                Postcode
            </label>
            <input id="register-input-zipcode" class="register__input" type="text" name="zipcode" placeholder="Postcode"
                required />
            <label for="register-input-city" class="register__label">
                Stad
            </label>
            <input id="register-input-city" class="register__input" type="text" name="city" placeholder="Stad"
                required />
            <label for="register-input-state" class="register__label">
                Provincie
            </label>
            <input id="register-input-state" class="register__input" type="text" name="state" placeholder="Provincie"
                required />
            <label for="register-input-country" class="register__label">
                Land
            </label>
            <select id="register-input-country" name="country" id="countryname">
                <option value="">------------------- Land -------------------</option>
                <?php
          foreach($result1 as $rij) {
            echo "<option>".$rij["countryname"]."</option>";
          }
        ?>
            </select>
            <label for="register-input-telephone" class="register__label">
                Telefoonnummer
            </label>
            <input id="register-input-telephone" class="register__input" type="text" name="telephone"
                placeholder="Telefoonnummer" required />
            <button class="register__submit" type="submit" name="register" value="Klant toevoegen">Registreer</button>
        </form>
    </div>



</body>

</html>