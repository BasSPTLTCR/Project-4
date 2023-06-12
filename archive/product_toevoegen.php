<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B01-02 Product Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require 'db-connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productname = $_POST["productname"];
        $search = array(",");
        $replace = array(".");
        $arr = $_POST["price"];
        $priceFilter = (str_replace($search,$replace,$arr));
        $categoryid = $_POST["categoryid"];
        $supplierid = $_POST["supplierid"];

        // Hier kun je de code toevoegen om de verbinding met de database te maken en de query uit te voeren

        $sql = "INSERT INTO product (productname, price, categoryid, supplierid)
    VALUES (:productname, :priceFilter, :categoryid, :supplierid)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':productname', $productname);
        $stmt->bindParam(':price', $priceFilter);
        $stmt->bindParam(':categoryid', $categoryid);
        $stmt->bindParam(':supplierid', $supplierid);

        try {
            $stmt->execute();
            echo "Product succesvol toegevoegd.";
        } catch (PDOException $e) {
            echo "Fout bij het toevoegen van het Product: " . $e->getMessage();
        }
    }
    ?>

    <form method="post">
        <label>Productnaam:</label>
        <input type="text" name="productname" required><br>

        <label>Prijs:</label>
        <input type="text" name="price" required><br>

        <label>Categorynummer:</label>
        <input type="text" name="categoryid" required><br>

        <label>Leveranciernummer:</label>
        <input type="text" name="supplierid" required><br>

        <input type="submit" value="Product toevoegen">
    </form>

</body>

</html>