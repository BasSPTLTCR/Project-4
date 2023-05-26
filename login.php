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
                // ... voeg andere gewenste SESSION-variabelen toe

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

    <div class="login-container">
        <form action="" class="form-login" method="POST">
            <ul class="login-nav">
                <li class="login-nav__item active">
                    <a href="./login.php">Sign In</a>
                </li>
                <li class="login-nav__item">
                    <a href="./signup.php">Sign Up</a>
                </li>
            </ul>
            <label for="login-input-email" class="login__label">
                Email
            </label>
            <input id="login-input-email" class="login__input" type="email" name="email" required />
            <label for="login-input-password" class="login__label">
                Password
            </label>
            <input id="login-input-password" class="login__input" type="password" name="wachtwoord" required />
            <label for="login-sign-up" class="login__label--checkbox">
                <input id="login-sign-up" type="checkbox" class="login__input--checkbox" />
                Keep me Signed in
            </label>
            <button class="login__submit" type="submit" value="Inloggen">Sign in</button>
        </form>
        <a href="#" class="login__forgot">Forgot Password?</a>
    </div>



</body>

</html>