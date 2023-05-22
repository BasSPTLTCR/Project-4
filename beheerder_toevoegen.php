<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Beheerder toevoegen</title>
</head>
<body>
<?php
require 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];

    $sql = "INSERT INTO admin (email, name, password) VALUES (:email, :name, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);

    try {
        $stmt->execute();
        echo "Beheerder succesvol toegevoegd.";
    } catch (PDOException $e) {
        echo "Fout bij het toevoegen van de beheerder: " . $e->getMessage();
    }
}
?>

<form method="post">
    <label>E-mail:</label>
    <input type="text" name="email" required><br>

    <label>Naam:</label>
    <input type="text" name="name" required><br>

    <label>Wachtwoord:</label>
    <input type="text" name="password" required><br>

    <input type="submit" value="Beheerder toevoegen">
</form>
</body>
</html>



