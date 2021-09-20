
<?php
include("connexion-PDO.php");
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival


$req = resultatGroupe($connexion, $_POST['searchGroupe']);
$rsGroupe = $connexion-> query($req);
$lgGroupe = $rsGroupe->fetchAll();
if($lgGroupe == False)
{
	echo "<h1>Il n'y a aucun groupe correspondant à ". $_POST['searchGroupe']."</h1>";
}
else
{

	echo "
<table width='70%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='4'>Groupe</td>
   </tr>";
     echo "
   <tr class='ligneTabNonQuad'>
      <td colspan='4'><a href='creationGroupe.php?action=demanderCreGr'>
      Création d'un groupe</a ></td>
  </tr>";
   foreach ($lgGroupe as $row)
   {
      $idGroupe=$row['idGroupe'];
      $nomGroupe=$row['nomGroupe'];
      echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$nomGroupe</td>
         
         <td width='16%' align='center'> 
         <a href='detailGroupe.php?idGroupe=$idGroupe'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationGroupe.php?action=demanderModifGroupe&amp;idGroupe=$idGroupe'>
         Modifier</a></td>";
      	
         // S'il existe déjà des attributions pour l'établissement, il faudra
         // d'abord les supprimer avant de pouvoir supprimer l'établissement
			if (!existeAttributionsGroupe($connexion, $idGroupe))
			{
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionGroupe.php?action=demanderSupprGroupe&amp;idGroupe=$idGroupe'>
            Supprimer</a></td>";
        	 }
         	else
         	{
         		$nbChambre = obtenirNbGroupeOccup($connexion, $idGroupe);
            	echo "
            	<td width='16%'>&nbsp ".$nbChambre." chambres occupés; </td>";          
			}
			echo "
      </tr>";
      
   }  
   echo '</table>';
}
?>