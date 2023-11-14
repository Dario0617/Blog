<?php 
    session_start();
    $_SESSION['connected'] = true;
?>

<!DOCTYPE html>
<head>
    <meta charset="ISO-8859"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
    <title> Photo de profil </title>
</head>

<body>
    <header class="container">
        <div class="row">
            <div class="col-12">
                <h1>Veuillez fournir une photo de profil</h1>
            </div>
        </div>    
    </header>
    
    <section class="container">
        <div class="row">
            <div class="col-12">
                <form name="sendProfilePicture" method="post" enctype="multipart/form-data" action="ReceptProfilePicture.php">
                <div class="input-group">
                        <input type="file" class="form-control" id="inputGroupFile04" 
                        aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="myfile">
                        <input class="btn btn-outline-secondary" type="submit" value="OK" name="send" id="inputGroupFile04">
                    </div>
                </form> 
            </div>  
        </div>
        <div class="row">
            <div class="col-12">
                <a class="nav-link" aria-current="page" href="index.php">Ignorer photo de profil</a>
            </div>
        </div>
    </section>

</body>
</html>