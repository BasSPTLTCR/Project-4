
<nav class="navmain">
    <ul>
        <li class="navlist">
            <a href="./index.php" class="dropbtn">Home</a>
            <div class="dropdown">
                <button class="dropbtn">Over ons</button>
                <div class="dropdown-content">
                    <a href="#">Eco vriendelijk</a>
                    <a href="#">Levering en retour</a>
                    <a href="#">Medewerkers</a>
                    <a href="#">Doelstelling</a>
                    <a href="#">Geschiedenis</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Informatie</button>
                <div class="dropdown-content">
                    <a href="#">Klanten</a>
                    <a href="#">Categorieën</a>
                    <a href="#">Leveranciers</a>
                    <a href="./show-products.php">Producten</a>
                    <a href="#">Aankoop</a>
                    <a href="#">Landen</a>
                    <a href="#">Aankoopdet.-prod</a>
                    <a href="#">Product lev.</a>
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
                        <a href="#">Lev per land</a>
                        <a href="#">Prod per cat</a>
                        <a href="#">Aankoop per klant</a>
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
                    <a href="#">Beheeerrechten</a>
                </div>
            </div>
            <?php
                if (!isset($_SESSION['klant_id'])) {
                    echo "<div class='profileContainer'>
                    <a class='login' href='./login.php'>Sign up</a>
                    <img class='profile' src='./images/profile.png' alt=''>
                    </div>";
                } else {
                    echo "<div class='profileContainer'>
                    <a class='login' href='#'>" . $_SESSION['klant_naam'] . "</a>
                    <img class='profile' src='./images/profile.png' alt=''>
                    </div>";
                }
            
            ?>
        </li>

    </ul>
</nav>