<html>
<head>
<title>Formualire</title>
</head>
<body>
<?php

if (!empty($_POST)) {
    echo '<p>Le bouton enfoncé est le bouton ';
    if (isset($_POST['bouton2'])) {
        echo '2';
    } elseif (isset($_POST['bouton3'])) {
        echo '3';
    } else {
        // par défaut, c'est le bouton 1, même si on ne clique pas/
        echo '1';
    }
    echo '</p>';
    echo '<p>Le champ texte contient : ', $_POST['champ'], '</p>';
}

?><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<p><input type="text" name="champ" /></p>
<p><input type="submit" name="bouton1" value="Le bouton 1" />&nbsp;
<input type="submit" name="bouton2" value="Le bouton 2" />&nbsp;
<input type="submit" name="bouton3" value="Le bouton 3" /></p>
</form>