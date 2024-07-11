<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CV</title>
        <link rel="stylesheet" href="css_ins.css">
        <script>
        function validateForm() {
        var num = document.getElementById("num").value;
        if (num >= 100000000) {
            alert("il y'a un erreur dans le numero telephone.");
            return false;
        }
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password.length < 8) {
            alert("Le mot de passe doit comporter au moins 8 caractères.");
            return false;
        }
        if (password != confirmPassword) {
            alert("Les mots de passe ne correspondent pas.");
            return false;
        }
        }
        </script>
    </head>
    <body>
        <h1>CV</h1>
        <form method="post" action="CV.php" id="form_cv" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="CIN">CIN:</label>
                <input type="text" id="CIN" name="CIN" required maxlength="8" placeholder="identity card">
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div class="form-group">
                <label>Marital status:</label>
                <input type="radio" id="single" name="marital_status" value="01" checked>
                <label for="single" class="po">Single</label>
                <input type="radio" id="married" name="marital_status" value="1">
                <label for="married" class="po">Married</label>
                <input type="radio" id="widowed" name="marital_status" value="2">
                <label for="widowed" class="po">Widowed</label>
            </div>
            <div class="form-group">
                <label for="num">telephon number :</label>
                <input type="number" id="num" name="num">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <div class="form-group">
                <label for="num_exp">nombre d’années d’expérience :</label>
                <input type="number" id="num_exp" name="num_exp" >
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
            <div class="form-group">
                <label for="universite">Université:</label>
                <select id="universite" name="universite" required>
                    <option value="1">ISG</option>
                    <option value="2">ESEN</option>
                    <option value="3">ISAM</option>
                    <option value="4">FSEG</option>
                    <option value="5">IHEC</option>
                </select>
            </div>
            <div class="form-group">
                <label for="photo">identity photo :</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            <button type="submit" name="register" id="register-button">Register</button>
        </form>
        <script>
  document.getElementById("register-button").addEventListener("click", function(event) {
    event.preventDefault(); // prevent the default form submission
    
    // submit the form using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "CV.php");
    xhr.onload = function() {
      if (xhr.status === 200) {
        // PHP script executed successfully, redirect to the new page
        window.location.href = "PG.php";
      }
    };
    xhr.send(new FormData(document.getElementById("form_cv")));
  });
</script>

        <?php
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
if(isset($_POST["CIN"])){
// Récupérer le CIN saisi
$CIN = $_POST["CIN"];

// Préparer la requête SQL pour récupérer les informations du demandeur
$sql1 = "SELECT * FROM demandeur_cv WHERE CIN = '$CIN'";

// Exécuter la requête
$result = $conn->query($sql1);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
  // Afficher les informations du demandeur
  while($row = $result->fetch_assoc()) {
    $CIN_demandeur = $row["CIN"];
    $nom_demandeur = $row["nom"];
    $prenom_demandeur = $row["prenom"];
    $pseudo_demandeur = $row["pseudo"];
    $password_demandeur = $row["pass_word"];
    // ajouter ici les autres champs que vous souhaitez afficher
  }
  // Récupérer les données du formulaire
$date_naissance = $_POST["date_naissance"];
$photo = $_POST["photo"];;
$etatcivil = $_POST["marital_status"];
$adresse = $_POST["address"];
$numtel = $_POST["num"];
$nb_exp = $_POST["num_exp"];
$code_uni = $_POST["universite"];
$code_dip = $_POST["diplome"];
$code_comp = $_POST["competence"];

// Préparer la requête SQL pour mettre à jour les informations du demandeur
$sql2 = "UPDATE demandeur_cv SET CIN = '$CIN_demandeur',nom = '$nom_demandeur',prenom = '$prenom_demandeur',pseudo = '$pseudo_demandeur',pass_word = '$password_demandeur',photo = '$photo', date_naissance = '$date_naissance', etat_civil = '$etatcivil', adresse = '$adresse',
num_telephone = '$numtel', nombre_annees_experience = '$nb_exp', code_universite = '$code_uni' WHERE CIN = '$CIN'";

// Exécuter la requête
if ($conn->query($sql2) === FALSE) {
    echo "Erreur lors de la mise à jour : " . $conn->error;
}
$sql3 = "UPDATE diplome_demandeur SET CIN = '$CIN_demandeur',code_diplome = '$code_dip' WHERE CIN = '$CIN'";
    
    // Exécuter la deuxième requête SQL
if ($conn->multi_query($sql3) === FALSE) {
      echo "Erreur lors de la mise à jour : " . $conn->error;
    }
$sql4 = "UPDATE competence_demandeur SET CIN = '$CIN_demandeur',code_competence = '$code_comp' WHERE CIN = '$CIN'";
    
    // Exécuter la deuxième requête SQL
if ($conn->multi_query($sql4) === FALSE) {
      echo "Erreur lors de la mise à jour : " . $conn->error;
    }
} 
else {
  // Afficher un message d'erreur si le CIN n'existe pas dans la table
  if($CIN !==''){
  $message = 'CIN n existe pas';
  echo "<script type='text/javascript'>alert('$message');</script>";}
}
}
// Fermer la connexion
$conn->close();

?>
    </body>
</html>
