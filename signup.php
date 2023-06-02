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
    include_once "./includes/nav.php";


    try {
        $oneQuery = $conn->prepare("SELECT name AS countryname FROM `country`;");
    } catch (PDOException $e) {
        die("Fout bij verbinden met de database: " . $e->getMessage());
    }
    $oneQuery->execute();

    if ($oneQuery->RowCount() < 0)
        $result1 = $oneQuery->FetchAll(PDO::FETCH_ASSOC);


    if (isset($_POST["register"])) {

        if ($_POST["email"] != "" && $_POST["firstname"] != "" && $_POST["lastname"] != "" && $_POST["password"] != "") {

            try {
                $email = $_POST["email"];
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $hashedpw = password_hash($password, PASSWORD_DEFAULT);
                $password = $_POST["password"];
                $passwordVerify = $_POST["passwordVerify"];
                $address = $_POST["address"];
                $zipcode = $_POST["zipcode"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $country = $_POST["country"];
                $phonenr = $_POST["telephone"];

                // Prepare the query
                $query = "SELECT COUNT(email) AS count_email FROM client WHERE email = :email";

                // Prepare the statement
                $statement = $conn->prepare($query);

                // Bind the email parameter
                $statement->bindParam(':email', $email);

                // Execute the statement

                $statement->execute();
                // Fetch the result
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                // Access the value of 'count_email'
                $countEmail = $result['count_email'];

                if ($countEmail == 0) {
                    if ($password == $passwordVerify) {
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "INSERT INTO client (email, first_name, last_name, password, address, zipcode, city, state, country, telephone) VALUES ( '$email', '$firstname', '$lastname', '$hashedpw', '$address', '$zipcode', '$city', '$state', '$country', '$phonenr')";
                        $conn->exec($sql);
                    } else {
                        echo "Wachtwoord klopt niet";
                    }
                } else {
                    echo "Email is al in gebruik.";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $_SESSION["message"] = array("text" => "Gebruiker succesvol aangemaakt", "alert" => "info");
            $conn = null;
            // header('location:index.php');
        } else {
            echo "
            <script>alert('Please fill up the required field!')</script>
            <script>window.location = 'clientadd.php'</script>";
        }
    };

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
            foreach ($oneQuery as $rij) {
                echo "<option>" . $rij["countryname"] . "</option>";
            }
            ?>
        </select><br>
        <input type="text" name="telephone" placeholder="Telefoon nummer" required><br>

        <input type="submit" value="Klant toevoegen" name="register">
    </form>

</body>

</html>