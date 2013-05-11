<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Supervision d'une session</title>
                <link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <?php
            
            session_start();
            if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
                header('Location:../index.php');
            }
            if(!(isset($_GET["mode"])) || !(isset($_GET["idquiz"]))){
                header('Location:publication.php');
            }
            
            header("refresh: 5; url=supervision.php");
            
// Récup des variables
            $dateSession= 1;//time()+6*3600;
            $modeFonctionnement=$_GET["mode"];
            $mdpSession=$_GET["mdpSession"];
            $idquiz=$_GET["idquiz"];
            $etatsession=1;
            
            $_SESSION["datesession"]=$dateSession;
            $_SESSION["idquiz"]=$idquiz;
            
            // connexion à la BD
            include '../admin/secret.php';
            $dbcon = pg_connect("host=$host user=$login password=$password");
            
            // Créa de la session
            $request = "INSERT INTO sessions VALUES ('".time()."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."');";
            pg_query($dbcon,$request) or die("Echec de la requête");
            
            echo "Session démarrée le ".date('d/m/Y', $dateSession)." à ".date('H:i:s', $dateSession)."<br>";
            
            // si mode quiz entier
            if ($modeFonctionnement==2){
                
                // Récupération des étudiants participants et nb de questions auxquels ils ont répondus
                $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, COUNT(idQuestion)
                            FROM Repond, Etudiants, Sessions, Participe
                            WHERE Repond.idEtudiant = Etudiants.idEtudiant
                            AND Sessions.dateSession = Participe.dateSession
                            AND Participe.idEtudiant = Etudiants.idEtudiant
                            AND Sessions.dateSession='".$dateSession."'
                            GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant;";
                           $result=pg_query($dbcon,$request) or die("Echec de la requête");

                // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                echo "<tr> <td> Nom </td> <td> Prénom </td> <td> nb questions </td> </tr> ";
                while($arr = pg_fetch_array($result)){
                   echo "<table>";
                   echo "<tr> <td> ".$arr["nometudiant"]."</td> <td> ".$arr["prenometudiant"]." </td> <td>".$arr["count"]."</td> </tr>";
                }
                echo "</table>";
            }
            
            // si mode Question/question
            else
            {
 
            }
            
            // afficher bouton "arreter le quiz"
            echo "<form method='POST' action='resultats.php'>";
            echo "<input class='bouton' type='submit' value='Arrêter'>";
            echo "</form>";
            
           

            ?>
        
    </div>
</body>
</html>