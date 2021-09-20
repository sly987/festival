<?php
include("connexion-PDO.php");
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

// CRÉER UN GROUPE
 
$action=$_REQUEST['action'];

// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action=='demanderCreGr') 
{  
   $idGroupe='';
   $nomGroupe='';
   $nombrePersonnes='';
   $ligue='';
   $nompays='';
   $hebergement='';
}
else
{
   $idGroupe=$_REQUEST['idGroupe']; 
   $nomGroupe=$_REQUEST['nomGroupe']; 
   $nombrePersonnes=$_REQUEST['nombrePersonnes'];
   $ligue=$_REQUEST['ligue'];
   $nompays=$_REQUEST['nompays'];
   $hebergement=$_REQUEST['hebergement'];
   verifierDonneesGrC($connexion, $idGroupe, $nomGroupe, $nombrePersonnes, $ligue, $nompays, 
   $hebergement);

   if (nbErreurs()==0)
   {        
      creerGroupe($connexion, $idGroupe, $nomGroupe, $nombrePersonnes, $nompays,  
      $hebergement, $ligue);
   }
}
//permet d'obtenir l'ID du prochain groupe à créer
$idGroupe = obtenirIdGroupe($connexion);
$idGroupe = str_replace("g", "", $idGroupe);
$idGroupe = (int) $idGroupe + 1;

 



echo "
<form method='POST' action='creationGroupe.php?'>
   <input type='hidden' value='validerCreGr' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>Nouvau groupe</td>
      </tr>";
     
      echo '
      <tr class = "ligneTabNonQuad">
         <td> ID du groupe*:</td>
         <td>g0'.$idGroupe.'<input type = "hidden" name = "idGroupe" value = "g0'.$idGroupe.'" /></td>
      <tr class="ligneTabNonQuad">
         <td> Nom du groupe*: </td>
         <td><input type="text" value="'.$nomGroupe.'" name="nomGroupe" size="50" 
         maxlength="45" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre de personnes*: </td>
         <td><input type="text" value="'.$nombrePersonnes.'" name="nombrePersonnes" 
         size="50" maxlength="45" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ligue*: </td>
         <td><input type="text" value="'.$ligue.'" name="ligue" 
         size="4" maxlength="5" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom du pays*: </td>
         <td><input type="text" value="'.$nompays.'" name="nompays" size="40" 
         maxlength="35" required></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Hébergement*: </td>
         <td><input type="text" value="'.$hebergement.'" name="hebergement" size ="20" 
         maxlength="10" required></td>
      </tr>';
     
   
   echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
      <tr>
      <td colspan='2' align='center'><a href='listeGroupe.php'>Retour</a>
         </td>
      </tr>
   </table>
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerCreGr')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La création du groupe a été effectuée</center></h5>";
   }
}

?>
