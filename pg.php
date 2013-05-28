<?php
include 'admin/secret.php';
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection failed<br>";
}else
	echo "connection BDD OK <br>";

$result = pg_query($dbcon, "SELECT nometudiant FROM etudiants");
$arr = pg_fetch_array($result);
var_dump($arr);
echo "<br>";
$arr = pg_fetch_array($result);
var_dump($arr);
?>