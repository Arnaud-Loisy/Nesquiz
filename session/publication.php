<!doctype html>

<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Publication d'un quiz</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <script type='text/javascript'>

            function changerListeQuiz(radiobtn) {
                var idMatiere = radiobtn.value;
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "xhr_getListeQuiz.php", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        //alert(xhr.responseText);
                        document.getElementById('select_idquiz').innerHTML = xhr.responseText;
                    }
                };

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("idMatiere=" + idMatiere);
            }




        </script>


    </head>

    <body>
        <div id='page'>
            <?php
            session_start();

            if (!(isset($_SESSION["id"])) || ($_SESSION["statut"] == "etu")) {
                header('Location:../index.php');
            }

            include '../accueil/menu.php';
            // connexion à la BD
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();


            echo "<h1>Publication d'un quiz</h1>";
            // Récupérer les matières du prof
            $idAdminProf = $_SESSION["id"];
            $result_matiere = pg_query($dbcon, requete_toutes_matieres_pour_un_professeur($idAdminProf)) or die("Echec de la requête");

            // Afficher la liste des matières
            echo"<center>";
            echo"<br> Choix d'une matière : <br>";
            echo "<div style='display: inline-table;' class='radioButtons'>";

            while ($row = pg_fetch_array($result_matiere)) {
                $libelleMatiere = $row["libellematiere"];
                $idMatiere = $row["idmatiere"];

                echo "<span class='rightRadioButton'><input onClick='changerListeQuiz(this)' type ='radio' id='radio_" . $libelleMatiere . "' name='radios_matieres' value='" . $idMatiere . "' />";
                echo "<label for='radio_" . $libelleMatiere . "'>" . $libelleMatiere . "</label></span>";
            }
            echo "</div>";

            // afficher les quiz dispo
            echo"<form action='trait_pub.php' method='GET'>";
            echo"<br>Quiz disponibles : <br>";
            echo"<select id='select_idquiz' name='idquiz' style='width: 200px;'>";
            echo "</select> <br>";

            // Afficher choix mode de publication
            echo "<br> Mode de publication : <br>";
            echo "<div style='display: inline-table;' class='radioButtons'>";
            echo "<span class='rightRadioButton'>";
            echo "<input type ='radio' id='radio_mode1' name='mode' value='1'/>";
            echo "<label for='radio_mode1'> Question par Question</label>";
            echo "<input type ='radio' id='radio_mode2' name='mode' value='2'/>";
            echo "<label for='radio_mode2'> Quiz entier</label>";
            echo "</span>";
            echo "</div>";

            // Afficher saisie mot de passe
            echo "   <br><br> Mot de passe de la session : <br>";
            echo "   <input type='text' name='mdpSession'> <br>";
            echo "   <input class='boutonCenter' type='submit' value='Publier'>";
            echo "</form>";
            echo"</center>";
            
  
            ?>

        </form>
    </div>
</body>

</html>
