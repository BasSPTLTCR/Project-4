<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product verwijderen</title>
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
        $productId = $_GET['delete'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the product is associated with any orders
            $orderCheckStmt = $pdo->prepare('SELECT * FROM purchaseline WHERE productid = ?');
            $orderCheckStmt->execute([$productId]);
            $associatedOrders = $orderCheckStmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($associatedOrders) > 0) {
                // Product is associated with one or more orders, cannot delete
                echo "Cannot delete the product as it is associated with one or more orders.";
            } else {
                // Delete the product from the database
                $deleteStmt = $pdo->prepare('DELETE FROM product WHERE ID = ?');
                $deleteStmt->execute([$productId]);

                // Output success message
                echo "Product deleted successfully.";
            }
        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
        }
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve products that are not associated with any orders
        $query = "SELECT * FROM product WHERE ID NOT IN (SELECT DISTINCT productid FROM purchaseline)";
        $stmt = $pdo->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the list of products
        echo "<h1>Products Not Associated with Orders</h1>";
        if (count($products) > 0) {
            echo "<ul>";
            foreach ($products as $product) {
                echo "<li>";
                echo $product['productname'];
                echo " <button onclick='confirmDelete(" . $product['ID'] . ")'>Delete</button>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No products found.</p>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

    <script>
        function confirmDelete(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "?delete=" + productId;
            }
        }
    </script>
</body>

</html>