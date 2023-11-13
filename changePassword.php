<?php
	session_start();

	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	$userId = $_POST['userId'];

    if(isset ($password) && isset ($confirmPassword) && isset ($userId)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }

        $text = htmlentities($text,ENT_COMPAT,"ISO-8859-1",true);

        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':password'=>$password, ':id'=>$userId]);

        header('Location:UserManagement.php');
        	die;
    }
?>
