<?php
//Affichage du menu admin avec un quiz en cours
if(isset($_SESSION['id']) && ($_SESSION['statut'] == "admin") && isset($_SESSION["idquiz"]))
{
		echo "
<div id='menu'>
<ul>
   <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../accueil/profil.php'>Mon<br>Profil</a></li>
   <li><a href='../admin/compte.php'>Comptes<br>Utilisateurs</a></li>
   <li><a href='../session/supervision.php'>Quiz</a></li>
   <li><a href='../session/publication.php'>Publication</a></li>
   <li><a href='../admin/matieres.php'>Matières</a></li>
   <li><a href='../admin/historique.php'>Historique</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
}
//Affichage du menu admin 
elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "admin")) {
	echo "
<div id='menu'>
<ul>
   <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../accueil/profil.php'>Mon<br>Profil</a></li>
   <li><a href='../admin/compte.php'>Comptes<br>Utilisateurs</a></li>
   <li><a href='../quiz/gestionquiz.php'>Quiz</a></li>
   <li><a href='../session/publication.php'>Publication</a></li>
   <li><a href='../admin/matieres.php'>Matières</a></li>
   <li><a href='../admin/historique.php'>Historique</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";}
//Affichage du menu professeur avec un quiz en cours
elseif(isset($_SESSION['id']) && ($_SESSION['statut'] == "prof") && isset($_SESSION["idquiz"]))
{
		echo "
<div id='menu'>
<ul>
  <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../accueil/profil.php'>Mon Profil</a></li>
   <li><a href='../session/supervision.php'>Quiz en cours</a></li>
   <li><a href='../session/publication.php'>Publication</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
//Affichage du menu professeur 
} elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "prof")) {
	echo "
<div id='menu'>
<ul>
  <li><a href='../index.php'>Accueil</a></li>
   <li><a href='../accueil/profil.php'>Mon Profil</a></li>
   <li><a href='../quiz/gestionquiz.php'>Quiz</a></li>
   <li><a href='../session/publication.php'>Publication</a></li>
   <li><a href='../admin/statistiques.php'>Statistiques</a></li>   
   <li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
//Affichage du menu etudiant avec une session en cours
} elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "etu") && isset($_SESSION['idSession'])) {
	echo "
<div id='menu'>
<ul>
	<li><a href='../index.php'>Accueil</a></li>
	<li><a href='../accueil/profil.php'>Mon Profil</a></li>
	<li><a href='../session/session.php'>Quiz en cours</a></li>
	<li><a href='../etudiant/notes.php'>Notes</a></li> 
	<li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
//Affichage du menu etudiant
}elseif (isset($_SESSION['id']) && ($_SESSION['statut'] == "etu")) {
	echo "
<div id='menu'>
<ul>
	<li><a href='../index.php'>Accueil</a></li>
	<li><a href='../accueil/profil.php'>Mon Profil</a></li>
	<li><a href='../etudiant/listequiz.php'>Quiz</a></li>
	<li><a href='../etudiant/notes.php'>Notes</a></li> 
	<li><a href='../accueil/deconnexion.php'>Déconnexion</a></li>
</ul>
</div>";
//affichage du menu non connecté
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

