<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aankoop per klant</title>
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

        $customersQuery = $pdo->query('SELECT client.*, COUNT(purchase.id) AS total_orders
                                  FROM client
                                  LEFT JOIN purchase ON client.id = purchase.clientid
                                  GROUP BY client.id');
        $customers = $customersQuery->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>";
        echo "<tr><th>Client ID</th><th>First Name</th><th>Last Name</th><th>Total Orders</th></tr>";

        foreach ($customers as $customer) {
            echo "<tr>";
            echo "<td>" . $customer['id'] . "</td>";
            echo "<td>" . $customer['first_name'] . "</td>";
            echo "<td>" . $customer['last_name'] . "</td>";
            echo "<td>" . $customer['total_orders'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>



</body>

</html>