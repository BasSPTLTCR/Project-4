<!DOCTYPE html>
<html lang="nl"> 
<head>
	 <meta charset="UTF-8">
	 <title>Bread Company</title>
	 <link rel="stylesheet" type="text/css" href="company.css">  
</head>

<body>
	<header>
		<h1>Welkom bij de Bread Company</h1>
		<!-- hieronder wordt het menu opgehaald. -->
		<?php
			session_start(); 
			include "nav.html";
		?>
	</header>
 
	<!-- op de home pagina wat enthousiaste tekst over het bedrijf en de producten -->
 	<main class="flexverticalcenter">
        <h2>
            Compliment over de website
        </h2>

        <p>
            U heeft aangegeven een compliment te willen geven over onze website. Uiteraard zijn wij daar erg 
            blij mee. Wilt u onderstaand wat gegevens invullen en precies vertellen wat u goed vindt aan de 
            website?
        </p>
        <form action="rvw-gd-website02.php" method="post">
            <fieldset class="flexverticalcenter">
                <legend>Persoonlijke informatie</legend>
                <input type="text" name="username" required placeholder="Uw naam invullen a.u.b.">
                <input type="email" name="email" required placeholder="Uw email adres graag">
                <input type="text" name="telephone" required placeholder="uw telefoonnummer a.u.b.">
            </fieldset>
            <fieldset>
                <legend>Uw mening</legend>
                <textarea name="opinion" rows="5" cols="90" required placeholder="Uw mening over de website"></textarea>
            </fieldset>
            <button type="submit">Stuur in</button>
        </form>
    </main>
</body>
</html>
