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
session_start();
include '../accueil/menu.php';
include '../admin/secret.php';


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

        $id=$_SESSION["id"];
        $nom=$_SESSION ["nom"];
        $prenom=$_SESSION ["prenom"];
        
        echo"<br>";
        echo"<table style='margin: auto'>
                <tr>
                    <td>Identifiant  </td>
                    <td style='text-align: center'>". $id."</td></tr>
                <tr>
                    <td>Nom</td> 
                    <td>".$nom."</td></tr>
                <tr>
                    <td>Prénom</td>
                    <td>".$prenom."</td></tr>       
            </table>
            <br> 
            <form action='trait_profil.php' method='POST'>
                <table style='margin: auto'>
                    <tr>
                        <td colspan=2 >Changer la langue de l'interface </td></tr>                
                    <tr>
                        <td>Langue de l'interface :</td> 
                        <td> <select name='langue'> 
                                 <option value='fr'>Français</option>
                                 <option value='en'>English</option>
                                </select>  </td> </tr>";
       
        echo"           <tr>
                            <td colspan=2 >Changer de mot de passe</td></tr>";
        echo"           <tr>
                            <td>Ancien mot de passe</td> <td><input name='oldmdp' type ='password'></td></tr>";
        echo"           <tr>
                            <td>Nouveau mot de passe</td> <td><input name='newmdp' type ='password'></td></tr></table>";
        echo"           <input class='boutonCenter' value='Valider les changements' type='submit'>";
        echo"       </form>";
?>
       </div>
    
    </body>
</html>
