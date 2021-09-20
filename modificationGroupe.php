<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");


// MODIFIER UN GROUPE 

$action=$_REQUEST['action'];
$idGroupe=$_REQUEST['idGroupe'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailEtablissement) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifGroupe')
{
   $lgGroupe=obtenirDetailGroupe($connexion, $idGroupe);
   foreach($lgGroupe as $row)
   $nomGroupe=$row['nomGroupe'];
   $nombrePersonnes=$row['nombrePersonnes'];
   $ligue = $row['ligue'];
   $nompays = $row['nomPays'];
   $hebergement = $row['hebergement'];
}
else
{
   $idGroupe=$_REQUEST['idGroupe']; 
   $nomGroupe=$_REQUEST['nomGroupe']; 
   $nombrePersonnes=$_REQUEST['nombrePersonnes'];
   $ligue=$_REQUEST['ligue'];
   $nompays=$_REQUEST['nompays'];
   $hebergement=$_REQUEST['hebergement'];

   verifierDonneesGroupeM($connexion, $idGroupe, $nomGroupe, $nombrePersonnes, $ligue, $nompays, $hebergement);      
   if (nbErreurs()==0)
   {        
      modifierGroupe($connexion, $idGroupe, $nomGroupe, $nombrePersonnes, $ligue, $nompays, $hebergement);
   }
}

echo "
<form method='POST' action='modificationGroupe.php?'>
   <input type='hidden' value='validerModifGroupe' name='action'>
   <table width='85%' cellspacing='0' cellpadding='0' align='center' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>$nomGroupe ($idGroupe)</td>
      </tr>
      <tr>
         <td><input type='hidden' value='$idGroupe' name='idGroupe'></td>
      </tr>";
      
      echo '
      <tr class="ligneTabNonQuad">
         <td> Nom du groupe*: </td>
         <td><input type="text" value="'.$nomGroupe.'" name="nomGroupe" size="50" 
         maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre de personne*: </td>
         <td><input type="float" value="'.$nombrePersonnes.'" name="nombrePersonnes" 
         size="10" maxlength="10"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> ligue*: </td>
         <td><input type="text" value="'.$ligue.'" name="ligue" 
         size="35" maxlength="35"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom du pays*: </td>
         <td><input type="text" value="'.$nompays.'" name="nompays" size="35" 
         maxlength="35"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> hebergement(O/N)*: </td>
         <td><input type="text" value="'.$hebergement.'" name="hebergement" size ="2" 
         maxlength="1"></td>
      </tr>
          
   </table>';
   
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
if ($action=='validerModifGroupe')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification du groupe a été effectuée</center></h5>";
   }
}

?>