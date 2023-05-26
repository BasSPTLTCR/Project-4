<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Products</title>
</head>
<body>
<?php
        include "./includes/nav.html";
        ?>
<?php
        
            #1 verbinding database
            require './db-connection.php';
            session_start();
            $_SESSION["customerSignedIn"] = 1;
            

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $conn->prepare("SELECT product.*, category.name AS Category, supplier.company AS Supplier FROM product 
        INNER JOIN category ON category.id = product.categoryid 
        INNER JOIN supplier ON product.supplierid = supplier.id;");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>ID</th>
              <th>Product naam</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Prijs per product</th>";
        // if (isset($_SESSION["customerSignedIn"])) {
            echo "<th>Hoeveelheid</th>";
        // }
        ;
        // echo "<th>Inactief</th> </thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["productname"] . "</td>";
            echo "<td>" . $data["Category"] . "</td>";
            echo "<td>" . $data["Supplier"] . "</td>";
            echo "<td> € " . $data["price"] . "</td>";

            // if (isset($_SESSION["customerSignedIn"])) {
                echo '<td> <input type="number" name="number" id="number"></td>';
                echo '<td> <input type="submit" name="add" value="add to cart"></td>';
            // } 
            
            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="productid" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="productname" value="' . $data["productname"] . '">';
            echo '<input type="hidden" name="category" value="' . $data["Category"] . '">';
            echo '<input type="hidden" name="supplier" value="' . $data["Supplier"] . '">';
            echo '<input type="hidden" name="price" value="' . $data["price"] . '">';

            echo "</tr>";
            echo "</form>";
        }

        if (isset($_POST["add"])) {
            $number = $_POST["number"];

            if ($number < 0) {
                echo "teweinig geselecteerd";
            } else {
                // Retrieve the stored $data values
                $id = $_POST["productid"];
                $productName = $_POST["productname"];
                $category = $_POST["category"];
                $supplier = $_POST["supplier"];
                $price = $_POST["price"];
                $cost = $price * $number;
                date_default_timezone_set('Europe/Amsterdam');
                $date = date('Y-m-d', time());
                $delivered = 1;

                // Prepare the purchase insertion query
                try {
                    $fullQuery = $conn->prepare("INSERT INTO purchase (clientid, purchasedate, delivered) VALUES (:clientid, :purchasedate, :delivered)");
                } catch (PDOException $e) {
                    // if the Query can't run successfully, it will give an error message
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }

                // Execute the purchase insertion query
                $fullQuery->execute([
                    ":clientid" => $_SESSION["customerSignedIn"],
                    ":purchasedate" => $date,
                    ":delivered" => $delivered
                ]);

                // Fetch the last inserted purchase ID
                $purchaseId = $conn->lastInsertId();

                // Prepare and execute the purchaseline insertion query
                try {
                    $fullQuery2 = $conn->prepare("INSERT INTO purchaseline (purchaseid, productid, price, quantity) VALUES (:purchaseid, :productid, :price, :quantity)");
                } catch (PDOException $e) {
                    // if the Query can't run successfully, it will give an error message
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }

                $fullQuery2->execute([
                    ":purchaseid" => $purchaseId,
                    ":productid" => $id,
                    ":quantity" => $number,
                    ":price" => $cost
                ]);

                $message = "Insertion successful";
            }
        }
        ?>
</body>
</html>