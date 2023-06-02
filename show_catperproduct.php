<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie per product</title>
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

        // Haal de categorieën op
        $categoriesQuery = $pdo->query('SELECT * FROM category');
        $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

        // Loop door elke categorie en haal de bijbehorende producten op
        foreach ($categories as $category) {
            $categoryId = $category['ID'];
            $productsQuery = $pdo->prepare('SELECT * FROM product WHERE categoryid = :categoryid');
            $productsQuery->bindParam(':categoryid', $categoryId);
            $productsQuery->execute();
            $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);

            // Toon de categorie en de bijbehorende producten
            echo "<h2>" . $category['name'] . "</h2>";
            echo "<ul>";

            foreach ($products as $product) {
                echo "<li>" . $product['productname'] . "</li>";
            }

            echo "</ul>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

</body>

</html>