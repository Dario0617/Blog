<?php
    session_start();
    if( isset( $_POST['titre'] ) && isset( $_POST['contenu'] ) ) {
        $titre = htmlentities($_POST['titre'],ENT_COMPAT,"ISO-8859-1",true);
        $contenu = htmlentities($_POST['contenu'],ENT_COMPAT,"ISO-8859-1",true);
        $date = date("Y-m-d H:i:s");
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
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