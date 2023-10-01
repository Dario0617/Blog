<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../CSS/bootstrap.css" />
</head>

<?php
    if( isset( $_POST['titre'] ) && isset( $_POST['contenu'] ) ) {
        $titre = htmlentities($_POST['titre'],ENT_COMPAT,"ISO-8859-1",true);
        $contenu = htmlentities($_POST['contenu'],ENT_COMPAT,"ISO-8859-1",true);
        $date = date("Y-m-d H:i:s");
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        } catch( Exception $e) {
            die( 'Erreur : ' . $e->getMessage() );
        }
            $sql = 'INSERT INTO billets (titre, contenu, date_creation) VALUES (:titre,:contenu,:date)';
            $reponse = $bdd->prepare( $sql );
            $reponse->execute( [':titre'=>$titre, ':contenu'=>$contenu, ':date'=>$date] );
            header('Location:index.php');
            die;
    }
?>