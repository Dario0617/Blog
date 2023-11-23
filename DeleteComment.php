<?php
	session_start();

    $ticketId = $_POST['ticketId'];
    $commentaryId = $_POST['commentaryId'];

    if(isset ($ticketId) && isset ($commentaryId)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
        
        $sql = 'SELECT COUNT(*) AS total FROM `commentaires` WHERE id=:id && id_billet=:ticketId';

        $reponse = $bdd->prepare($sql);
        $reponse->execute([':ticketId'=>$ticketId, ':id'=>$commentaryId]);
        $result = $reponse->fetch(PDO::FETCH_ASSOC);
        if ($result['total'] == 1) {
            $sql = 'DELETE FROM `commentaires` WHERE `commentaires`.`id`=:id';
            $reponse = $bdd->prepare($sql);
            $reponse->execute([':id'=>$commentaryId]);
        } else {
            //Traitement bug aucune données retourner avec cette id billet et id commentaire
        }
    }

    header('Location:Commentaires.php?idBillet='+$ticketId);
    die;
?>
