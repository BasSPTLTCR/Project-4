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

 // Prepare the query
 $query = "SELECT COUNT(name) AS count_name FROM country WHERE name = :name";

 // Prepare the statement
 $statement = $conn->prepare($query);

 // Bind the email parameter
 $statement->bindParam(':name', $name);

 // Execute the statement
 $statement->execute();

 // Fetch the result
 $result = $statement->fetch(PDO::FETCH_ASSOC);

 // Access the value of 'count_email'
 $countName = $result['count_name'];

 if ($countName == 0) {
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
}
    else  {
        echo "Er bestaat al een land met deze naam";
}}
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