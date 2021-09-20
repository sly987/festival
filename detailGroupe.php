<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");


$idGroupe=$_REQUEST['idGroupe'];  

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgGroupe=obtenirDetailGroupe($connexion, $idGroupe);
foreach ($lgGroupe as $row)
{
$nomGroupe=$row['nomGroupe'];
$nombrePersonnes=$row['nombrePersonnes'];
$ligue = $row['ligue'];
$nomPays = $row['nomPays'];
$hebergement = $row['hebergement'];
}
echo "
<table width='60%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'>$nomGroupe</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Id: </td>
      <td>$idGroupe</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nombre de personnes: </td>
      <td>$nombrePersonnes</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nom du pays: </td>
      <td>$nomPays</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> hebergement(O/N): </td>
      <td>$hebergement</td>
   </tr>
</table>
<table align='center'>
   <tr>
      <td align='center'><a href='listeGroupe.php'>Retour</a>
      </td>
   </tr>
</table>";
?>
