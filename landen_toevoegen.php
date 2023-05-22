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
require 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $code = $_POST["code"];

    $sql = "INSERT INTO country (name) VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':code', $code);

    try {
        $stmt->execute();
        echo "Land succesvol toegevoegd.";
    } catch (PDOException $e) {
        echo "Fout bij het toevoegen van het land: " . $e->getMessage();
    }
}
?>

<form method="post">
    <label>Naam:</label>
    <input type="text" name="name" required><br>

    <label>Code:</label>
    <input type="text" name="code" required><br>

    <input type="submit" value="Landen toevoegen">
</form>


</body>
</html>