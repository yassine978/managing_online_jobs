<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>INSCRIPTION EMPLOYEE</title>
        <link rel="stylesheet" href="css_ins.css">
        <script>
        function validateForm() {
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
        <h1>Registration Form</h1>
        <form id='form1' method="post" action="ins_em.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="CIN">CIN:</label>
                <input type="text" id="CIN" name="CIN" required maxlength="8" placeholder="identity card">
            </div>
            <div class="form-group">
                <label for="family_name">Family name :</label>
                <input type="text" id="family_name" name="family_name" required placeholder="family name">
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required placeholder="your name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="your email">
            </div>
            <div class="form-group">
                <label for="pseudo">Pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="choose un pseudo" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" id="register-button">Register</button>
        </form>
        <script>
  document.getElementById("register-button").addEventListener("click", function(event) {
    event.preventDefault(); // prevent the default form submission
    
    // submit the form using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ins_em.php");
    xhr.onload = function() {
    if (xhr.status === 200) {
        if(xhr.responseText === "success") {
            window.location.href = "CV.php";
        } else {
            alert("There was an error during registration. Please try again.");
        }
    }
    };
    xhr.send(new FormData(document.getElementById("form1")));
  });
</script>
        <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bureau_emploi";
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["CIN"]) && isset($_POST["name"]) && isset($_POST["family_name"]) && isset($_POST["pseudo"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        $cin = $_POST["CIN"];
        $name = $_POST["name"];
        $f_name = $_POST["family_name"];
        $pseudo = $_POST["pseudo"];
        $pass = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $date_naissance = date('Y-m-d');
        $etat_civil = 0;
        $num_telephone = 0;
        $nombre_annees_experience = 0;
        $code_universite = 0;
        $competence = 0;
        $diplome = 0;
        $message = '';
        try {
            // Vérifie si le pseudo existe déjà
            $sth = $dbco->prepare("SELECT COUNT(*) FROM demandeur_cv WHERE pseudo = :pseudo");
            $sth->execute(array(':pseudo' => $pseudo));
            $resultat = $sth->fetchColumn();
            if (strlen($password) < 8) {
                $message = "error: password must be at least 8 characters";
                exit;
            }
            if ($password !== $confirm_password) {
                $message = "error: passwords do not match";
                exit;
            }

            if ($resultat > 0) {
                $message = 'Pseudo déjà utilisé';
            } 
            else {
                // Vérifie si le CIN existe déjà
                $sth = $dbco->prepare("SELECT COUNT(*) FROM demandeur_cv WHERE CIN = :cin");
                $sth->execute(array(':cin' => $cin));
                $resultat = $sth->fetchColumn();

                if ($resultat > 0) {
                    $message = 'CIN déjà utilisé';
                } 
                else {
                    // Insertion de l'enregistrement
                    $sth = $dbco->prepare("INSERT INTO demandeur_cv(CIN, nom, prenom, pseudo, pass_word, photo, date_naissance, etat_civil, adresse, num_telephone, nombre_annees_experience, code_universite)  
                    VALUES (:cin, :c_name, :f_name, :pseudo, :pass, '', :date_naissance, :etat_civil, :adresse, :num_telephone, :nombre_annees_experience, :code_universite)");
                    
                    $sth1 = $dbco->prepare("INSERT INTO competence_demandeur(CIN, code_competence)  
                    VALUES (:cin,:competence )");

                    $sth2 = $dbco->prepare("INSERT INTO diplome_demandeur(CIN,code_diplome )  
                    VALUES (:cin,:diplome )");
                    // Bind the parameters to the placeholders
                    $sth->execute(array(
                        ':cin' => $cin,
                        ':c_name' => $name,
                        ':f_name' => $f_name,
                        ':pseudo' => $pseudo,
                        ':pass' => $pass,
                        ':date_naissance' => $date_naissance,
                        ':etat_civil' => $etat_civil,
                        ':adresse' => '',
                        ':num_telephone' => $num_telephone,
                        ':nombre_annees_experience' => $nombre_annees_experience,
                        ':code_universite' => $code_universite
                    ));
                    $sth1->execute(array(
                        ':cin' => $cin,
                        ':competence' => $competence
                    ));
                    $sth2->execute(array(
                        ':cin' => $cin,
                        ':diplome' => $diplome
                    ));
                }
            }
        }
        catch(PDOException $e){
            $message = "Erreur : " . $e->getMessage();
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
    }

?>
    </body>
</html>
