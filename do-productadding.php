<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Product toevoegen</title>
</head>

<body>
<?php
    include "./includes/nav.php";
    ?>
    <?php
    if (isset($_POST["annul"])) {
        echo "<h2>Niet toevoegen</h2>";
        header("Refresh:3; url=frm-productadding.php");
        die;
    }
    if (!isset($_POST["confirm"])) {
        echo "<h2>Niet juist hier gekomen</h2>";
        header("Refresh:3; url=frm-productadding.php");
        die;
    }
    if (!isset($_POST["prodname"]) || !isset($_POST["prodprice"]) || !isset($_POST["prodcategorie"]) || !isset($_POST["prodleverancier"])) {
        echo "<h2>gegevens verloren, contact beheer</h2>";
        header("Refresh:3; url=frm-productadding.php");
        die;
    }
    require './db-connection.php';
    $productcategoriename = $_POST["prodcategorie"];
    try {
        $productpcategory = $conn->prepare("SELECT id AS category_id FROM category WHERE name = :productcategoriename");
        $productpcategory->bindValue(':productcategoriename', $productcategoriename);
    } catch (PDOExeption $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
    }
    #3 querydoen
    $productpcategory->execute();

    #4 checkresult
    if ($productpcategory->RowCount() > 0) {
        $result = $productpcategory->FetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $rij) {
            $prodcategoryid = $rij["category_id"];
        }
    }
    $productsuppliername = $_POST["prodleverancier"];
    try {
        $productsupplier = $conn->prepare("SELECT id AS supplier_id FROM supplier WHERE company = :productleveranciername");
        $productsupplier->bindValue(':productleveranciername', $productsuppliername);
    } catch (PDOExeption $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
    }
    #3 querydoen
    $productsupplier->execute();

    #4 checkresult
    if ($productsupplier->RowCount() > 0) {
        $result = $productsupplier->FetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $rij) {
            $prodsupplierid = $rij["supplier_id"];
        }
    }
    #maak hieronder de insert qry
    $productname = $_POST["prodname"];
    $productprice = $_POST["prodprice"];
    echo $productname;
    echo $productprice;
    $insquery = $conn->prepare("INSERT INTO product (id, productname, price, supplierid, categoryid) VALUES (NULL, :prodname, :prodprice, :prodsupplierid, :prodcategorieid)");
    $insquery->bindValue("prodname", $productname);
    $insquery->bindValue("prodprice", $productprice);
    $insquery->bindValue("prodsupplierid", $prodsupplierid);
    $insquery->bindValue("prodcategorieid", $prodcategoryid);
    $insquery->execute();
    ?>
</body>

</html>