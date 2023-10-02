<?php 
session_start();
if(isset ($_POST["login"]) && isset ($_POST["password"])){
    try {
        $bdd = new PDO('mysql:host=51.178.86.117;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
    } catch (Exception $e){
        die('Erreur :' . $e->getMessage());
    }

    $login = $_POST["login"];
    $password = $_POST["password"];

    $sql = 'SELECT * FROM users WHERE login=:login';
    $reponse = $bdd->prepare($sql);
    $reponse->execute([':login'=>$login]);

    if ($valeurs = $reponse->fetch(pdo::FETCH_ASSOC)){
        if (sodium_crypto_pwhash_str_verify($valeurs['password'], $password)){
            header('Location:index.php');
            $_SESSION['login'] = $login;
            $_SESSION['connected'] = true;
            $_SESSION['id'] = $valeurs['id'];
            die;
        }
        else{
            header('Location:connexion.php?error=1&passerror=1');
            $_SESSION['login'] = $login;
            die;
        }
    }
    else
    {
        header('Location:connexion.php?error=1&loginerror=1');
        $_SESSION['login'] = $login;
        die;
    }
}
?>