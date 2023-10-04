<?php
    session_start();
    if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
        $login = htmlentities($_POST['login'],ENT_COMPAT,"ISO-8859-1",true);
        $password = htmlentities($_POST['password'],ENT_COMPAT,"ISO-8859-1",true);
        echo $password = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, 
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch( Exception $e) {
            die( 'Erreur : ' . $e->getMessage() );
        }
        $sql = 'SELECT * FROM users WHERE login=:login';
        $reponse = $bdd->prepare( $sql );
        $reponse->execute( [':login'=>$login] );
        if( $acces = $reponse->fetch(PDO::FETCH_ASSOC) ) {
            header('Location:Inscription.php?error=1&loginerror=1');
            $_SESSION['login'] = $login;
            die;
        } else {
            if (!(strlen($password) >= 8)){
                $_SESSION['login'] = $login;
                header('Location:Inscription.php?error=1&passerror=1&login='.$login);
                die;
            }
            else{
                $sql = 'INSERT INTO users (login, password) VALUES (:login,:password)';
                $reponse = $bdd->prepare( $sql );
                $password = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, 
                SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
                $reponse->execute( [':login'=>$login, ':password'=>$password] );
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                $_SESSION['id'] = $pdo->lastInsertId();
                header('Location:sendProfilePicture.php');
                die;
            }
        }

    }

?>