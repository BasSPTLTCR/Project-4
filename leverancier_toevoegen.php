<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D01-01 Leveranciers Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.php";
    require 'db-connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $company = $_POST["company"];
        $adress = $_POST["adress"];
        $streetnr = $_POST["streetnr"];
        $zipcode = $_POST["zipcode"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $countryid = $_POST["countryid"];
        $telephone = $_POST["telephone"];
        $website = $_POST["website"];


        $sql = "INSERT INTO supplier (company, adress, streetnr, zipcode, city, state, countryid, telephone, website)
    VALUES (:company, :adress, :streetnr, :zipcode, :city, :state, :countryid, :telephone, :website)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':streetnr', $streetnr);
        $stmt->bindParam(':zipcode', $zipcode);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':countryid', $countryid);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':website', $website);

        try {
            $stmt->execute();
            echo "Leverancier succesvol toegevoegd.";
        } catch (PDOException $e) {
            echo "Fout bij het toevoegen van de Leverancier: " . $e->getMessage();
        }
    }
    ?>

    <form method="post">
        <label>Bedrijfsnaam:</label>
        <input type="text" name="company" required><br>

        <label>Adres:</label>
        <input type="text" name="adress" required><br>

        <label>Huisnummer:</label>
        <input type="text" name="streetnr" required><br>

        <label>Postcode:</label>
        <input type="text" name="zipcode" required><br>

        <label>Plaats:</label>
        <input type="text" name="city" required><br>

        <label>Provincie:</label>
        <input type="text" name="state" required><br>

        <label>Land ID:</label>
        <input type="text" name="countryid" required><br>

        <label>Telefoonnummer:</label>
        <input type="tel" name="telephone" required><br>

        <label>Website:</label>
        <input type="text" name="website" required><br>

        <input type="submit" value="Leverancier toevoegen">
    </form>

</body>

</html>