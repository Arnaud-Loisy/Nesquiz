<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="./styles/theme.css" />

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=830">
</head>
<body>
    <div id="page">
    <?php
    session_start();
    include './accueil/menu.php';
    /*Page d'acceuil avec un champ ID et Mot de passe 
     * si l'un des deux est faux on affiche une erreur au client
     * le traitement de cette pagre s'appelle "connexion"
     */
    if(isset($_SESSION["erreur_log"])){
        echo"Identifiant et/ou Mot de passe erroné";
          unset($_SESSION["erreur_log"]);  
       }    
    if (isset($_SESSION["id"])){
      header("Location:accueil/accueil.php");
    }
    ?>
     <!--Formulaire que fait appel a "connexion" et qui prend le login
      et le mot de passe en paramètre-->
   <br>
        <br>
<form action='accueil/connexion.php' method='POST'>
	<table style="margin: auto">
		<tr>
			<td>Identifiant :</td> <td><input name="login" type="text" > </td> </tr>
		<tr>
			<td>Mot de passe :</td>  <td><input name="mdp" type ="password"> </td> </tr>
	</table>
	<input class="boutonCenter" value="Connexion" type="submit">
</form>
    </div>
</body>
<html>
