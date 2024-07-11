<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>INSCRIPTION COMPANY</title>
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
        <form method="post" action="ins_en.php" id='form2' onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Company Name:</label>
                <input type="text" id="name" name="name" required placeholder="company name">
            </div>
            <div class="form-group">
                <label for="m_name">Manager Name:</label>
                <input type="text" id="m_name" name="m_name" required placeholder="manager name">
            </div>
            <div class="form-group">
                <label for="m_f_name">Manager Family Name:</label>
                <input type="text" id="m_f_name" name="m_f_name" required placeholder="manager family name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="manager email">
            </div>
            <div class="form-group">
                <label for="code">Registration Code:</label>
                <input type="text" id="code" name="code" required placeholder="company registration code">
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
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" id="register-button">Register</button>
        </form>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bureau_emploi";
        $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST["m_name"]) && isset($_POST["name"]) && isset($_POST["m_f_name"]) && isset($_POST["pseudo"]) && isset($_POST["password"]) && isset($_POST["code"])) {
        //récupération des données envoyées
        $c_name = $_POST["name"];//la valeur entre le crocher est le name de champ dans le form
        $m_name =  $_POST["m_name"];
        $m_f_name =  $_POST["m_f_name"];
        $code =  $_POST["code"];
        $pseudo =  $_POST["pseudo"];
        $pass =  $_POST["password"];
        try{
            // Vérifie si le pseudo existe déjà
            $sth = $dbco->prepare("SELECT COUNT(*) FROM employeur WHERE pseudo = :pseudo");
            $sth->execute(array(':pseudo' => $pseudo));
            $resultat = $sth->fetchColumn();
            if ($resultat > 0) {
            $message = 'Pseudo déjà utilisé';
            }
            else {
              // Vérifie si le CIN existe déjà
              $sth = $dbco->prepare("SELECT COUNT(*) FROM employeur WHERE code_registre_commerce = :code");
              $sth->execute(array(':code' => $code));
              $resultat = $sth->fetchColumn();
              if ($resultat > 0) {
                  $message = 'code déjà utilisé';
              }
              else{
                $sth = $dbco->prepare("INSERT INTO employeur(code_registre_commerce, nom_entreprise, nom_gerant,prenom_gerant,pseudo,pass_word)  
                  VALUES (:code, :c_name, :m_name,:m_f_name,:pseudo,:pass) ");
                //on remplace  les valeurs dans notre requête SQL par nos marqueurs nommés
                $sth->execute(array(
                ':c_name' => $c_name,':m_name' => $m_name,':m_f_name' => $m_f_name,':code' => $code,':pseudo' => $pseudo,':pass' => $pass
                ));
                
              }
            }
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }
        header("Location: PG.php");
        exit;
      }
        ?>
    </body>
</html>