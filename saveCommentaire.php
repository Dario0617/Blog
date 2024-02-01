<?php
	session_start();

	$text = $_POST['commentaryText'];
	$idBillet = $_POST['idBillet'];
	$auteur = $_SESSION['login'];
	$date = date("Y-m-d H:i:s");

    if(isset ($text) && isset ($idBillet) && isset ($auteur)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }

        $text = htmlentities($text,ENT_COMPAT,"ISO-8859-1",true);

        $sql = "INSERT INTO `Comment` (`TicketId`, `Autor`, `Content`, `CreationDate`, `Verify`) 
			VALUES (:idBillet, :auteur, :commentaire, :date, :verify)";
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':idBillet'=>$idBillet, ':auteur'=>$auteur, 
		':commentaire'=>$text, ':date'=>$date, ':verify'=>0]);
        header('Location:Commentaires.php?idBillet=' . $idBillet . '&validation=1');
        	die;
    }
    header('Location:Commentaires.php?idBillet=' . $idBillet);
        	die;
?>
