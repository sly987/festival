<?php
include("connexion-PDO.php");
include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONSULTER LES ATTRIBUTIONS DE TOUS LES ÉTABLISSEMENTS

// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT OFFRANT DES CHAMBRES POUR  
// AFFICHER LE LIEN VERS LA MODIFICATION
$nbEtab=obtenirNbEtabOffrantChambres($connexion);
if ($nbEtab!=0)
{
   echo "
   <table width='75%' cellspacing='0' cellpadding='0' align='center'
   <tr><td>
   <a href='modificationAttributions.php?action=demanderModifAttrib'>
   Effectuer ou modifier les attributions</a></td></tr></table><br><br>";
   
   // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
   // D'EN-TÊTE ET LE DÉTAIL DES ATTRIBUTIONS
   $req=obtenirReqEtablissementsAyantChambresAttribuées();
   $rsEtab=$connexion-> query($req);
   $lgEtab=$rsEtab->fetchAll();
   // BOUCLE SUR LES ÉTABLISSEMENTS AYANT DÉJÀ DES CHAMBRES ATTRIBUÉES
   foreach ($lgEtab as $row)
   {
      $idEtab=$row['idEtab'];
      $nomEtab=$row['nomEtab'];
   
      echo "
      <table width='75%' cellspacing='0' cellpadding='0' align='center' 
      class='tabQuadrille'>";
      
      $nbOffre=$row["nombreChambresOffertes"];
      $nbOccup=obtenirNbOccup($connexion, $idEtab);
      // Calcul du nombre de chambres libres dans l'établissement
      $nbChLib = $nbOffre - $nbOccup;
      
      // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE 
      echo "
      <tr class='enTeteTabQuad'>
         <td colspan='3' align='left'><strong>$nomEtab</strong>&nbsp;
         (Offre : $nbOffre&nbsp;&nbsp;Disponibilités : $nbChLib)
         </td>
      </tr>";
          
      // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE 
      echo "
      <tr class='ligneTabQuad'>
         <td width='50%' align='left'><i><strong>Nom groupe</strong></i></td>
         <td width = '25%' align ='left'><i><strong>Pays groupe</strong></i></td>
         <td width='25%' align='left'><i><strong>Chambres attribuées</strong></i>
         </td>
      </tr>";
        
      // AFFICHAGE DU DÉTAIL DES ATTRIBUTIONS : UNE LIGNE PAR GROUPE AFFECTÉ 
      // DANS L'ÉTABLISSEMENT       
      $req=obtenirReqGroupesEtab($idEtab);
      $rsGroupe=$connexion->query($req);
      $lgGroupe=$rsGroupe->fetchAll();
               
      // BOUCLE SUR LES GROUPES (CHAQUE GROUPE EST AFFICHÉ EN LIGNE)
      foreach($lgGroupe as $row)
      {
         $idGroupe=$row['idGroupe'];
         $nomGroupe=$row['nomGroupe'];
         $nomPays=$row['nomPays'];
         echo "
         <tr class='ligneTabQuad'>
            <td width='50%' align='left'>$nomGroupe </td>
            <td width = '25%' align ='left'>$nomPays</td>";

         // On recherche si des chambres ont déjà été attribuées à ce groupe
         // dans l'établissement
         $nbOccupGroupe=obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe);
         echo "
            <td width='25%' align='left'>$nbOccupGroupe</td>
         </tr>";
      } // Fin de la boucle sur les groupes
      
      echo "
      </table><br>";
   } // Fin de la boucle sur les établissements
}

?>