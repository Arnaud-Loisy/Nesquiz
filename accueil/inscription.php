<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />

<title>Inscription</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
        <?php
        session_start();
        include '../accueil/menu.php';
        
        
        if(isset( $_SESSION["erreur_inscription_mdp"])){
            echo"<br>Erreur:Le mot de passe et sa confirmation sont différents.<br>";
            unset( $_SESSION["erreur_inscription_mdp"]);
        }
         if(isset( $_SESSION["erreur_inscription_numero_etu"])){
            echo"<br>Erreur:Ce numéro étudiant possède déjà un compte.<br>";
            unset( $_SESSION["erreur_inscription_numero_etu"]);
        }
        if (isset( $_SESSION["erreur_inscription_incomplet"])){
             echo"<br>Erreur:Veuillez remplir tous les champs du formulaire.<br>";
                unset( $_SESSION["erreur_inscription_incomplet"]);
        }
        if (isset( $_SESSION["erreur_longeur_champ_inscription_nom"])){
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'nom' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_nom"]);
            }
                if (isset( $_SESSION["erreur_longeur_champ_inscription_prenom"])){
                       $str= "juiu'huhi'uhihih";
                       $fu="";
                       $test=strpos($str,$fu);
                       echo $test;
            echo htmlentities($str,ENT_NOQUOTES);
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'prenom' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_prenom"]);
            }
                if (isset( $_SESSION["erreur_longeur_champ_inscription_etu"])){
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'numero etudiant' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_etu"]);
            }
                if (isset( $_SESSION["erreur_longeur_champ_inscription_promotion"])){
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'promotion' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_promotion"]);
            }
                if (isset( $_SESSION["erreur_longeur_champ_inscription_mdp"])){
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'Mot De Passe' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_mdp"]);
            }
                if (isset( $_SESSION["erreur_longeur_champ_inscription_cmdp"])){
            echo"<br>Erreur:La longueur maximale des champs est de 32 caratères. <br>";
            echo "<br>Veuillez réduire le champ 'Confirmation Mot de Passe' qui est  trop long.<br>";
                unset( $_SESSION["erreur_longeur_champ_inscription_cmdp"]);
            }
        if (isset ( $_SESSION["erreur_num_etu"])){
             echo "<br>Erreur: Le Numéro Etudiant ne  doit contenir que des nombres<br>";
             unset( $_SESSION["erreur_num_etu"]);
        }
        if (isset ($_SESSION["erreur_promotion"])){
             echo "<br>Erreur: La Promotion ne  doit contenir que des nombres<br>";
             unset( $_SESSION["erreur_promotion"]);
        }
        ?>
        <br>
        <br>
        <form action='trait_inscri.php' method='POST'>
        <table style="margin: auto">
        	<tr>
			<td>Nom :</td> <td> <input name="nom" type="text" > </td> </tr>
		<tr>
        		<td>Prénom :</td> <td> <input name="prenom" type="text" > </td> </tr>
        	<tr>	
        		<td>N°Etudiant (votre futur Login):</td> <td><input name="numero_etu" type="text" > </td> </tr>
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
	<input class="boutonCenter" value="S'inscrire" type="submit"> 
 	</form>
  </div>
    
    </body>
<html>
