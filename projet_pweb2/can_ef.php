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
                    <th>titre d'offre</th>
                    <th>etat condidature</th>
                    <th>date_condidature</th>
                    <th>nom</th>
                    <th>prenom</th>
                    <th>date de naissance</th>
                    <th>etat civil</th>
                    <th>adresse</th>
                    <th>numero telephone</th>
                    <th>annee d'experience</th>
                    <th>competence</th>
                    <th>diplome</th>
                    <th>universite</th>
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
        $sth = $dbco->prepare ("SELECT E.*,O.*,c.*,D.*,U.*,DD.*,DI.* ,CD.*,CO.*
        FROM employeur_offre E ,offre_emploi O,condidature C ,demandeur_cv D,universite U,diplome_demandeur DD,diplome DI,competence_demandeur CD , competence CO
        where E.code_registre_commerce='$code_r' and E.code_offre_emploi=O.code_offre_emploi and E.code_offre_emploi!=0 and O.code_offre_emploi = C.code_offre_emploi
        and C.cin=D.cin and D.code_universite=U.code_universite and DD.cin=D.cin and DD.code_diplome=DI.code_diplome and CD.cin=D.cin and CD.code_competence=CO.code_competence");
        $sth->execute();
        
        /*Retourne un tableau associatif pour chaque entrée de notre table
         *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);


        if (count($resultat)> 0)
        {
                for($i=0;$i<count($resultat);$i++)
                {
                    echo "<tr><td>".$resultat[$i]["Titre"]."</td><td> " . $resultat[$i]["etat_condidature"]."</td><td>" . $resultat[$i]["date_condidature"]. "</td><td>" . $resultat[$i]["nom"]. "</td><td>" . $resultat[$i]["prenom"]. "</td>
                    <td>".$resultat[$i]["date_naissance"]."</td><td>".$resultat[$i]["etat_civil"]."</td><td>".$resultat[$i]["adresse"]."</td><td>".$resultat[$i]["num_telephone"]."</td><td>".$resultat[$i]["nombre_annees_experience"]."</td>
                    <td>" . $resultat[$i]["libelle_competence"]."</td><td> " . $resultat[$i]["libelle_diplome"]."</td><td> " . $resultat[$i]["libelle_universite"]."</td>
                    <td><a href=\"accepter.php?code_offre_emploi=".$resultat[$i]["code_offre_emploi"]."&CIN=".$resultat[$i]["CIN"]."\">accepter</a></td>
                    <td><a href=\"refuser.php?code_offre_emploi=".$resultat[$i]["code_offre_emploi"]."&CIN=".$resultat[$i]["CIN"]."\">refuser</a></td>
                    </tr>" ;
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