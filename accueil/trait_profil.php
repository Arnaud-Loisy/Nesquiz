<?php
include '../admin/secret.php';
session_start();
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";
 
if ((isset($_SESSION["statut"]))&& ($_SESSION["statut"]=="etu")){
 $id=$_SESSION["id"];
        $result_etu= pg_query($dbcon, "SELECT langueEtudiant, mdpetudiant FROM Etudiants WHERE idEtudiant= $id;");
             $arr = (pg_fetch_array($result_etu));
                    $langue=$arr["langueEtudiant"];
                    $mdph=$arr["mdpetudiant"];
                                                         
            
  if((isset($_POST["oldmdp"])) && (isset($_POST["newmdp"])) ){
      $mdphold=md5($_POST["oldmdp"]);
      $mdphnew=md5($_POST["newmdp"]);
       if($mdph==$mdphold){
          pg_query($dbcon, "UPDATE Etudiants SET mdpEtudiant = $mdphnew WHERE idEtudiant=$id;");   
          $_SESSION["mdpchok"]=1;
       }
       else {
           $_SESSION["mdpfail"]=1;
       }
  }
   else {
           $_SESSION["mdpchfail"]=1;
       }
    
  if(isset($_POST["langue"])){
      $langue=$_POST["langue"];
  
     pg_query($dbcon, "UPDATE Etudiants SET langueEtudiant = $langue WHERE idEtudiant=$id;");
      $_SESSION["languechok"]=1;
  }
  
}
if (((isset($_SESSION["statut"]))&& ($_SESSION["statut"]=="admin")) || ((isset($_SESSION["statut"]))&& ($_SESSION["statut"]=="prof")) ){
 $id=$_SESSION["id"];
        $result_adm= pg_query($dbcon, "SELECT langueAdminProf, mdpadminprof FROM AdminProfs WHERE idAdminProf = $id;");
             $arr = (pg_fetch_array($result_adm));
                    $langue=$arr["langueAdminProf"];
                    $mdph=$arr["mdpadminprof"];
                                                         
            
  if((isset($_POST["oldmdp"])) && (isset($_POST["newmdp"])) ){
      $mdphold=md5($_POST["oldmdp"]);
      $mdphnew=md5($_POST["newmdp"]);
       if($mdph==$mdphold){
          pg_query($dbcon, "UPDATE AdminProfs SET mdpAdminProf = $mdphnew WHERE idAdminProf=$id;"); 
          $_SESSION["mdpchok"]=1;
       }
       else {
           $_SESSION["mdpfail"]=1;
       }
  }
  else {
           $_SESSION["mdpchfail"]=1;
       }
  
  if(isset($_POST["langue"])){
      $langue=$_POST["langue"];
  
     pg_query($dbcon, "UPDATE AdminProfs SET langueAdminProf = $langue WHERE idAdminProf=$id;");
       $_SESSION["languechok"]=1;
  }
          
}
    header('Location:./profil.php');

?>