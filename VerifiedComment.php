<?php
	session_start();

    $commentId = $_POST['commentId'];
    $rejected = $_POST['rejected'];

    if(isset ($commentId)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
        if (isset($rejected)){
            $sql = 'DELETE FROM Comment WHERE Id=:id';
            $reponse = $bdd->prepare($sql);
            $reponse->execute([':id'=>$commentId]);
            var_dump($reponse);
            header('Location:CommentManagement.php?validation=1&rejected=1');
            die;
        } else {
            $sql = 'UPDATE Comment SET Verify=:verify WHERE Id=:id';
            $reponse = $bdd->prepare($sql);
            $reponse->execute([':verify'=>true, ':id'=>$commentId]);
            header('Location:CommentManagement.php?validation=1');
            die;
        }
    }

    header('Location:CommentManagement.php');
    die;
?>
