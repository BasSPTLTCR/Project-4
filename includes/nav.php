
<nav class="navmain">
    <ul>
        <li class="navlist">
            <a href="./index.php" class="dropbtn">Home</a>
            <div class="dropdown">
                <button class="dropbtn">Over ons</button>
                <div class="dropdown-content">
                    <a href="./eco_vriendelijkheid.php">Eco vriendelijk</a>
                    <a href="./levering_retour.php">Levering en retour</a>
                    <a href="#">Medewerkers</a>
                    <a href="#">Doelstelling</a>
                    <a href="#">Geschiedenis</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Informatie</button>
                <div class="dropdown-content">
                    <a href="#">Klanten</a>
                    <a href="./show_categorien.php">Categorieën</a>
                    <a href="./show_leveranciers.php">Leveranciers</a>
                    <a href="./show-products.php">Producten</a>
                    <a href="#">Aankoop</a>
                    <a href="./show_country.php">Landen</a>
                    <a href="#">Aankoopdet.-prod</a>
                    <a href="./show_catperproduct.php">Product lev.</a>
                    <a href="#">Aankoopdet.-prod</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Admin</button>
                <div class="dropdown-content dropdown-content1">
                    <div>
                        <a href="#">Klant toevoegen</a>
                        <a href="./leverancier_toevoegen.php">Leverancier toevoegen</a>
                        <a href="./frm-productadding.php">Product toevoegen</a>
                        <a href="./categorie_toevoegen.php">Categorie toevoegen</a>
                        <a href="./landen_toevoegen.php">Land toevoegen</a>
                        <a href="./beheerder_toevoegen.php">Beheerder toevoegen</a>

                    </div>
                    <div>
                        <a href="./product_wijzigen.php">Product wijzigen</a>
                        <a href="./categorie_wijzigen.php">Categorie wijzigen</a>
                        <a href="./leverancier_verwijderen.php">Leverancier verwijderen</a>
                        <a href="#">Lev per land</a>
                        <a href="./show_catperproduct.php">Prod per cat</a>
                        <a href="./show_aankoopperklant.php">Aankoop per klant</a>
                        <a href="#">Regels per aankoop</a>
                        <a href="#">Aankoop per prod</a>
                        <a href="#">Prod prijs -lev</a>
                        <a href="#">Prod prijs - cat</a>
                        <a href="#">Tot prijs - aankoop</a>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Feedback</button>
                <div class="dropdown-content">
                    <a href="#">Klacht product</a>
                    <a href="#">Compliment site</a>
                    <a href="#">Klacht site</a>
                    <a href="#">Klacht medewerker</a>
                    <a href="#">Compliment medewerker</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Muteer</button>
                <div class="dropdown-content">
                    <a href="./prodmuteer.php">Product</a>
                    <a href="./categorie_verwijder.php">Categorie Verwijderen</a>
                    <a href="./beheer_rechten.php">Beheeerrechten</a>
                </div>
            </div>
            <div class="profileContainer">
                <?php
                error_reporting(0);  // Disable error reporting
                ini_set('display_errors', 0);  // Do not display errors
                session_start();
                if (!isset($_SESSION["klant_id"]) && !isset($_SESSION["klant_email"])) {
                    echo '<a class="login" href="./login.php">Sign In</a>';

                    echo '<a class="login" href="./signup.php">Sign up</a>';
                } else {
                    echo '<p class="login">' . $_SESSION["klant_fname"] . "     " . $_SESSION["klant_lname"] . '</p>';
                    echo '<a class="login" href="./logout.php">Log out</a>';
                }

                ?>
                <img class="profile" src="./images/profile.png" alt="">

            </div>
        </li>

    </ul>
</nav>