<?php
if (isset($_SESSION['id']) && ($_SESSION['statut'] == "admin")) {
	echo "
<div id='menu'>
<ul>
   <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../admin/compte.php'>Mon<br>Profil</a></li>
   <li><a href='../quiz/gestionquiz.php'>Quiz</a></li>
   <li><a href='../admin/compte.php'>Comptes<br>Utilisateurs</a></li>
   <li><a href='../admin/historique.php'>Historique</a></li>
   <li><a href='../admin/matieres.php'>Matières</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
} elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "prof")) {
	echo "
<div id='menu'>
<ul>
  <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../admin/compte.php'>Mon<br>Profil</a></li>
   <li><a href='../quiz/gestionquiz.php'>Quiz</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
} elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "etu")) {
	echo "
<div id='menu'>
<ul>
	<li><a href='../index.php'>Accueil</a></li>
	<li><a href='../admin/compte.php'>" . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</a></li>
	<li><a href='../etudiant/listequiz.php'>Quiz</a></li>
	<li><a href='../etudiant/notes.php'>Notes</a></li> 
	<li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
} else {
	echo "
<div id='menu'>
<ul>
	<li><a href='accueil/inscription.php'>S'inscrire</a></li>
	<li><a href='../index.php'>Se connecter</a></li>  
</ul>
</div>";
}
?>

