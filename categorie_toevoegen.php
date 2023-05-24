<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D01-02 Category Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require 'db-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $sql = "INSERT INTO category (name) VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);

    try {
        $stmt->execute();
        echo "Categorie succesvol toegevoegd.";
    } catch (PDOException $e) {
        echo "Fout bij het toevoegen van de categorie: " . $e->getMessage();
    }
}
?>

<form method="post">
    <label>Naam:</label>
    <input type="text" name="name" required><br>

    <input type="submit" value="Categorie toevoegen">
</form>


</body>
</html>