<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>toevoegen Product</title>
</head>

<body>
    <?php
    include "./includes/nav.php";
    ?>
    <?php
    #1 verbinding database
    require './db-connection.php';

    #2 querydef
    try {
        $fullQuery = $conn->prepare("SELECT category.`name` AS catname FROM `category` ORDER BY `name` ASC;");
        $oneQuery = $conn->prepare("SELECT supplier.`company` AS supname FROM `supplier` ORDER BY `company` ASC");
    } catch (PDOExeption $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
    }
    #3 querydoen
    $fullQuery->execute();
    $oneQuery->execute();

    #4 checkresult
    if ($fullQuery->RowCount() > 0 && $oneQuery->RowCount() > 0) {
        $result = $fullQuery->FetchAll(PDO::FETCH_ASSOC);
        $result2 = $oneQuery->FetchAll(PDO::FETCH_ASSOC);
    ?>
        <h2>Geef de gegevens van het product op</h2>
        <form action="./chk-productadding.php" method="post">
            <label for="prodname">Product naam</label>
            <input type="text" name="prodname" required>
            <label for="prodprice">Product prijs</label>
            <input type="text" name="prodprice" required>
            <label for="prodcategorie">Product category</label>
            <select name="prodcategorie">
                <?php
                foreach ($result as $rij) {
                    echo "<option>" . $rij["catname"] . "</option>";
                }
                ?>
            </select>
            <label for="prodleverancier">Leverancier</label>
            <select name="prodleverancier">
                <?php
                foreach ($result2 as $rij2) {
                    echo "<option>" . $rij2["supname"] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="voegtoe" name="voegtoe">
        </form>
    <?php
    }
    ?>
</body>

</html>