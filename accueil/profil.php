<!doctype html>

<html>
    
    <head>
        <link rel="stylesheet" href="../styles/theme.css" />

        <title>Profil</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=830">
    </head>
<body>
       <div id="page">

<?php
session_start();
include '../accueil/menu.php';
include '../admin/secret.php';

		if (!isset($_SESSION["id"])) {
				header('Location:../index.php'); //si non connecté.
			}
		/*SI les variable de session d'erreur sont SET on affiche les 
                 * erreur correspondantes pour l'utilisateur
                  */
     if(isset($_SESSION["mdpfail"])){
         echo"<br>";
         echo"Erreur: L'ancien mot de passe n'est pas bon.<br>";
            unset( $_SESSION["mdpfail"]);
        }
    
          if (isset($_SESSION["languechok"])){
               echo"<br>Votre changement à été effectué avec succès.<br>";
               unset( $_SESSION["languechok"]);
          }
              
              
              
               if((isset($_SESSION["mdpchfail"]))) {
          echo"<br>";
          echo"Erreur: Veuillez bien remplir les trois champs pour le changement de mot de passe.<br>";
            unset( $_SESSION["mdpchfail"]);
           
            }
           
     if((isset($_SESSION["mdpchok"]))){
          echo"<br>Votre changement à été effectué avec succès.<br>";
           unset( $_SESSION["mdpchok"]);
        }
           if(isset($_SESSION["mdpconffail"])){
                echo"<br>";
                echo"Erreur: Différence entre la confirmation et le mot de passe.<br>";
                unset($_SESSION["mdpconffail"]);
           }
         
           
       
        $id=$_SESSION["id"];
        $nom=$_SESSION ["nom"];
        $prenom=$_SESSION ["prenom"];
        /*On créer un formulaire ou on fait apparaitre certaines informations relatives
         * au profil de l'utilisateur (nom, prénom, son identifiant) et on lui laisse
         * la possibilitée de changer la langue de son interface (par encore implémenté)
         * et de modifier son mot de passe. 
         */
        echo"<br>
            <form action='trait_profil.php' method='POST'>
                <table style='margin: auto'>
                    <tr>
                        <td>Identifiant</td>
                        <td>". $id."</td>
                    </tr>
                    <tr>
                        <td>Nom</td> 
                        <td>".$nom."</td>
                    </tr>
                    <tr>
                        <td>Prénom</td>
                        <td>".$prenom."</td>
                    </tr>       
                                
                    <tr>
                        <td>Langue de l'interface </td> 
                        <td> <select name='langue'> 
                                 <option value='fr'>Français</option>
                                 <option value='en'>English</option>
                                </select>  </td> 
                    </tr>
                    <tr>
                        <td colspan=2 >Changer de mot de passe</td></tr>
                    <tr>
                        <td>Ancien mot de passe</td> 
                        <td><input name='oldmdp' type ='password'></td>
                    </tr>
                    <tr>
                        <td>Nouveau mot de passe</td> 
                        <td><input name='newmdp' type ='password'></td>
                    </tr>
                    <tr>
                        <td> Confirmation nouveau mot de passe</td> 
                        <td><input name='cnewmdp' type ='password'></td>
                    </tr>
                </table>
                <input class='boutonCenter' value='Valider les changements' type='submit'>
                </form>";
?>
       </div>
    
    </body>
</html>
