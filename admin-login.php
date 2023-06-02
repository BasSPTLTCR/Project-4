<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="loginBody">
    <?php
    include_once "./includes/nav.html";

    // Databaseconfiguratie
    $host = 'localhost';
    $dbname = 'befs';
    $user = 'root';
    $password = '';

    session_start();

    // Functie om in te loggen als beheerder
    function loginAlsBeheerder($email, $wachtwoord)
    {
        global $host, $dbname, $user, $password;

        // Controleer of er niemand is ingelogd
        if (isset($_SESSION['beheerder_id'])) {
            echo "Er is al een beheerder ingelogd.";
            return;
        }

        try {
            // Maak een verbinding met de database met behulp van PDO
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

            // Stel de foutmodus in op uitzonderingen
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Zoek de beheerder-gegevens met de opgegeven e-mail
            $query = "SELECT * FROM client WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $beheerder = $stmt->fetch(PDO::FETCH_ASSOC);

            // Controleer of de beheerder bestaat en het wachtwoord overeenkomt
            if ($beheerder && password_verify($wachtwoord, $beheerder['password'])) {
                // Zet de SESSION-variabelen voor een ingelogde beheerder
                $_SESSION['beheerder_id'] = $beheerder['id'];
                $_SESSION['beheerder_email'] = $beheerder['email'];
                
                // Geef een melding dat het inloggen is geslaagd
                echo "Inloggen is gelukt!";

                // Keer terug naar de home-pagina met het menu van de beheerder actief
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

        // Roep de loginAlsBeheerer-functie aan
        loginAlsBeheerder($email, $wachtwoord);
    }
    ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="wachtwoord" placeholder="Password" required />
        <button type="submit" value="Inloggen">Sign in</button>
    </form>

</body>

</html>