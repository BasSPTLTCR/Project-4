<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header>
        <?php
        session_start();
// checks if user is signed in as an Admin, if not, it will redirect you to the login page
        if (!isset($_SESSION["klant_id"])) {
            header_remove();
            header("Location: index.php ");
            exit();
        }

        require_once("db-connection.php");
        include "./includes/nav.html";
        ?>
    </header>
<main>
        <h2>Weet u zeker dat u uw wachtwoord wilt veranderen?</h2>
        <form action="" method="post">

            <?php
            // hidden inputs used to store values from the last page :)
            echo '<input type="hidden" name="n-pass" value="' . $_POST["n-pass"] . '">';
            echo '<input type="hidden" name="n-c-pass" value="' . $_POST["n-c-pass"] . '">';
            echo '<input type="hidden" name="oldpass" value="' . $_POST["oldpass"] . '">';
            ?>
            <input type="submit" name="confirm" id="confirm" value="Ja">
            <input type="submit" name="denie" id="dennie" value="nee">
        </form>

        <?php
        // function to santize the inputs
        function sanitizeInput($value)
        {
            // Sanitize user input
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            return $value;
        }

        // main function to change passes
        function changepass($conn)
        {
            // variable that store the vallues in the hidden inputs
            $userid = $_SESSION["klant_id"];
            $oldpass = $_POST["oldpass"];
            // variable to store the values in the hidden inputs and santizes them at the same time
            $filteredPass = sanitizeInput($_POST["n-pass"]);
            $filteredCPass = sanitizeInput($_POST["n-c-pass"]);
            // making the statement
            try {
                $useroldpass = $conn->prepare("SELECT PASSWORD FROM `client` WHERE id = :id");
                $useroldpass->execute([":id" => $userid]);
                $userp = $useroldpass->fetchColumn();
            } catch (PDOException $e) {
                die("FOUT IN SQL QUERY " . $e->getMessage());
            }
            //  checks if the passsword is right
            if (password_verify($oldpass, $userp)) {
                // checks if the new password is equal to the password check
                if ($filteredPass == $filteredCPass) {
                    $hashedPassword = password_hash($filteredPass, PASSWORD_BCRYPT);
                    // making a statemnt to change the password
                    try {
                        $newpass = $conn->prepare("UPDATE client SET password = :pass WHERE id = :id");
                        $newpass->execute([
                            ":pass" => $hashedPassword,
                            ":id" => $userid,
                        ]);
                    } catch (PDOException $e) {
                        die("FOUT IN SQL QUERY " . $e->getMessage());
                    }
                //    logging out and redirects to login page
                    unset($_SESSION["sklant_id"]);
                    $message = "Successfully changed password";
                    $url = "Login.php" . urlencode($message);
                    echo '<script>window.location.replace("Login.php")</script>';
                    exit;
                    // if the new password isnt right with the new pass check it ill redirect back
                } else {
                    echo "nieuwe wachtwoorden zijn niet gelijk ";
                    echo '<script>setTimeout(function() { window.location.replace("password.php") }, 2000)</script>';
                }
                // if the password it self is wrong it will redirect you back
            } else {
                echo 'verkeerd wachtwoord';
                echo '<script>setTimeout(function() { window.location.replace("password.php") }, 2000)</script>';
            }
        }
        // iif confirm is pressed it will activate the change pass  functionn
        if (isset($_POST["confirm"])) {
            changepass($conn);
        }
        // if denie is press it will redirect you to the index.php page
        if (isset($_POST["denie"])) {
            echo '<script>window.location.replace("index.php")</script>';
        }
        ?>
</main>
</body>
</html>