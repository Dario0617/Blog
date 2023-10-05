<?php
	session_start();

	$text = $_POST['text'];
	$idBillet = $_POST['idBillet'];
	$auteur = $_POST['auteur'];
	$date = date("Y-m-d H:i:s");
	
    if(isset ($text) && isset ($idBillet) && isset ($auteur)){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }

        $text = htmlentities($_POST['text'],ENT_COMPAT,"ISO-8859-1",true);

        $sql = "INSERT INTO `commentaires` (`id_billet`, `auteur`, `commentaire`, `date_commentaire`) 
			VALUES (:idBillet, :auteur, :text, :date)";
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':idBillet'=>$idBillet, ':auteur'=>$auteur, 
		':text'=>$text, ':date'=>$date]);
		echo json_encode(array("statusCode"=>200));
		echo $reponse;
        // header('Location:commentaires.php');
        //     die;
    }
?>
