<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Profil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
       <div id="page">

<?php
include '../accueil/menu.php';
include '../admin/secret.php';
session_start();


     if(isset($_SESSION["mdpfail"])){
          echo"Erreur:L'ancien mot de passe n'est pas bon.<br>";
            unset( $_SESSION["mdpfail"]);
        }
     if(isset($_SESSION["mdpchfail"])){
          echo"Erreur:Veuillez bien remplir les deux champs pour le changement de mot de passe.<br>";
            unset( $_SESSION["mdpchfail"]);
        }   
     if(isset($_SESSION["languechok"])){
          echo"votre changement à été effectué avec succès.<br>";
            unset( $_SESSION["languechok"]);
        }             
        if(isset($_SESSION["mdpchok"])){
          echo"votre changement à été effectué avec succès.<br>";
            unset( $_SESSION["mdpchok"]);
        }             
        echo"<br><br>";
        $id=$_SESSION["id"];
        $nom=$_SESSION ["nom"];
        $prenom=$_SESSION ["prenom"];
     
        echo"Identifiant:". $id."<br>";
        echo"Nom:".$nom."<br>";
        echo"Prénom:".$prenom."<br>";
        echo"<br><br><br>";
        echo"Changer la langue de l'interface <br>";
        echo"<br> <form action='trait_profil.php' method='POST'>
                 <table style='margin: auto'>
                  <td>Langue de l'interface :</td> <td> <select name='langue'> 
                                 <option value='fr'>Français</option>
                                 <option value='en'>English</option>
                                </select>  </td> </tr>  </table>";
       
        echo"<br> Changer de mot de passe <br>";
        echo'Ancien mot de passe <input name="oldmdp" type ="password"> <br>';
        echo'Nouveau mot de passe <input name="newmdp" type ="password"> <br> ';
        echo'<input class="boutonCenter" value="Valider les changements appliqués à votre compte" type="submit">';
                
        echo"</form>";
?>
       </div>
    
    </body>
</html>
