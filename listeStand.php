<?php
include("connexion-PDO.php");
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival


$req = chercherStand($connexion, $_POST['search']);
$rsStand =$connexion-> query($req);
$i = 0;
$lgStand = $rsStand->fetchAll();
if($lgStand == False)
{
	echo "<h1>Il n'y a aucun groupe correspondant à ". $_POST['search']."</h1>";
}
else
{
	echo
		"<table class = 'tabQuadrille' width = 40% cellspacing='0' cellpadding='0' align = 'center'>
		<tr class = 'enTeteTabQuad'>
		<td align = 'left' width = 70%> <strong>groupe</strong></td>
		<td align = 'center'> <strong>avoir un stand</Strong></td></tr>";

	foreach ($lgStand as $row)
	{
		$nomGroupe = $row['nomGroupe'];
		$stand = $row['Stand'];
	
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
}

?>