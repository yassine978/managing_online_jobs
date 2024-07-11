<?php
function calcul_score($code_offre_emploi, $CIN){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bureau_emploi";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Requête SQL pour récupérer les informations de l'offre d'emploi
    $sql = "SELECT oce.code_competence, oe.code_diplome, oe.salaire_propose
    FROM offre_competance oce
    INNER JOIN offre_emploi oe ON oe.code_offre_emploi = oce.code_offre_emploi
    WHERE oe.code_offre_emploi = '$code_offre_emploi'";

    // Exécuter la requête
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérer les informations de l'offre d'emploi
        while($row = $result->fetch_assoc()) {
            $sal = $row["salaire_propose"];
            $competence2 = $row["code_competence"];
            $diplome2 = $row["code_diplome"];
        }
    } 
    // Requête SQL pour récupérer les informations du demandeur
    $sql = "SELECT  c.code_competence, dp.code_diplome 
            FROM demandeur_cv dcv 
            LEFT JOIN competence_demandeur cd ON dcv.CIN = cd.CIN 
            LEFT JOIN competence c ON cd.code_competence = c.code_competence 
            LEFT JOIN diplome_demandeur dd ON dcv.CIN = dd.CIN 
            LEFT JOIN diplome dp ON dd.code_diplome = dp.code_diplome 
            WHERE dcv.CIN = '$CIN'";

    // Exécuter la requête
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérer les informations du demandeur
        while($row = $result->fetch_assoc()) {
            $competence = $row["code_competence"];
            $diplome = $row["code_diplome"];
        }
    }
// Calculer le score
$score = 0;
if($competence === $competence2){
    $score = $score + 5;
}

$score= $score + $sal/100;
if($diplome !== $diplome2){
    $score = 0;
}
// Retourner le score
return $score;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU</title>
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
<table  cellspacing="0">
    <thead>
                <tr>
                    <th>nom entreprise</th>
                    <th>titre</th>
                    <th>diplome</th>
                    <th>description</th>
                    <th>salire propsé</th>
                    <th>competence</th>
                    <th>score</th>
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



        $sth = $dbco->prepare ("SELECT E.nom_entreprise, O.*, D.libelle_diplome, C.libelle_competence
        FROM offre_emploi O
        LEFT JOIN employeur_offre EO ON O.code_offre_emploi = EO.code_offre_emploi 
        LEFT JOIN employeur E ON EO.code_registre_commerce = E.code_registre_commerce
        LEFT JOIN diplome D ON O.code_diplome = D.code_diplome
        LEFT JOIN offre_competance OC ON O.code_offre_emploi = OC.code_offre_emploi
        LEFT JOIN competence C ON C.code_competence = OC.code_competence");
        $sth->execute();
        
        /*Retourne un tableau associatif pour chaque entrée de notre table
         *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $cin = $_SESSION['cin_s'];

        if (count($resultat)> 0)
        {
                for($i=1;$i<count($resultat);$i++)
                {
                    $c=calcul_score($resultat[$i]["code_offre_emploi"], $cin);
                    echo "<tr><td> " . $resultat[$i]["nom_entreprise"]."</td><td>" . $resultat[$i]["Titre"]. "</td><td>" . $resultat[$i]["libelle_diplome"]. "</td><td>" . $resultat[$i]["descript"]."</td><td>" . $resultat[$i]["salaire_propose"]."</td><td>" . $resultat[$i]["libelle_competence"]."</td><td>" .$c."</td>
                    <td><a href=\"postule_em.php?code_offre_emploi=".$resultat[$i]["code_offre_emploi"]."\" onclick=\"return confirm('Vous voulez vraiment postuler pour cette offre')\">Postuler</a></td></tr>" ;
                } 
        }
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

    ?>
    </tbody>
        </table>
        <button onclick="window.location.href='his_em.php'">Historique</button>
        <button type="submit" form="logout-form">Déconnexion</button>
        <form id="logout-form" method="post" action="logout.php">
            <input type="hidden" name="logout" value="true">
        </form>
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