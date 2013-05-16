<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Inscription</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
        <?php
        session_start();
        include '../accueil/menu.php';
        if(isset( $_SESSION["erreur_inscription_mdp"])){
            echo"Erreur:Le mot de passe et sa confirmation sont différents.<br>";
            unset( $_SESSION["erreur_inscription_mdp"]);
        }
         if(isset( $_SESSION["erreur_inscription_numero_etu"])){
            echo"Erreur:Ce numéro étudiant possède déjà un compte.<br>";
            unset( $_SESSION["erreur_inscription_numero_etu"]);
        }
        if (isset( $_SESSION["erreur_inscription_incomplet"])){
             echo"Erreur:Veuillez remplir tous les champs du formulaire.<br>";
                unset( $_SESSION["erreur_inscription_incomplet"]);
        }
        if (isset( $_SESSION["erreur_longeur_champ_inscription"])){
            echo"Erreur:La longueur maximale des champs est de 32 caratères. <br>   Veuillez réduire les champs trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription"]);
            }
        ?>
        <br>
        <br>
        <form action='trait_inscri.php' method='POST'>
        <table>
        	<tr>
			<td>Nom :</td> <td> <input name="nom" type="text" > </td> </tr>
		<tr>
        		<td>Prénom :</td> <td> <input name="prenom" type="text" > </td> </tr>
        	<tr>	
        		<td>N°Etudiant :</td> <td><input name="numero_etu" type="text" > </td> </tr>
        	<tr>
        		<td>Promotion :</td> <td> <input name="promotion" type="text" > </td> </tr>
        	<tr>
        		<td>Mot de passe :</td> <td> <input name="mdp" type ="password"> </td> </tr>
        	<tr>
        		<td>Confirmer Mot de passe :</td> <td> <input name="cmdp" type ="password"> </td> </tr>
        	<tr>
        		<td>Langue de l'interface :</td> <td> <select name="langue"> 
                                 <option value='fr'>Français</option>
                                 <option value='en'>English</option>
                                </select>  </td> </tr>
        </table>
	<input class="bouton" value="S'inscrire" type="submit"> 
 	</form>
  </div>
    
    </body>
<html>
