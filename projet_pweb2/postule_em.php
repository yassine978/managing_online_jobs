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
    $etat_condidature = 1;
    session_start();
    $cin = $_SESSION['cin_s'];
    $sth = $dbco->prepare("SELECT COUNT(*) FROM condidature WHERE code_offre_emploi = :code and cin=:cin");
    $sth->execute(array(':code' => $code,
    ':cin' => $cin,
    ));
    $count = $sth->fetchColumn();
    if($count > 0) {
        // Le code_offre_emploi existe déjà dans la base de données
        $message = "Cette offre d'emploi a déjà été postulée";
    }
    else{
        $sth = $dbco->prepare("INSERT INTO condidature(CIN, code_offre_emploi, etat_condidature)  
        VALUES (:cin, :code, :etat)");
        $sth->execute(array(
        ':cin' => $cin,
        ':etat' => $etat_condidature,
        ':code' => $code,
        ));
    $message= "vous avez postulez avec succées";}

    }
} 
catch(PDOException $e){
    $message= "Erreur pendant la suppression du livre: : " . $e->getMessage();
}
if(isset($message)){
    echo "<script type='text/javascript'>alert('$message');</script>";
    }
//Redirection vers la page livre.php avec un message résultat de la suppression 
header("Location:menu_em.php?message=$message");
?>
