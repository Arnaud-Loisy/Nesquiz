<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["idMatiere"])) {
    $idMatiere = $_POST["idMatiere"];
    $dbcon = connexionBDD();
    if (!$dbcon) {
        echo "connexion BDD failed<br>";
    } else {
        $result_quiz = pg_query($dbcon, requete_liste_quiz_entier_d_une_matiere($idMatiere));

        echo"<select id='select_idquiz' name='idquiz' style= 'width: 200px;'>";
        while ($arr = pg_fetch_array($result_quiz)) {
            echo "<option value='" . $arr['idquiz'] . "'> " . $arr['libellequiz'] . "</option>";
        }
        echo "</select><br>";
    }
}
?>