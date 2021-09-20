<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=connect();
if (!$connexion)
{
   ajouterErreur("Echec de la connexion au serveur MySql");
   afficherErreurs();
   exit();
}
if (!selectBase($connexion))
{
   ajouterErreur("La base de données festival est inexistante ou non accessible");
   afficherErreurs();
   exit();
}

// SUPPRIMER UN ÉTABLISSEMENT 

$idGroupe=$_REQUEST['idGroupe'];  

$lgGroupe=obtenirDetailGroupe($connexion, $idGroupe);
$nomGroupe=$lgGroupe['nomGroupe'];

// Cas 1ère étape (on vient de listeEtablissements.php)

if ($_REQUEST['action']=='demanderSupprGroupe')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer le groupe $nomGroupe ? 
   <br><br>
   <a href='suppressionGroupe.php?action=validerSupprEtab&amp;idGroupe=$idGroupe'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeGroupe.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionEtablissement.php)

else
{
   supprimerGroupe($connexion, $idGroupe);
   echo "
   <br><br><center><h5>Le groupe $nomGroupe a été supprimé</h5>
   <a href='listeGroupe.php?'>Retour</a></center>";
}

?>
