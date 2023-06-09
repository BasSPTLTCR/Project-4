<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant verwijderen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include_once "./includes/nav.php";
    $host = 'localhost';
    $dbname = 'befs';
    $username = 'root';
    $password = '';

    if (isset($_GET['delete'])) {
        $customerId = $_GET['delete'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the customer has any purchases
            $purchaseCheckStmt = $pdo->prepare('SELECT * FROM purchase WHERE clientid = ?');
            $purchaseCheckStmt->execute([$customerId]);
            $associatedPurchases = $purchaseCheckStmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($associatedPurchases) > 0) {
                // Customer has one or more purchases, cannot delete
                echo "Cannot delete the customer as they have one or more purchases.";
            } else {
                // Delete the customer from the database
                $deleteStmt = $pdo->prepare('DELETE FROM client WHERE id = ?');
                $deleteStmt->execute([$customerId]);

                // Output success message
                echo "Customer deleted successfully.";
            }
        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
        }
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve customers who do not have any purchases
        $query = "SELECT * FROM client WHERE id NOT IN (SELECT DISTINCT clientid FROM purchase)";
        $stmt = $pdo->query($query);
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the list of customers in a table
        echo "<h1>Customers with No Purchases</h1>";
        if (count($customers) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
            foreach ($customers as $customer) {
                echo "<tr>";
                echo "<td>" . $customer['id'] . "</td>";
                echo "<td>" . $customer['first_name'] . " " . $customer['last_name'] . "</td>";
                echo "<td>" . $customer['email'] . "</td>";
                echo "<td><button onclick='confirmDelete(" . $customer['id'] . ")'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No customers found.</p>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

    <script>
        function confirmDelete(customerId) {
            if (confirm("Are you sure you want to delete this customer?")) {
                window.location.href = "?delete=" + customerId;
            }
        }
    </script>
</body>

</html>
