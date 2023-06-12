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
          // checks if user is signed in
        if (!isset($_SESSION["klant_id"])) {
            header_remove();
            header("Location: index.php ");
            exit();
        }
     require_once("db-connection.php");
        include "./includes/nav.php";
        ?>
    </header>
<main>
<form action="password-change.php" method="post"
>
<h3>verander wachtwoord</h3>
    <div>
      <label for="pass">oud wachtwooord:</label>
      <input type="password" id="oldpass" name="oldpass" required />
    </div>
    <div>
      <label for="pass">nieuw wachtwoord:</label>
      <input type="password" id="n-pass" name="n-pass" required />
    </div>
    <div>
      <label for="pass">herhaal wachtwoord:</label>
      <input type="password" id="n-pass" name="n-c-pass" required />
    </div>
    <input type="submit" name="submit" id="submit" value="verander wachtwoord">
</form>
<?php 

?>
</main>
    </body>