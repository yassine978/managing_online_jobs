<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bureau_emploi";

try{

  // Création de la  connexion
  $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);          

  //Après clic sur le bouton "Envoyer" envoie de données par post
    if(count($_POST)>2) {
    //récupération des données envoyées
    $titre = $_POST["title"];//la valeur entre le crocher est le name de champ dans le form
    $description =  $_POST["description"];
    $num_exp =  $_POST["num_exp"];
    $sal =  $_POST["sal"];
    $diplome =  $_POST["diplome"];
    $competence =  $_POST["competence"];
    
    $sth = $dbco->prepare("INSERT INTO offre_emploi (Titre, descript, code_diplome, nombre_annee_experience, salaire_propose)   
    VALUES (:titre, :descrpt, :diplome, :num_exp, :sal)");
    $sth->execute(array(
        ':titre' => $titre,
        ':descrpt' => $description,
        ':num_exp' => $num_exp,
        ':sal' => $sal,
        ':diplome' => $diplome,
    ));

     //on remplace  les valeurs dans notre requête SQL par nos marqueurs nommés
    $code_offre_emploi = $dbco->lastInsertId();
     $sql1 = "SELECT * FROM offre_emploi WHERE code_offre_emploi = '$code_offre_emploi'";
     // Exécuter la requête
    $result = $dbco->query($sql1);
    if ($result->rowCount() > 0) {
        // Afficher les informations du demandeur
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $code = $row["code_offre_emploi"];
        }
        
    }

    $sth1 = $dbco->prepare("INSERT INTO offre_competance (code_offre_emploi,code_competence)
    VALUES (:code,:competence)");

     //on remplace  les valeurs dans notre requête SQL par nos marqueurs nommés
     $sth1->execute(array(
        ':competence' => $competence,
        ':code' => $code,
    ));
    // Start the session
session_start();
$_SESSION['code'] = $code;
// Retrieve the user's primary key from the session
$code_r = $_SESSION['code_r'];
$sth = $dbco->prepare("SELECT COUNT(*) FROM employeur_offre WHERE code_registre_commerce = :code_r and code_offre_emploi=0");
            $sth->execute(array(':code_r' => $code_r));
            $resultat = $sth->fetchColumn();
            if ($resultat > 0) {
                $sth2 = $dbco->prepare("UPDATE employeur_offre SET code_registre_commerce=:code_r, code_offre_emploi=:code WHERE code_registre_commerce = :code_r and code_offre_emploi=0");
                $sth2->bindParam(':code_r', $code_r);
                $sth2->bindParam(':code', $code);
            
                if ($sth2->execute() === FALSE) {
                    echo "Erreur lors de la mise à jour : " . $sth2->errorInfo()[2];
                }
            }
            else{
                $sth3 = $dbco->prepare("INSERT INTO employeur_offre (code_registre_commerce, code_offre_emploi)
                VALUES (:code_r,:code)");
                $sth3->bindParam(':code_r', $code_r);
                $sth3->bindParam(':code', $code);
            }
    $message= "L offre a été ajouté  avec succès";
    }
}
catch(PDOException $e){
                echo "Erreur : " . $e->getMessage();
     }

//les autres pages peuvent envoyer un message dans L’URL. On le  récupère ici pour l'afficher dans l’élément "div.message"
if(isset($_GET["message"])){
    $message=$_GET["message"];
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OFFRE</title>
        <link rel="stylesheet" href="css_ins.css">
        
    </head>
    <body>
        <h1>Job Offer</h1>
        <form method="post" action="OE.php" id="O">
            <div class="form-group">
                <label for="title">Offer Title :</label>
                <input type="text" id="title" name="title" required placeholder="Offer Title">
            </div>
            <div class="form-group">
                <label for="description">Offer Description:</label>
                <textarea name="description" id="description" cols="67" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="num_exp">nombre d’années d’expérience :</label>
                <input type="number" id="num_exp" name="num_exp" >
            </div>
            <div class="form-group">
                <label for="sal">Proposed salary :</label>
                <input type="number" id="sal" name="sal" >
            </div>
            <div class="form-group">
                <label for="diplome">Diplome:</label>
                <select id="diplome" name="diplome" required>
                    <option value="1">LNBI</option>
                    <option value="2">LNSG</option>
                    <option value="3">LNSE</option> 
                    <option value="4">LNSI</option> 
                    <option value="5">LNBIS</option> 
                </select>
            </div>
            <div class="form-group">
                <label for="competence">Competence:</label>
                <select id="competence" name="competence" required>
                    <option value="1">communication</option>
                    <option value="2">Résolution de problèmes</option>
                    <option value="3">Leadership</option>
                    <option value="4">Travail d'equipe</option>
                    <option value="5">organisation et planification</option>
                </select>
            </div>
            <button type="submit" id="register-button">Register</button>
        </form>
        <script>
    document.getElementById("register-button").addEventListener("click", function(event) {
    event.preventDefault(); // prevent the default form submission
    
    // submit the form using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "OE.php");
    xhr.onload = function() {
      if (xhr.status === 200) {
        // PHP script executed successfully, redirect to the new page
        window.location.href = "his_en.php";
      }
    };
    xhr.send(new FormData(document.getElementById("O")));
  });
</script>
    </body>
</html>
