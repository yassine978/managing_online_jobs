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
    $sql = "SELECT oce.code_competence, oe.code_diplome, oe.nombre_annee_experience
    FROM offre_competance oce
    INNER JOIN offre_emploi oe ON oe.code_offre_emploi = oce.code_offre_emploi
    WHERE oe.code_offre_emploi = '$code_offre_emploi'";

    // Exécuter la requête
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérer les informations de l'offre d'emploi
        while($row = $result->fetch_assoc()) {
            $nb_experience2 = $row["nombre_annee_experience"];
            $competence2 = $row["code_competence"];
            $diplome2 = $row["code_diplome"];
        }
    } 
    // Requête SQL pour récupérer les informations du demandeur
    $sql = "SELECT dcv.nombre_annees_experience, c.code_competence, dp.code_diplome 
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
            $nb_experience = $row["nombre_annees_experience"];
            $competence = $row["code_competence"];
            $diplome = $row["code_diplome"];
        }
    }
// Calculer le score
$score = 0;
if($competence === $competence2){
    $score = $score + 5;
}
if($nb_experience2 <= $nb_experience){
    $score = $score + (2 * ($nb_experience - $nb_experience2));
}
if($diplome !== $diplome2){
    $score = 0;
}
// Retourner le score
return $score;
}
function trierTableau(&$tableau, $colonne) {
    if (empty($tableau)) {
        return; // nothing to sort
    }
    if (!array_key_exists($colonne, $tableau[0])) {
        return; // invalid column
    }
    $taille = count($tableau);
    for ($i = 0; $i < $taille; $i++) {
        for ($j = 0; $j < $taille - $i - 1; $j++) {
            if ($tableau[$j][$colonne] < $tableau[$j+1][$colonne]) {
                $temp = $tableau[$j];
                $tableau[$j] = $tableau[$j+1];
                $tableau[$j+1] = $temp;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Demandeur d'emploi</title>
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
                    <th>Cin</th>
                    <th>Nom et Prenom</th>
                    <th>Date de naissance</th>
                    <th>Numéro de téléphone</th>
                    <th>Nombre d’années d’expérience</th>
                    <th>Adresse</th>
                    <th>Diplome</th>
                    <th>Score</th>
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



        $sth = $dbco->prepare ("SELECT 
        demandeur_cv.*,
        competence.libelle_competence,
        diplome.libelle_diplome,
        universite.libelle_universite
        FROM 
        demandeur_cv
        INNER JOIN competence_demandeur ON demandeur_cv.CIN = competence_demandeur.CIN
        INNER JOIN competence ON competence_demandeur.code_competence = competence.code_competence
        INNER JOIN diplome_demandeur ON demandeur_cv.CIN = diplome_demandeur.CIN
        INNER JOIN diplome ON diplome_demandeur.code_diplome = diplome.code_diplome
        INNER JOIN universite ON demandeur_cv.code_universite = universite.code_universite");
        $sth->execute();
        
        /*Retourne un tableau associatif pour chaque entrée de notre table
         *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($_GET["code_offre_emploi"])){
                $code = $_GET["code_offre_emploi"];
        if (count($resultat)> 0)
        {
                for($i=0;$i<count($resultat);$i++)
                {
                    $c=calcul_score($code, $resultat[$i]["CIN"]);
                    trierTableau($resultat, $c);
                        //if($c>0) {
                    echo "<tr><td> " . $resultat[$i]["CIN"]."</td><td>" . $resultat[$i]["prenom"]." ".$resultat[$i]["nom"]."</td>
                    <td>". $resultat[$i]["date_naissance"]."</td><td>". $resultat[$i]["num_telephone"]."</td>
                    <td>". $resultat[$i]["nombre_annees_experience"]."</td><td>". $resultat[$i]["adresse"]."</td>
                    <td>".$resultat[$i]["libelle_diplome"]."</td><td>". $c;
                    //}
                }   
        }
    } 
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

    ?>
    </tbody>
        </table>
        <button onclick="window.location.href='his_en.php'">Main menu</button>
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