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
        ?>
        <br>
        <br>
        <form action='trait_inscri.php' method='POST'>
	Nom : <input name="nom" type="text" ><br>
        Prénom : <input name="prenom" type="text" ><br>
        N°Etudiant : <input name="numero_etu" type="text" ><br>
        Promotion: <input name="promotion" type="text" ><br>
        Mot de passe: <input name="mdp" type ="password"><br>
        Confirmer Mot de passe : <input name="cmdp" type ="password"><br>
        Langue de l'interface: <select name="langue">
                                 <option value='fr'>Français</option>
                                 <option value='en'>English</option>
                                </select><br>
        
	<input class="bouton" value="S'inscrire" type="submit"> 
 
  </div>
    
    </body>
<html>