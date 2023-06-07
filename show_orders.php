<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landen lijst</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.php";

    $host = 'localhost';
    $dbname = 'befs';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT purchase.ID, first_name, last_name, purchasedate, delivered FROM purchase INNER JOIN client ON purchase.clientid = client.id');
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the table
        echo "<table>";
        echo "<tr><th>Client name</th><th>Purchase Date</th><th> Delivered</th></tr>";

        foreach ($tableData as $row) {
            $delivered = ($row['delivered'] === 1) ? "Yes" : "No";
            echo "<tr>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . $row['purchasedate'] . "</td>";
            echo "<td>" . $delivered . "</td>";
            echo "<td><a href=\"delete_orders.php?id=" . $row['ID'] . "\">Verwijderen</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
</body>

</html>