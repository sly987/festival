<?php
include("_debut.inc.php");
include("_gestionBase.inc.php"); 

echo "</br><h1> La base de donnée a été modifiée</h1>";
if (isset($_POST['valider']))
{
	for ($j=0; $j<$_POST['numGroupe']; $j++)
	{
		if(isset($_POST['stand'.$j]))
		{
			$_POST['stand'.$j] = 1;
			envoyerStand($connexion, $_POST['groupe'.$j], $_POST['stand'.$j] );
		}
		else
		{
			$_POST['stand'.$j]=0;
			envoyerStand($connexion, $_POST['groupe'.$j] , $_POST['stand'.$j]);
		}
	}
}
?>