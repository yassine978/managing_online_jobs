<!DOCTYPE html>
<html>
<head>
	<title>MAIN MENU</title>
	<!-- Lien vers votre fichier CSS -->
	<link rel="stylesheet" type="text/css" href="hisen.css">
</head>
<body>
<header>
  <div class="container">
    <h1>JOB4EVRY</h1>
    <nav>
      <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">A propos</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </div>
</header>

	<main>
		<!-- Tableau et boutons de votre page -->
		<table>
			<thead>
				<tr>
					<th>Titre</th>
					<th>Description</th>
					<th>Salaire proposé</th>
					<th>Diplôme</th>
					<th>Compétence</th>
					<th>Nombre d'années d'expérience</th>
				</tr>
			</thead>
			<tbody>
            <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "bureau_emploi";

    try{

        // Création de la  connexion
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    session_start();
    $code_r = $_SESSION['code_r'];
        $sth = $dbco->prepare ("SELECT DISTINCT E.*,O.*,D.*,OC.*,C.*
        FROM employeur_offre E ,offre_emploi O , diplome D,offre_competance OC,competence C
        where E.code_registre_commerce='$code_r' and E.code_offre_emploi=O.code_offre_emploi and E.code_offre_emploi!=0
        and D.code_diplome=O.code_diplome and OC.code_offre_emploi=O.code_offre_emploi and OC.code_competence=C.code_competence");
        $sth->execute();
        
        /*Retourne un tableau associatif pour chaque entrée de notre table
         *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);


        if (count($resultat)> 0)
        {
                for($i=0;$i<count($resultat);$i++)
                {
                    echo "<tr><td>" . $resultat[$i]["Titre"]."</td><td>" . $resultat[$i]["descript"]. "</td><td>" . $resultat[$i]["salaire_propose"]. "</td><td>" . $resultat[$i]["libelle_diplome"]. "</td><td>" . $resultat[$i]["libelle_competence"]. "</td><td>" . $resultat[$i]["nombre_annee_experience"]."</td>
                    <td><a href=\"menu_employeur.php?code_offre_emploi=".$resultat[$i]["code_offre_emploi"]."\">Les Demandes d'emploi</a></td>
                    <td><a href=\"delete.php?code_offre_emploi=".$resultat[$i]["code_offre_emploi"]."\" onclick=\"return confirm('Vous voulez vraiment supprimer cette offre')\">supprimer cette offre</a></td></tr>";
                }   
        }
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

    ?>
			</tbody>
		</table>
		<button onclick="window.location.href='can_ef.php'">Candidature effectuée</button>
		<button onclick="window.location.href='OE.php'">Ajouter une offre</button>
        <button type="submit" form="logout-form">Déconnexion</button>
        <form id="logout-form" method="post" action="logout.php">
            <input type="hidden" name="logout" value="true">
        </form>

	</main>

    <footer id="contact">
    <p>&copy; 2023 - JOB4EVRY</p>
    <div class="contact-info">
        <p>Contact us:</p>
        <a href="mailto:contact@job4evry.com">contact@job4evry.com</a>
        <a href="tel:555-555-5555">(555) 555-5555</a>
    </div>
    <div class="social-links">
        <a href="https://www.facebook.com/job4evry"><img src="facebook-icon.png" alt="Facebook"></a>
        <a href="https://www.twitter.com/job4evry"><img src="twitter-icon.png" alt="Twitter"></a>
        <a href="https://www.linkedin.com/company/job4evry"><img src="linkedin-icon.png" alt="LinkedIn"></a>
    </div>
</footer>

</body>
</html>
