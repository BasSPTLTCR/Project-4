<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product wijzigen</title>
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <?php
    include_once "./includes/nav.php";
    require 'db-connection.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Update each row individually
            foreach ($_POST['ID'] as $index => $id) {
                $company = $_POST['company'][$index];
                $address = $_POST['address'][$index];
                $streetnr = $_POST['streetnr'][$index];
                $zipcode = $_POST['zipcode'][$index];
                $city = $_POST['city'][$index];
                $state = $_POST['state'][$index];
                $countryid = $_POST['countryid'][$index];
                $telephone = $_POST['telephone'][$index];
                $website = $_POST['website'][$index];
                $stmt = $pdo->prepare('UPDATE supplier SET company = ?, address = ?, streetnr = ?, zipcode = ?, city = ?, state = ?, countryid = ?, telephone = ?, website = ? WHERE ID = ?');
                $stmt->execute([$company, $address, $streetnr, $zipcode, $city, $state, $countryid, $telephone, $website, $id]);
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT * FROM supplier');
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the table with editable fields
        echo "<form method='POST' onsubmit='return confirmSubmission();'>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Company</th><th>Address</th><th>Streetnr</th><th>Zipcode</th><th>City</th><th>State</th><th>Country ID</th><th>Phone number</th><th>Website</th></tr>";

        foreach ($tableData as $row) {
            echo "<tr>";
            echo "<td><input type='hidden' name='ID[]' value='" . $row['ID'] . "'>" . $row['ID'] . "</td>";
            echo "<td><input type='text' name='company[]' value='" . $row['company'] . "'></td>";
            echo "<td><input type='text' name='address[]' value='" . $row['address'] . "'></td>";
            echo "<td><input type='text' name='streetnr[]' value='" . $row['streetnr'] . "'></td>";
            echo "<td><input type='text' name='zipcode[]' value='" . $row['zipcode'] . "'></td>";
            echo "<td><input type='text' name='city[]' value='" . $row['city'] . "'></td>";
            echo "<td><input type='text' name='state[]' value='" . $row['state'] . "'></td>";
            echo "<td><input type='text' name='countryid[]' value='" . $row['countryid'] . "'></td>";
            echo "<td><input type='text' name='telephone[]' value='" . $row['telephone'] . "'></td>";
            echo "<td><input type='text' name='website[]' value='" . $row['website'] . "'></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<button type='submit'>Save Changes</button>";
        echo "</form>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

    <script>
        function confirmSubmission() {
            return confirm("Are you sure you want to save the changes?");
        }
    </script>




</body>

</html>