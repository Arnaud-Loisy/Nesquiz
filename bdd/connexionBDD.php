<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include '../admin/secret.php';

function connexionBDD()
{
	global $host;
	global $login;
	global $password;
	global $db;
	
	$result = pg_connect("host=$host user=$login password=$password dbname=$db");
	return $result;
}

?>
