<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Historique</title>
                <link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
                
        </head>

<body>
    <div id='page'>
        <?php 

        session_start();
        
        if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]!="admin")){
             header('Location:../index.php');
         }
         
        include '../accueil/menu.php';
        include '../admin/secret.php';
        $dbcon = pg_connect("host=$host user=$login password=$password");
        
        echo "<h1> Historique des sessions </h1>";
        
        if(isset($_SESSION["delSession"])){
                   echo "<center>Session(s) supprimée(s) avec succès !<br><br></center>";
                   unset ($_SESSION["delSession"]);
        }
        
        // Selectionner les sessions triées de la plus récente à la plus ancienne
         $request = "SELECT dateSession, libelleQuiz, etatSession
                    FROM Sessions, Quiz
                    WHERE Sessions.idQuiz = Quiz.idQuiz
                    ORDER BY Sessions.dateSession DESC;";
        $result_sessions = pg_query($dbcon,$request) or die("Echec de la requête");
        
       
        
        // Afficher la liste des sessions
        echo "<form method='POST' action='trait_historique.php'>";
        echo "<table style='margin: auto'>";
        echo "<tr><td> Quiz </td><td> Date </td><td> Heure </td><td> Supprimer </td></tr>";
        
        while($arr=  pg_fetch_array($result_sessions)){
            $dateSession=$arr["datesession"];
            $libelleQuiz=$arr["libellequiz"];
            $etatsession=$arr["etatsession"];
            // si la session est terminée
            if($etatsession==3){
                echo "<tr><td>".$libelleQuiz."</td><td>".date('d/m/Y', $dateSession)."</td><td>".date('H:i:s', $dateSession)."</td>";
                echo "<td><input type='checkbox' name='session[]' value='".$dateSession."'></td></tr>";
            }
        }
        
        echo "</table>";
        echo "<input class='boutonCenter' type='Submit' name='Valider'>";
        echo "</form>";
        
        
        ?>
    </div>
</body>
</html>
        