<?php
if(isset($_SESSION['id']) && ($_SESSION['admin']==1))
{
	echo"
<div id='menu'>
<ul>
   <li><a href='#'>Jane Smith</a></li>
   <li><a href='#'>Quiz</a></li>
   <li><a href='#'>Comptes<br>Utilisateurs</a></li>
   <li><a href='#'>Historique</a></li>
   <li><a href='#'>Matières</a></li>
   <li><a href='#'>Statistiques</a></li>   
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


