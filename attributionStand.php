<?php
include("connexion-PDO.php");
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival



$req=obtenirStand();
$rsStand=$connexion->query($req);
$lgStand=$rsStand->fetchAll();
$i=0;
echo '<table width = 40% align = "center">
	<form method ="POST" action = "listeStand.php">
	<tr>
	<td width = 50% align = "right"><input type = "search" name = "search"/></td>
	<td><input type = "submit" align = "left" name = "chercher" value ="chercher" /></td> </tr></table></form></br>';
echo
"<table class = 'tabQuadrille' width = 40% cellspacing='0' cellpadding='0' align = 'center'>
	<tr class = 'enTeteTabQuad'>
	<td align = 'left' width = 70%> <strong>groupe</strong></td>
	<td align = 'center'> <strong>avoir un stand</Strong></td></tr>";

foreach ($lgStand as $row)
{
	$nomGroupe = $row['nomGroupe'];
	$stand = $row['stand'];

echo "<table class = 'tabQuadrille' width = 40% cellspacing='0' cellpadding='0' align = 'center'>
	<tr class = 'ligneTabQuad'>
	<form action= 'baseModifie.php' method='POST'>
	<input type = 'hidden' name = 'groupe$i' value = '$nomGroupe'/>
	<td align = 'left' width = 70% > $nomGroupe </td>";

	if($stand)
	{
	
		echo "<td width = 30%><input type = 'checkbox' checked name = 'stand$i' value=1/></td></tr>";
	}
	else
	{
	
		echo "<td width = 30%><input type = 'checkbox' name ='stand$i' value = 1/></td></tr>";

	}

$i++;
} 
echo '</table>';
echo '<table width = 10% align ="center"> ';
echo '<tr><td><input type ="submit" value="valider" name = "valider"/></td></tr></table>';
echo '<input type = "hidden" name = "numGroupe" value = '.$i.' /></form>';

?>
