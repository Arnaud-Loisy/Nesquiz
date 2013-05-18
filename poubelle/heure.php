<?php
var_dump(timezone_abbreviations_list());
date_default_timezone_set("Europe/Paris");
echo(date("Y-m-d H:i",time()));
?>