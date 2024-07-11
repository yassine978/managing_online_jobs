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
                    <th>entreprise</th>
                    <th>titre</th>
                    <th>description</th>
                    <th>salire propsé</th>
                    <th>etat</th>
                    <th>date</th>
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
    $cin = $_SESSION['cin_s'];
        $sth = $dbco->prepare ("SELECT C.*,O.*,EO.*,E.nom_entreprise
        FROM condidature C ,offre_emploi O,employeur_offre EO ,employeur E
        where C.cin='$cin' and C.code_offre_emploi=O.code_offre_emploi and O.code_offre_emploi=EO.code_offre_emploi and EO.code_registre_commerce=E.code_registre_commerce");
        $sth->execute();
        
        /*Retourne un tableau associatif pour chaque entrée de notre table
         *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);


        if (count($resultat)> 0)
        {
                for($i=0;$i<count($resultat);$i++)
                {
                    echo "<tr><td> " . $resultat[$i]["nom_entreprise"]."</td><td> " . $resultat[$i]["Titre"]."</td><td>" . $resultat[$i]["descript"]. "</td><td>" . $resultat[$i]["salaire_propose"]. "</td><td>" . $resultat[$i]["etat_condidature"]."</td><td>" . $resultat[$i]["date_condidature"]."</td></tr>" ;
                }   
        }
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

    ?>
    </tbody>
        </table>
        <button onclick="window.location.href='menu_em.php'">Main menu</button>
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