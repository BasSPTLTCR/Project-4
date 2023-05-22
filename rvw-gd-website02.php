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
            Hartelijk dank voor uw reactie
        </h2>

        <p>
            Onderstaand kunt u teruglezen wat u heeft ingezonden als reactie. U kunt dit bericht niet meer 
            wijzigen. 
        </p>
        <form action="index.php" method="post">
            <fieldset class="flexverticalcenter">
                <legend>Persoonlijke informatie</legend>
                <input type="text" name="username" readonly value=<?php echo $_POST["username"]; ?>>
                <input type="email" name="email" readonly value=<?php echo $_POST["email"]; ?> >
                <input type="text" name="telephone" readonly value=<?php echo $_POST["telephone"]; ?> >
            </fieldset>
            <fieldset>
                <legend>Uw mening</legend>
                <textarea name="opinion" rows="5" cols="90" readonly ><?php echo $_POST["opinion"]; ?></textarea>
            </fieldset>
            <button type="submit">Terug naar hoofdpagina</button>
        </form>
    </main>
</body>
</html>
