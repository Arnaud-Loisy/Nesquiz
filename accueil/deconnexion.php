<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["statut"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["erreur_log"]);

header('Location:../index.php');
?>
