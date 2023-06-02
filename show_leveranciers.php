<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leveranciers Lijst</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.html";

    $host = 'localhost';
    $dbname = 'befs';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT company, adress, zipcode, city, state, countryid FROM supplier');
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the table
        echo "<table>";
        echo "<tr><th>Company</th><th>Adress</th><th>Zipcode</th><th>City</th><th>State</th><th>Country ID</th></tr>";

        foreach ($tableData as $row) {
            echo "<tr>";
            echo "<td>" . $row['company'] . "</td>";
            echo "<td>" . $row['adress'] . "</td>";
            echo "<td>" . $row['zipcode'] . "</td>";
            echo "<td>" . $row['city'] . "</td>";
            echo "<td>" . $row['state'] . "</td>";
            echo "<td>" . $row['countryid'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

</body>

</html>