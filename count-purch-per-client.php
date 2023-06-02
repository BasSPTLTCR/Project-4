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
 
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle klanten met aantal aankopen per klant</h2>
    <?php
        // Verbinding maken met de database 
        require_once("dbconnect.php");

        // Alle klanten ophalen met het aantal bijbehorende aankopen 
        $query = $db->prepare("SELECT client.id, 
                                      first_name, 
                                      last_name, 
                                      city, 
                                      country, COUNT(purchase.ID) AS totpurchases 
                                FROM client
                                LEFT JOIN purchase ON client.id = purchase.clientid
                                GROUP BY client.id
                                ORDER BY totpurchases DESC;");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0)
        {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>Klant-nr</th>
              <th>Voornaam</th>
              <th>Achternaam</th>
              <th>Stad</th>
              <th>Land</th>
              <th>Aantal aankopen</th>
              </thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo "<tr>";
            echo "<td>".$data["id"]."</td>";
            echo "<td>".$data["first_name"]."</td>";
            echo "<td>".$data["last_name"]."</td>";
            echo "<td>".$data["city"]."</td>";
            echo "<td>".$data["country"]."</td>";
            echo "<td class='centercell'>".$data["totpurchases"]."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    ?>
    </main>
</body>
</html>