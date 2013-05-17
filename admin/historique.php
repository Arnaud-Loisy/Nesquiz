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
        
         $request = "SELECT dateSession, libelleQuiz
                    FROM Sessions, Quiz
                    WHERE Sessions.idQuiz = Quiz.idQuiz
                    ORDER BY Sessions.dateSession;";
        $result_sessions = pg_query($dbcon,$request) or die("Echec de la requête");
        
        echo "<table style='margin: auto'>";
        echo "<tr><td> Quiz </td><td> Date </td><td> Heure </td></tr>";
        
        while($arr=  pg_fetch_array($result_sessions)){
            $dateSession=$arr["datesession"];
            $libelleQuiz=$arr["libellequiz"];
            echo "<tr><td>".$libelleQuiz."</td><td>".date('d/m/Y', $dateSession)."</td><td>".date('H:i:s', $dateSession)."</td></tr>";
        }
        echo "</table>";
        ?>
    </div>
</body>
</html>
        