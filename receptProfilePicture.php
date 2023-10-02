<?php 
    session_start();
    $id = $_SESSION['id']
?>

<!DOCTYPE html>
<head>
    <meta charset="ISO-8859"/>
    <link rel="stylesheet" href="../../CSS/bootstrap.css" />
    <title> ReceptProfilePicture </title>
</head>

<body>
    <header class="container">
        <div class="row">
            <div class="col-12">
                <h1>ReceptProfilePicture</h1>
            </div>
        </div>    
    </header>
    
    <section>
        <div class="row">
            <div class="col-12">
                <?php
                if (isset($_FILES["myfile"]) && $_FILES["myfile"]["error"] == 0)
                {
                    if ($_FILES["myfile"]["size"] <= 1000000)
                    {
                        $infosFichier = pathinfo($_FILES["myfile"]["name"]);
                        $extensionUpload = $infosFichier["extension"];
                        $extensionsAutorisees = array("jpg", "jpeg", "gif", "png");
                        if (in_array($extensionUpload, $extensionsAutorisees))
                        {
                            move_uploaded_file($_FILES["myfile"]["tmp_name"], "images/" . 
                            basename($_FILES["myfile"]["name"]));
                            try {
                                $bdd = new PDO('mysql:host=51.178.86.117;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
                            } catch (Exception $e){
                                die('Erreur :' . $e->getMessage());
                            }
                            $nameFile = $_FILES["myfile"]["name"];
                            $sql = 'UPDATE users SET image=:nameFile WHERE id=:id';
                            $reponse = $bdd->prepare($sql);
                            $reponse->execute([':id'=>$id, ':nameFile'=>$nameFile]);
                            header('Location:profile.php');
                            die;
                        }
                        else
                        {
                            echo "L'extension doit être jpg/jpeg/gif/png";
                        }
                    }
                    else
                    {
                        echo "Votre fichier doit être inférieur a 1Mo";
                    }
                }
                else
                {
                    echo "Erreur lors de l'envoie";
                }
                ?>
            </div>  
        </div>        
    </section>
</body>
</html>