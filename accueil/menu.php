<?php
if(isset($_SESSION['id']) && ($_SESSION['statut']=="admin"))
{
	echo"
<div id='menu'>
<ul>
   <li><a href='#'>".$_SESSION['prenom']." ".$_SESSION['nom']."</a></li>
   <li><a href='#'>Quiz</a></li>
   <li><a href='#'>Comptes<br>Utilisateurs</a></li>
   <li><a href='#'>Historique</a></li>
   <li><a href='#'>Matières</a></li>
   <li><a href='#'>Statistiques</a></li>   
   <li><a href='#'>Déconnexion</a></li>
</ul>
</div>";
}elseif(isset($_SESSION['id']) && ($_SESSION['statut']=="prof"))
	{
		echo"
<div id='menu'>
<ul>
   <li><a href='#'>".$_SESSION['prenom']." ".$_SESSION['nom']."</a></li>
   <li><a href='#'>Quiz</a></li>
   <li><a href='#'>Statistiques</a></li>   
   <li><a href='#'>Déconnexion</a></li>
</ul>
</div>";
	}
elseif (isset($_SESSION['id']) && ($_SESSION['statut']=="etu")) 
{
	echo"
<div id='menu'>
<ul>
   <li><a href='#'>".$_SESSION['prenom']." ".$_SESSION['nom']."</a></li>
   <li><a href='#'>Quiz</a></li>
   <li><a href='#'>Notes</a></li> 
   <li><a href='#'>Déconnexion</a></li>
</ul>
</div>";
}
else {
	echo"
<div id='menu'>
<ul>
   <li><a href='index.php'>Se connecter</a></li>  
   <li><a href='accueil/inscription.php'>S'inscrire</a></li>
</ul>
</div>";
}


?>

