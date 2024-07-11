<?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "bureau_emploi";
    try{
        $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sth = $dbco->prepare ("DELETE FROM employeur_offre WHERE code_offre_emploi=0;");
        $sth->execute();
    }
    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }
session_start();
session_destroy();
header('Location: PG.php');
exit();

?>
