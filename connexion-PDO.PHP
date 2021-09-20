<?php
 $hote="localhost";
 $login="festival";
   $mdp="secret";

   try{
      $connexion = new PDO("mysql:host=$hote;dbname=festival", $login, $mdp);
      $connexion->exec("set names utf8");
      return $connexion;
   }
   catch(PDOException $e){
      echo "Erreur :" . $e->getMessage();
      die();
   }

?>