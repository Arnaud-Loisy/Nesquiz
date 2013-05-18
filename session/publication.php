<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Publication d'un quiz</title>
                <link rel="stylesheet" href="../styles/theme.css" />
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
        $dbcon = pg_connect("host=$host user=$login password=$password");
        
        echo "<h1>Publication d'un quiz</h1>";
        // Récupérer les matières du prof
        $idAdminProf=$_SESSION["id"];
        $request = "SELECT * FROM Matieres, AdminProfs, Enseigne 
                    WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf 
                    AND Matieres.idMatiere = Enseigne.idMatiere 
                    AND AdminProfs.idAdminProf = ".$idAdminProf.";";
        $result_matiere = pg_query($dbcon,$request) or die("Echec de la requête");
        
        // Afficher la liste des matières
        echo"<center>";
        echo"<form method='POST'>";
        echo"<br> Choix d'une matière : <br>";
        echo "<select name='idmatiere'>";
        while($arr = pg_fetch_array($result_matiere)){
            echo "<option value='".$arr["idmatiere"]."'> ".$arr["libellematiere"]."</option> <br>";  
        }
        echo "</select>";
        echo "<input class='boutonCenter' type='submit' value='Quiz disponibles'>";
        echo "</form>";
        
        // Si une matière a été selectionnée
        if(isset($_POST["idmatiere"])){
                // Récupérer les quiz dispo
                $request="  SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                        FROM Quiz, Inclu, Questions, Matieres
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Questions.idMatiere = Matieres.idMatiere
                        AND Matieres.idMatiere =".$_POST["idmatiere"].";";
                $result_quiz = pg_query($dbcon,$request) or die("Echec de la requête");
                
                // afficher les quiz dispo
                
                echo"<form action='trait_pub.php' method='GET'>";
                echo"<br>Quiz disponibles : <br>";
                echo"<select name='idquiz'>";
                while($arr = pg_fetch_array($result_quiz)){
                    echo "<option value='".$arr["idquiz"]."'> ".$arr["libellequiz"]."</option>";
                }
                echo "</select><br>";
                
                // Afficher le formulaire permettant de choisir mode et mdp
                echo "   <br> Mode de publication : <br>";
                echo "   <select name='mode'>";
                    echo "   <option value='2'> Quiz entier </option></select>";
                    echo "   <option value='1'> Question par Question</option>";                   
                echo "</select>";
                echo "   <br><br> Mot de passe de la session : <br>";
                
                echo "   <input type='text' name='mdpSession'> <br>";
                echo "   <input class='boutonCenter' type='submit' value='Publier'>";
        }
        echo"</center>";
        ?>
        </form>
    </div>
</body>

</html>