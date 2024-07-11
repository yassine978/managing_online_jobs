<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WELCOME</title>
        <link rel="stylesheet" href="PG_css.css">
        
    </head>
    <body>
        <div class="login-container">
            <h1 class="h">Login</h1>
            <form method="post">
                <input type="text" id="Username" name="Username" placeholder="Username">
                <input type="password" id="Password" name="Password" placeholder="Password">
                <button type="submit" name="submit">Log in</button><br>
                <button type="submit" formaction="choix.php">sign in</button>
            </form>
        </div>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bureau_emploi";

            try {
                $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if(isset($_POST['submit'])){
                    $username = $_POST['Username'];
                    $pass = $_POST['Password'];

                    $stmt0 = $dbco->prepare("SELECT * FROM `demandeur_cv` WHERE pseudo = :Username AND pass_word = :pass");
                    $stmt0->execute(array(':Username' => $username, ':pass' => $pass));

                    $stmt1 = $dbco->prepare("SELECT * FROM `employeur` WHERE pseudo = :Username AND pass_word = :pass");
                    $stmt1->execute(array(':Username' => $username, ':pass' => $pass));

                    if($stmt0->rowCount() > 0){
                        // Connexion réussie
                        // Prepare the SQL statement to retrieve the user's ID based on their username and password
                        $stmt3 = $dbco->prepare('SELECT CIN FROM demandeur_cv WHERE pseudo = :username AND pass_word = :pass');
                    
                        // Bind the username and password parameters to the prepared statement
                        $stmt3->bindParam(':username', $username);
                        $stmt3->bindParam(':pass', $pass);
                    
                        // Execute the prepared statement
                        $stmt3->execute();
                    
                        // Retrieve the user's ID from the query result
                        $cin_s = $stmt3->fetchColumn();

                        // Start a new session
                        session_start();
                    
                        // Store the user's primary key in the session
                        $_SESSION['cin_s'] = $cin_s;
                        header('Location: menu_em.php');
                        exit();
                    }
                    elseif($stmt1->rowCount() > 0){
                        // Connexion réussie
                        // Prepare the SQL statement to retrieve the user's ID based on their username and password
                        $stmt3 = $dbco->prepare('SELECT code_registre_commerce FROM employeur WHERE pseudo = :username AND pass_word = :pass');
                    
                        // Bind the username and password parameters to the prepared statement
                        $stmt3->bindParam(':username', $username);
                        $stmt3->bindParam(':pass', $pass);
                    
                        // Execute the prepared statement
                        $stmt3->execute();
                    
                        // Retrieve the user's ID from the query result
                        $code_r = $stmt3->fetchColumn();
                    
                        // Insert a new row in the employeur_offre table with the code_registre_commerce and code_offre_emploi values
                        $code_offre_emploi = 0;
                        $stmt2 = $dbco->prepare('INSERT INTO employeur_offre (code_registre_commerce, code_offre_emploi) VALUES (:code_r, :code_offre_emploi)');
                        $stmt2->bindParam(':code_r', $code_r);
                        $stmt2->bindParam(':code_offre_emploi', $code_offre_emploi);
                        $stmt2->execute();
                    
                        // Start a new session
                        session_start();
                    
                        // Store the user's primary key in the session
                        $_SESSION['code_r'] = $code_r;
                    
                        header('Location: his_en.php');
                        exit();
                    }
                    else{
                        // Mauvais email ou mot de passe
                        $message = 'Incorrect username or password!';
                    }
                }

            } catch(PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }

            if(isset($message)){
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        ?>
    </body>
</html>