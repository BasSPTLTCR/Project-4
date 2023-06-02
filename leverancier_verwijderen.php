<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier verwijderen</title>
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
        $supplierId = $_GET['delete'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Delete the supplier from the database
            $stmt = $pdo->prepare('DELETE FROM supplier WHERE ID = ?');
            $stmt->execute([$supplierId]);

            // Output success message
            echo "Supplier deleted successfully.";
        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
        }
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve suppliers who do not have any products
        $query = "SELECT s.* FROM supplier s LEFT JOIN product p ON s.ID = p.supplierid WHERE p.supplierid IS NULL";
        $stmt = $pdo->query($query);
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the list of suppliers
        echo "<h1>Suppliers with No Products</h1>";
        if (count($suppliers) > 0) {
            echo "<ul>";
            foreach ($suppliers as $supplier) {
                echo "<li>";
                echo $supplier['company'];
                echo " <button onclick='confirmDelete(" . $supplier['ID'] . ")'>Delete</button>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No suppliers found.</p>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

    <script>
        function confirmDelete(supplierId) {
            if (confirm("Are you sure you want to delete this supplier?")) {
                window.location.href = "?delete=" + supplierId;
            }
        }
    </script>





</body>

</html>