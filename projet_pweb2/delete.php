<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bureau_emploi";

try
{
// Création de la connexion
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
if(!empty($_GET["code_offre_emploi"])){
    //Supprimer le livre dont l'id est envoyé avec l'URL
    $code = $_GET["code_offre_emploi"];
    $sth = $dbco->prepare("DELETE FROM condidature WHERE code_offre_emploi = $code;
    DELETE FROM employeur_offre WHERE code_offre_emploi = $code;
    DELETE FROM offre_competance WHERE code_offre_emploi = $code;
    DELETE FROM offre_emploi WHERE code_offre_emploi = $code;
    ");
    $sth->execute();
    echo $sth->rowCount() . " rows deleted.";
    $message= "le livre a été supprimé avec succés";

    }
} 
catch(PDOException $e){
    $message= "Erreur pendant la suppression du livre: : " . $e->getMessage();
}
//Redirection vers la page livre.php avec un message résultat de la suppression 
header("Location:his_en.php?message=$message");
?>
