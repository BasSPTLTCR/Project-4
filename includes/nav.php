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
            <?php
            error_reporting(0);  // Disable error reporting
            ini_set('display_errors', 0);  // Do not display errors
            session_start();
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {

            ?>
                <div class="dropdown">
                    <button class="dropbtn">Admin</button>
                    <div class="dropdown-content dropdown-content1">
                        <div class="navDropdownContainer">
                            <div class="navDropdown">
                                <p>Toevoegen</p>
                                <a href="./leverancier_toevoegen.php">Leverancier toevoegen</a>
                                <a href="./frm-productadding.php">Product toevoegen</a>
                                <a href="./categorie_toevoegen.php">Categorie toevoegen</a>
                                <a href="./landen_toevoegen.php">Land toevoegen</a>
                                <a href="./beheerder_toevoegen.php">Beheerder toevoegen</a>
                            </div>
                            <div class="navDropdown">
                                <p>Wijzigen</p>
                                <a href="./product_wijzigen.php">Product wijzigen</a>
                                <a href="./product_actief.php">Product activiteit wijzigen</a>
                                <a href="./edit_supplier.php">Leverancier wijzigen</a>
                                <a href="./categorie_wijzigen.php">Categorie wijzigen</a>
                                <a href="./bestelling_wijzigen.php">Bestellingen wijzigen</a>
                            </div>
                            <div class="navDropdown">
                                <p>Verwijderen</p>
                                <a href="./product_verwijderen.php">Product verwijderen</a>
                                <a href="./show_delete_country.php">Land verwijderen</a>
                                <a href="./klant_verwijderen.php">Klant verwijderen</a>
                                <a href="./leverancier_verwijderen.php">Leverancier verwijderen</a>
                                <a href="./beheer_verwijderen.php">Beheer verwijderen</a>
                                <a href="./categorie_verwijderen.php">Categorie verwijderen</a>
                            </div>
                            <div class="navDropdown">
                                <p>Overzichten</p>
                                <a href="./klanten.php">Klanten</a>
                                <a href="./old-new-password.php">Change password</a>
                                <a href="#">Lev per land</a>
                                <a href="./show_catperproduct.php">Prod per cat</a>
                                <a href="./show_aankoopperklant.php">Aankoop per klant</a>
                                <a href="./show_orders.php">Bestellingen</a>
                                <a href="#">Regels per aankoop</a>
                                <a href="#">Aankoop per prod</a>
                                <a href="#">Prod prijs -lev</a>
                                <a href="#">Prod prijs - cat</a>
                                <a href="#">Tot prijs - aankoop</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            if (isset($_SESSION["klant_id"]) || isset($_SESSION["klant_email"])) {
            ?>
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
            <?php
            }
            ?>
            <div class="profileContainer">
                <?php
                if (!isset($_SESSION["klant_id"]) && !isset($_SESSION["klant_email"])) {
                ?>
                    <a class="login" href="./login.php">Sign In</a>
                    <a class="login" href="./signup.php">Sign up</a>
                <?php
                } else {
                ?>
                    <p class="login"><?php echo $_SESSION["klant_fname"] . " " . $_SESSION["klant_lname"]; ?></p>
                    <a class="login" href="./logout.php">Log out</a>
                <?php
                }
                ?>
                <img class="profile" src="./images/profile.png" alt="">
            </div>
        </li>
    </ul>
</nav>