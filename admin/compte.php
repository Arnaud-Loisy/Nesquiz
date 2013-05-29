<!doctype html>

<html>
    <head>
        <title>Gestion des Compte</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type='text/javascript'>
            function changerUtilisateur(radios_compte) {
                var utilisateur = radios_compte.value;
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "xhr_compte.php", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        //alert(xhr.responseText);
                        document.getElementById('enseignant').innerHTML = xhr.responseText;
                    }
                };

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("utilisateur=" + utilisateur);
            }
        </script>
    </head>
    <body>
        <div id="page">
            <?php
            session_start ();
            if (!(isset ($_SESSION["id"])) || ($_SESSION["statut"] == "etu") || ($_SESSION["statut"] == 'prof'))
                header ('Location:../index.php');

            include '../accueil/menu.php';
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';

            if (isset ($_SESSION["erreur_inscription_numero_etu"])) {
                echo"<br>Erreur:Ce numéro étudiant possède déjà un compte.<br>";
                unset ($_SESSION["erreur_inscription_numero_etu"]);
            }
            if (isset ($_SESSION["erreur_inscription_incomplet"])) {
                echo"<br>Erreur:Veuillez remplir tous les champs du formulaire.<br>";
                unset ($_SESSION["erreur_inscription_incomplet"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_nom"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'nom' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_nom"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_prenom"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'prenom' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_prenom"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_etu"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'numero etudiant' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_etu"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_promotion"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'promotion' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_promotion"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_mdp"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'Mot De Passe' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_mdp"]);
            }
            if (isset ($_SESSION["erreur_longeur_champ_inscription_cmdp"])) {
                echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
                echo "<br>Veuillez réduire le champ 'Confirmation Mot de Passe' qui est  trop long.<br>";
                unset ($_SESSION["erreur_longeur_champ_inscription_cmdp"]);
            }
            if (isset ($_SESSION["erreur_num_etu"])) {
                echo "<br>Erreur: Le Numéro Etudiant ne  doit contenir que des nombres<br>";
                unset ($_SESSION["erreur_num_etu"]);
            }
            if (isset ($_SESSION["erreur_promotion"])) {
                echo "<br>Erreur: La Promotion ne  doit contenir que des nombres<br>";
                unset ($_SESSION["erreur_promotion"]);
            }

            if (isset ($_SESSION["erreur_creation"])) {
                echo"<br> Identifiant déjà existant.";
                unset ($_SESSION["erreur_creation"]);
            }
            $_SESSION['enseignant'] = 1;

            $dbcon = connexionBDD ();

            echo "<br><div style='display: inline-table;' class='radioButtons'>
                     <span class='rightRadioButton'><input onClick='changerUtilisateur(this)' type ='radio' id='radio_etudiant' name='radios_compte' value='etudiant'/>
                     <label for='radio_etudiant'> Etudiant </label></span>
                     <span class='rightRadioButton'><input onClick='changerUtilisateur(this)' type ='radio' id='radio_prof' name='radios_compte' value='prof' checked='true' />
                     <label for='radio_prof'> Enseignant </label></span>
                  </div>";

            // Affiche la liste des admins et des profs
            echo"<div id ='enseignant'>
                    <br>";

            // Récupère l'identifiant, le nom et le prénom des admins et des profs
            $resultat = pg_query ($dbcon, requete_tous_idadminprof_nomadminprof_prenomadminprof ());
            echo"
                <form action='majcompte.php' method='POST'>
                            <table class='liste'>
                        <thead>
                            <th class='identifiant'> Identifiant </th>
                            <th class='nom'> Nom </th> 
                            <th class='prenom'> Prenom </th> 
                            <th class='admin'> Admin </th> 
                            <th class='supprimer'> Supprimer </th>
                        </thead>
                        </table>
                <div class='scroll'>
                    <table class='liste'>
                        <tbody>";

            // Récupère l'identifiant, le nom et le prénom des admins et des profs
            $resultat = pg_query ($dbcon, requete_tous_idadminprof_nomadminprof_prenomadminprof ());

            while ($arr = pg_fetch_array ($resultat)) {
                $nomadminprof = $arr["nomadminprof"];
                $prenomadminprof = $arr["prenomadminprof"];
                $idadminprof = $arr["idadminprof"];
                echo"
            <tr>
                <td class='identifiant'>" . $idadminprof . "</td>
                <td class='nom'>" . $nomadminprof . "</td>
                <td class='prenom'>" . $prenomadminprof . "</td>";
                $resultatAdmin = pg_query ($dbcon, requete_si_admin ($idadminprof));
                $arrAdmin = pg_fetch_array ($resultatAdmin);
                $admin = $arrAdmin['admin'];
                if ($admin == 't')
                    echo"
                <td class='admin'><input type='checkbox' name='admin[]' value='" . $idadminprof . "' checked></td>";
                else
                    echo"
                <td class='admin'><input type='checkbox' name='admin[]' value='" . $idadminprof . "' ></td>";

                echo"
                        <td class='supprimer'><input type='checkbox' name='supprimer[]' value='" . $idadminprof . "'></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<br>
<input  class='boutonMAJ' value='Valider' type='submit'>
</form>
<form action='creercompte.php' method='POST'>
    <br>
    Créer compte enseignant
    <table>
        <tr>
            <td>Nom</td> 
            <td> <input name="nom" type="text" > </td> 
        </tr>
        <tr>
            <td>Prénom</td> 
            <td> <input name="prenom" type="text" > </td> 
        </tr>
        <tr>
            <td>Mot de passe</td> <td> 
                <input name="mdp" type="text" > </td> 
        </tr>
        <tr>
            <td>Langue de l'interface :</td> <td> <select name="langue"> 
                    <option value='fr'>Français</option>
                    <option value='en'>English</option>
                </select>  </td>
        </tr>
        <tr>
            <td colspan=2 style ="text-align: center"> <input type="checkbox" name="admin" value="1"> Admin </td>
        </tr>
    </table>
    <input class="boutonCenter" value="Ajouter" type="submit">

</form>
</div>
</div>
</body>
</html>
