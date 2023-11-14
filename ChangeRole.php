<?php
	session_start();

    $roleId = $_POST['roleId'];
    $userId = $_POST['userId'];

    if(isset ($roleId)&& isset ($userId)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
        
        $sql = 'UPDATE users SET roleId=:roleId WHERE id=:id';

        $reponse = $bdd->prepare($sql);
        $reponse->execute([':roleId'=>$roleId, ':id'=>$userId]);  
    }

    header('Location:UserManagement.php');
    die;
?>
