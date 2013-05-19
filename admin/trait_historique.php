<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Historique</title>
                <link rel="stylesheet" href="../styles/theme.css" />
                
        </head>

<body>
    <div id='page'>
        <?php 

        session_start();
        
        if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]!="admin")){
             header('Location:../index.php');
         }
        if(!(isset($_POST)))
            header('Location:historique.php');
        
        include '../accueil/menu.php';
        include '../admin/secret.php';
        $dbcon = pg_connect("host=$host user=$login password=$password");
        
        //Supprimer l'ensemble des entrée avec l'id session en param
        foreach($_POST['session'] as $dateSession){
            $request = "DELETE FROM Repond
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Participe
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Sessions
                        WHERE dateSession='".$dateSession."';";
            pg_query($dbcon,$request) or die("Echec de la requête");
            
         }
         
         $_SESSION["delSession"]=1;
         
         header('Location:historique.php');
       ?> 
        </div>
</body>
</html>