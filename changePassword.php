<?php
	session_start();

	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	$userId = $_POST['userId'];

    if(isset ($password) && isset ($confirmPassword) && isset ($userId)){
        if (!(strlen($password) >= 8)){
            header('Location:UserManagement.php?error=1&passerror=1&login=');
            die;
        }
        if ($password !== $confirmPassword){
                header('Location:UserManagement.php?error=1&confirmPasserror=1');
                die;
        }
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }

        $sql = 'UPDATE User SET Password=:password WHERE Id=:id';
        $reponse = $bdd->prepare($sql);

        $hashPassword = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, 
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
        $reponse->execute([':password'=>$hashPassword, ':id'=>$userId]);

        header('Location:UserManagement.php?validation=1');
        	die;
    }
    header('Location:UserManagement.php');
    die;
?>
