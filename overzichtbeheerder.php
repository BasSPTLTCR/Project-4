<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>overzicht beheerder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    include "./includes/nav.php";
    ?>
<?php
// Verbinding maken met de database
$host = 'localhost';
$dbname = 'befs';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Fout bij het verbinden met de database: " . $e->getMessage();
}

// Query uitvoeren om beheerders/admins op te halen
$query = "SELECT * FROM client WHERE admin = 1";
$stmt = $conn->query($query);
$beheerders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Overzicht van beheerders tonen
if (count($beheerders) > 0) {
    echo "<h1>Overzicht van beheerders:</h1>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Voornaam</th><th>Achternaam</th><th>Email</th></tr>";
    foreach ($beheerders as $beheerder) {
        echo "<tr>";
        echo "<td>" . $beheerder['id'] . "</td>";
        echo "<td>" . $beheerder['first_name'] . "</td>";
        echo "<td>" . $beheerder['last_name'] . "</td>";
        echo "<td>" . $beheerder['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Geen beheerders gevonden.";
}

// Verbinding verbreken
$conn = null;
?>
</body>
</html>