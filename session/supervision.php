<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Publication d'un quiz</title>
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
            $dateSession=time();
            $modeFonctionnement=$_POST["mode"];
            $mdpSession=$_POST["mdpSession"];
            $idquiz=$_POST["idquiz"];
            $etatsession=1;

            include '../admin/secret.php';
            $dbcon = pg_connect("host=$host user=$login password=$password");

            $request = "INSERT INTO sessions VALUES ('".time()."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."');";
            pg_query($dbcon,$request) or die("Echec de la requête");

            echo "Session démarrée le ".date('d/m/Y', $dateSession)." à ".date('H:i:s', $dateSession)."<br>";

            $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, COUNT(idQuestion)
                        FROM Repond, Etudiants, Sessions, Participe
                        WHERE Repond.idEtudiant = Etudiants.idEtudiant
                        AND Sessions.dateSession = Participe.dateSession
                        AND Participe.idEtudiant = Etudiants.idEtudiant
                        AND Sessions.dateSession='".$dateSession."'
                        GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant;";
            $result=pg_query($dbcon,$request) or die("Echec de la requête");
            
            
            echo "<tr> <td> Nom </td> <td> Prénom </td> <td> nb questions </td> </tr> ";
            while($arr = pg_fetch_array($result)){
               echo "<tr>";
               echo "<tr> <td> ".$arr["nometudiant"]."</td> <td> ".$arr["prenometudiant"]." </td> <td>".$arr["nbQuest"]."</td> </tr>";
            }
        ?>
        
    </div>
</body>
</html>