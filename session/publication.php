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
        include '../accueil/menu.php';
        include '../admin/secret.php';
     
        $idAdminProf=$_SESSION["id"];
            
        $dbcon = pg_connect("host=$host user=$login password=$password");
        $request = "SELECT * FROM Matieres, AdminProfs, Enseigne WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf AND Matieres.idMatiere = Enseigne.idMatiere AND AdminProfs.idAdminProf = ".$idAdminProf.";";
        $result_matiere = pg_query($dbcon,$request) or die("Echec de la requête");
        
        
        echo"<form method='POST'>";
        echo"<br><br> Mes matières : <br>";
        while($arr = pg_fetch_array($result_matiere)){
            echo "<input type='radio' name='idmatiere' value='".$arr["idmatiere"]."'> ".$arr["libellematiere"]." <br>";
        }
        echo "<input class='bouton' type='submit' value='Afficher les quiz associés'>";
        echo "</form>";
        
        if(isset($_POST["idmatiere"])){
            $request="  SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                        FROM Quiz, Inclu, Questions, Matieres
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Questions.idMatiere = Matieres.idMatiere
                        AND Matieres.idMatiere =".$_POST["idmatiere"].";";
            
             $result_quiz = pg_query($dbcon,$request) or die("Echec de la requête");
                echo"<form action='supervision.php' method='POST'>";
                echo"<br>Quiz disponibles : <br>";
                while($arr = pg_fetch_array($result_quiz)){
                    echo "<input type='radio' name='idquiz' value='".$arr["idquiz"]."'> ".$arr["libellequiz"]." <br>";
                }
        

            
        
        echo "   <br> Mode de publication : <br>";
        echo "   <input type='radio' name='mode' value='1'> Question par Question<br>";
        echo "   <input type='radio' name='mode' value='2'> Quiz entier<br>";
        echo"    <br> Mot de passe de la session :";
        echo "   <input type='text' name='mdpSession'> <br>";
        echo"    <input class='bouton' type='submit' value='Démarrer'>";
        }
        ?>
        </form>
    </div>
</body>

</html>