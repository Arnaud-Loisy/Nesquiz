<?php
include 'admin/secret.php';
echo "zoubidou bidouu!";
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection failed<br>";
}else
	echo "connection not failed<br>";

$result = pg_query($dbcon, "SELECT nom FROM test");
$arr = pg_fetch_array($result);
var_dump($arr);
echo "<br>";
$arr = pg_fetch_array($result);
var_dump($arr);
?>