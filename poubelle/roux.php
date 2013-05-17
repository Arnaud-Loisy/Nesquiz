<!--
   test.html
   
   Copyright 2013 Unknown <jeremy@localhost>
   
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
   MA 02110-1301, USA.
   
   
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>sans titre</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23" />
	
<style>

.radioBtns{float:left;padding:4px 0px 5px 0;font-size:13px;font-weight:bold;border:1px solid #ced1da;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;-khtml-border-radius:3px;-o-border-radius:3px;}
.radioBtns input{display:none;display:inline-block\9;}
.radioBtns label{padding:5px 15px;
  background: #f6f7f7;
  background: linear-gradient(top, #eceeef 0%,#f6f7f7 50%,#fefefe 100%); /* W3C */
  background: -moz-linear-gradient(top, #eceeef 0%,#f6f7f7 50%,#fefefe 100%); /* FF3.6+ */
  background: -webkit-linear-gradient(top, #eceeef 0%,#f6f7f7 50%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
  background: -ms-linear-gradient(top, #eceeef 0%,#f6f7f7 50%,#fefefe 100%); /* IE10+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eceeef', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */
  background: -o-linear-gradient(top, #eceeef 0%,#f6f7f7 50%,#fefefe 100%); /* Opera 11.10+ */
}

/* Chrome hack for padding */
@media screen and (-webkit-min-device-pixel-ratio:0){.radioBtns label{padding:4px 15px 6px 15px;}}

.radioBtns label:hover,.radioBtns input[type="radio"]:checked+label{
  background: #eef4f6;
  background: linear-gradient(top, #f5f8f9 0%,#eef4f6 50%,#dce8ec 100%); /* W3C */
  background: -moz-linear-gradient(top, #f5f8f9 0%,#eef4f6 50%,#dce8ec 100%); /* FF3.6+ */
  background: -webkit-linear-gradient(top, #f5f8f9 0%,#eef4f6 50%,#dce8ec 100%); /* Chrome10+,Safari5.1+ */
  background: -ms-linear-gradient(top, #f5f8f9 0%,#eef4f6 50%,#dce8ec 100%); /* IE10+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f8f9', endColorstr='#dce8ec',GradientType=0 ); /* IE6-9 */
  background: -o-linear-gradient(top, #f5f8f9 0%,#eef4f6 50%,#dce8ec 100%); /* Opera 11.10+ */
}

.radioBtns .radioYes label{border-right:1px solid #CED1DA;border-radius:3px 0px 0 3px;-moz-border-radius:3px 0px 0 3px;-webkit-border-radius:3px 0px 0 3px;-khtml-border-radius:3px 0px 0 3px;-o-border-radius:3px 0px 0 3px;}
.radioBtns .radioNo label{margin-left:-3px;border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;-webkit-border-radius:0 3px 3px 0;-khtml-border-radius:0 3px 3px 0;-o-border-radius:0 3px 3px 0;}
.radioBtns span:hover,.radioBtns label:hover{cursor:pointer}
.radioBtns .radioYes:hover label,.radioBtns .radioYes input[type="radio"]:checked+label{color:#3d9943}
.radioBtns .radioNo:hover label,.radioBtns .radioNo input[type="radio"]:checked+label{color:#ae2935}

/* IE FIX */
.radioBtns input{margin-top:-5px\9}
.radioBtns label{background:none\9;padding-bottom:7px\9;padding-left:2px\9;margin-bottom:-5px\9;}

</style>

</head>

<body>
    
<script type="text/javascript">
onload = function() {
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = document.getElementById('my_table').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            alert(this.rowIndex + 1);
        }
    }
}
</script>

<table id="my_table">
    
<tbody>
    <tr><td>first row</td></tr>
    <tr><td>second row</td></tr>
</tbody>
</table>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="radioBtns">
    <span><input id="php" type="radio" name="radio" checked="unchecked" value="php" /><label for="php">php</label></span>
    <span><input id="html" type="radio" name="radio" checked="unchecked" value="html" /><label for="html">html</label></span>
    <span><input id="css" type="radio" name="radio" checked="unchecked" value="css" /><label for="css">css</label></span>
</div>

</body>

</html>

