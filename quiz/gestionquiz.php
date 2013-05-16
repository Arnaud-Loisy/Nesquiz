<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta charset="utf-8" />
<title>Gestion des Quiz</title>
<link rel="stylesheet" href="../styles/theme.css" />
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>



  <link rel="stylesheet" href="../styles/jquery-ui.css"/>
  <script src="../scripts/jquery-2.0.0.js"></script>
  <script src="../scripts/jquery-ui.js"></script>
  <link rel="stylesheet" href="../styles/theme.css"/>
  
  <link rel="stylesheet" href="../styles/jquery.appendGrid-1.1.0.css"/>
  <script type="text/javascript" src="../scripts/flexigrid.pack.js"></script>



</head>
<body>
<div id='page'>
<?php

session_start();
include '../accueil/menu.php';
include '../admin/secret.php';

$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}
else
    {
	echo "connection BDD succes <br>";

	$result= pg_query($dbcon, "SELECT libellequestion, tempsquestion
                                        FROM questions, matieres
                                        WHERE questions.idmatiere = matieres.idmatiere
                                        AND matieres.idmatiere = 1;");

        echo "<select name='liste_questions'>";
        
        $i=0;
        while($row = pg_fetch_array($result)){
            $libelle=$row["libellequestion"];
            echo "<option>$libelle</option>";
            $i++;
        }
        echo "</select>";
    }

echo "<form action ='/session/publication.php' method='POST'>";
echo "<input class='bouton' type='submit' value='Publier'>";
echo "</form>";

?>   
    

<script type="text/javascript">
$("#flex1").flexigrid({
	url: 'post2.php',
	dataType: 'json',
	colModel : [
		{display: 'ISO', name : 'iso', width : 40, sortable : true, align: 'center'},
		{display: 'Name', name : 'name', width : 180, sortable : true, align: 'left'},
		{display: 'Printable Name', name : 'printable_name', width : 120, sortable : true, align: 'left'},
		{display: 'ISO3', name : 'iso3', width : 130, sortable : true, align: 'left', hide: true},
		{display: 'Number Code', name : 'numcode', width : 80, sortable : true, align: 'right'}
		],
	buttons : [
		{name: 'Add', bclass: 'add', onpress : test},
		{name: 'Delete', bclass: 'delete', onpress : test},
		{separator: true}
		],
	searchitems : [
		{display: 'ISO', name : 'iso'},
		{display: 'Name', name : 'name', isdefault: true}
		],
	sortname: "iso",
	sortorder: "asc",
	usepager: true,
	title: 'Countries',
	useRp: true,
	rp: 15,
	showTableToggleBtn: true,
	width: 700,
	height: 200
});   
</script>    
    
    
</div>
</body>
</html>
