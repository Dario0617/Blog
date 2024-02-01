<?php
    session_start();
    if( isset( $_POST['titre'] ) && isset( $_POST['contenu'] ) ) {
        $title = htmlentities($_POST['titre'],ENT_COMPAT,"ISO-8859-1",true);
        $content = htmlentities($_POST['contenu'],ENT_COMPAT,"ISO-8859-1",true);
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s");
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch( Exception $e) {
            die( 'Erreur : ' . $e->getMessage() );
        }
        $sql = 'INSERT INTO Ticket (Title, Content, CreationDate) VALUES (:title,:content,:creationDate)';
        $reponse = $bdd->prepare( $sql );
        $reponse->execute( [':title'=>$title, ':content'=>$content, ':creationDate'=>$date] );
        header('Location:index.php');
        die;
    }
?>