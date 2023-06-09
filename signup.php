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
    include_once "./includes/nav.php";

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
            $countEmail = $statement->fetchColumn();
            
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
        $oneQuery = $conn->prepare("SELECT name AS countryname FROM `country`;");
    } catch(PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }
    $oneQuery->execute();
    
    $result1 = $oneQuery->fetchAll(PDO::FETCH_ASSOC);
    
    ?>


    <div class="center1">
        <h1>Sign Up</h1>
        <form method="POST">
            <div class="txt_field">
                <input type="text" name="firstname" required>
                <span></span>
                <label>First Name</label>
            </div>
            <div class="txt_field">
                <input type="text" name="lastname" required>
                <span></span>
                <label>Last Name</label>
            </div>
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="txt_field">
                <input type="password" name="passwordVerify" required>
                <span></span>
                <label>Verify Password</label>
            </div>
            <div class="txt_container">
                <div class="txt_field1">
                    <input type="text" name="address" required>
                    <span></span>
                    <label>Address</label>
                </div>
                <div class="txt_field1">
                    <input type="text" name="zipcode" required>
                    <span></span>
                    <label>Zipcode</label>
                </div>
            </div>
            <div class="txt_container">
                <div class="txt_field1">
                    <input type="text" name="city" required>
                    <span></span>
                    <label>City</label>
                </div>
                <div class="txt_field1">
                    <input type="text" name="state" required>
                    <span></span>
                    <label>State</label>
                </div>
            </div>
            <select class="txt_field2" name="country" id="countryname">
                <option value="">Land</option>
                <?php
                foreach ($result1 as $row) {
                    echo "<option>" . $row["countryname"] . "</option>";
                }
                ?>
            </select><br>
            <input class="loginSubmit" type="submit" name="register" value="Account Maken">
            <div class="signup_link">
                Already have an account? <a href="./login.php">Sign in</a>
            </div>
        </form>
    </div>

</body>

</html>
