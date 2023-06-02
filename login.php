<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regristration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="loginBody">
    <?php
    include_once "./includes/nav.php";

    // Databaseconfiguratie
    $host = 'localhost';
    $dbname = 'befs';
    $user = 'root';
    $password = '';

    session_start();

    // Functie om in te loggen als klant
    function loginAlsKlant($email, $wachtwoord)
    {
        global $host, $dbname, $user, $password;

        // Controleer of er geen klant is ingelogd
        if (isset($_SESSION['klant_id'])) {
            echo "Er is al een klant ingelogd.";
            return;
        }

        try {
            // Maak een verbinding met de database met behulp van PDO
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

            // Stel de foutmodus in op uitzonderingen
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Zoek de klant-gegevens met de opgegeven e-mail
            $query = "SELECT * FROM client WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $klant = $stmt->fetch(PDO::FETCH_ASSOC);

            // Controleer of de klant bestaat en het wachtwoord overeenkomt
            if ($klant && password_verify($wachtwoord, $klant['password'])) {
                // Zet de SESSION-variabelen voor een ingelogde klant
                $_SESSION['klant_id'] = $klant['id'];
                $_SESSION['klant_email'] = $klant['email'];

                // Geef een melding dat het inloggen is geslaagd
                echo "Inloggen is gelukt!";

                // Keer terug naar de home-pagina met het menu van de klant actief
                header("Location: index.php");
                exit();
            } else {
                // Inloggen mislukt
                echo "Ongeldige e-mail of wachtwoord.";
            }
        } catch (PDOException $e) {
            die("Fout bij het verbinden met de database: " . $e->getMessage());
        }
    }

    // Controleer of het formulier is ingediend
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Haal de e-mail en het wachtwoord op uit het formulier
        $email = $_POST['email'];
        $wachtwoord = $_POST['wachtwoord'];

        // Roep de loginAlsKlant-functie aan
        loginAlsKlant($email, $wachtwoord);
    }
    ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="wachtwoord" placeholder="Password" required />
        <button type="submit" value="Inloggen">Sign in</button>
    </form>

</body>

</html>