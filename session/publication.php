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
        
        include '../accueil/menu.php';
        include '../admin/secret.php';
     
        $dbcon = pg_connect("host=$host user=$login password=$password");
        $request = "SELECT * FROM Matières, AdminProfs, Enseigne WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf AND Matieres.idMatiere = Enseigne.idMatiere AND AdminProfs.idAdminProf = $idAdminProf;";
        $result = pg_query($dbcon,$request) or die("Echec de la requête");

            
        ?>
        <form action="xxx.php" method="POST">
        <br><br> Mes matières : <br>
        <?php
         $idMatiere = 1;
         $libelleMatiere="matiere courante";
         
         
         
       //     for($idMatiere;$idMatiere<5;$idMatiere++)
                echo "<input type='radio' name='matiere' value='".$idMatiere."'> ".$libelleMatiere." <br>";
        ?>

        <br> Liste des Quiz : <br>
        <?
            $idQuiz = 0;
            $libelleQuiz = "Quiz de la mort qui tue";

            for($idQuiz;$idQuiz<3;$idQuiz++)
                echo "<input type='radio' name='quiz' value='".$idQuiz."'> ".$libelleQuiz." <br>";
        ?>
            <br> Mode de publication : <br>
            <input type="radio" name="mode" value="1"> Question par Question<br>
            <input type="radio" name="mode" value="2"> Quiz entier<br>
            <br> Mot de passe de la session :
            <input type="text" name="mdpSession"> <br>
            <input class="bouton" type="submit" value="Démarrer">
        </form>
    </div>
</body>

</html>