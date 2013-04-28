<!doctype html>
 
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>Session</title>
  <link rel="stylesheet" href="..\styles\jquery-ui.css" />
  <script src="..\scripts\jquery-2.0.0.js"></script>
  <script src="..\scripts\jquery-ui.js"></script>
  <link rel="stylesheet" href="..\styles\theme.css" />
  <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" rel="stylesheet" type="text/css"/>
  
  
  
  <script>
  $(function() {
    $( "#selectable" ).selectable({
      stop: function() {
        var result = $( "#select-result" ).empty();
        $( ".ui-selected", this ).each(function() {
          var index = $( "#selectable li" ).index( this );
          result.append( " #" + ( index + 1 ) );
        });
      }
    });
  });
  </script>
  <?php	
  	include '../accueil/menu.php';
  ?>
</head>
<body>
	<div id='page'>
	
<h1 class="question">Que veux dire le sigle ARP ? :</h1>
<ol id="selectable">
  <li class="ui-widget-content">Address Research Protocol</li>
  <li class="ui-widget-content">Address Resolution Protocol</li>
  <li class="ui-widget-content">Addressing Research Protocol</li>
  <li class="ui-widget-content">Addressing Resolution Protocol</li> 
</ol>

     <input class="bouton" type="submit" value="Précédent" />
     <input class="bouton" type="submit" value="Suivant" />
 </div>
</body>
</html>


