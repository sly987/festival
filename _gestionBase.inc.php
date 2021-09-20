<?php

include('connexion-PDO.php');



// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="select idEtab, nomEtab from Etablissement order by idEtab";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="select idEtab, nomEtab, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by idEtab";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="select distinct Etablissement.idEtab, nomEtab, nombreChambresOffertes from Etablissement, 
         Attribution where Etablissement.idEtab = Attribution.idEtab order by Attribution.idEtab";
   return $req;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $req="select * from Etablissement where idEtab='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function supprimerEtablissement($connexion, $id)
{
   $req="delete from Etablissement where idEtab='$id'";
   $connexion->query($req );
}
 
function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $req="update Etablissement set nomEtab='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where idEtab='$id'";
   
    $connexion->query($req);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $req="insert into Etablissement values ('$id', '$nom', '$adresseRue', 
         '$codePostal', '$ville', '$tel', '$adresseElectronique', '$type', 
         '$civiliteResponsable', '$nomResponsable', '$prenomResponsable',
         '$nombreChambresOffertes')";
   
   $connexion->query($req);
}


function estUnIdEtablissement($connexion, $id)
{
   $req="select * from Etablissement where idEtab='$id'";
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from Etablissement where nomEtab='$nom'";
   }
   else
   {
      $req="select * from Etablissement where nomEtab='$nom' and idEtab!='$id'";
   }
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}

function obtenirNbEtab($connexion)
{
   $req="select count(*) as nombreEtab from Etablissement";
   $rsEtab=$connexion->query($req);
   $lgEtab=$rsEtab->fetchAll();
   foreach($lgEtab as $row)
   {
         $nombreEtab = $row['nombreEtab'];
   }
   return $nombreEtab;
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="select count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=$connexion-> query($req);
   $lgEtabOffrantChambres=$rsEtabOffrantChambres->fetchAll();
   foreach ($lgEtabOffrantChambres as $row)
   {
      $EtabOffrantChambres = $row['nombreEtabOffrantChambres'];
   }
   return $EtabOffrantChambres;
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

function nbChambresMax($connexion, $idEtab)
{
   $req = "SELECT nombreChambresOffertes FROM Etablissement WHERE idEtab = '$idEtab'";
   $rsEtab = $connexion->query($req);
   $lgEtab = $rsEtab->fetchAll();
   foreach($lgEtab as $row)
   {
      $nbMax = $row['nombreChambresOffertes'];
   }
   return $nbMax;
}

// FONCTIONS RELATIVES AUX GROUPES

function obtenirReqIdNomGroupesAHeberger()
{
   $req="select idGroupe, nomGroupe from Groupe where hebergement='O' order by idGroupe";
   return $req;
}
function obtenirReqGroupe()
{
   $req="select idGroupe, nomGroupe from Groupe order by idGroupe";
   return $req;
}


function obtenirNomGroupe($connexion, $id)
{
   $req="select nomGroupe from Groupe where idGroupe='$id' order by nomGroupe";
   $rsGroupe=$connexion->query($req);
   $lgGroupe=$rsGroupe->fetchAll();
   foreach ($lgGroupe as $row)
   {
      $nomGroupe = $row['nomGroupe'];
   }
   return $nomGroupe;
}
function obtenirIdGroupe($connexion)
{
   $req = 'SELECT idGroupe from groupe order by (idGroupe) desc limit 0, 1';
   $rsGroupe = $connexion->query($req);
   $lgGroupe = $rsGroupe->fetchAll();
   foreach ($lgGroupe as $row)
   {
      $idGroupe = $row['idGroupe'];
   }
   return $idGroupe;
}
function estUnNomGroupe($connexion, $mode, $idGroupe, $nomGroupe)
{
    $nomGroupe=str_replace("'", "''", $nomGroupe);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from Etablissement where nomGroupe='$nom'";
   }
   else
   {
      $req="select * from Etablissement where nomEtab='$nomGroupe' and idEtab!='$idGroupe'";
   }
   $rsEtab=$connexion->query($req);
   return $rsEtab->fetchAll();
}
function existeAttributionsGroupe($connexion, $id)
{
   $req="select * From Attribution where idGroupe='$id'";
   $rsAttrib=$connexion->query($req);
   return $rsAttrib->fetchAll();
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbGroupeOccup($connexion, $idGroupe)
{
   $req="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idGroupe='$idGroupe'";
   $rsOccup= $connexion->query($req);
   $lgOccup=$rsOccup->fetchAll();
   foreach ($lgOccup as $row)
   {
      $totalChambresOccup = $row['totalChambresOccup'];
   }
   return $totalChambresOccup;
}

function resultatGroupe($connexion, $nom)
{
   $req = 'SELECT idGroupe, nomGroupe FROM Groupe where nomGroupe LIKE "%'.$nom.'%"';
   return $req;
}
function obtenirDetailGroupe($connexion, $id)
{
   $req="select * from Groupe where idGroupe='$id'";
   $rsGroupe= $connexion->query($req);
   return $rsGroupe->fetchAll();
}
function creerGroupe($connexion, $idGroupe, $nomGroupe, $nombrepersonnnes,$nompays,$hebergement, $ligue)
{ 
   $nomGroupe=str_replace("'", "''", $nomGroupe);
   $nombrepersonnnes=str_replace("'","''", $nombrepersonnnes);
   $ligue=str_replace("'","''", $ligue);
   $nompays=str_replace("'","''", $nompays);
   $hebergement=str_replace("'","''", $hebergement);
   
   $req="insert into Groupe values ('$idGroupe', '$nomGroupe', '$nombrepersonnnes', '$nompays', '$hebergement','$ligue', 0)";
   
   $connexion->query($req);
}


function supprimerGroupe($connexion, $id)
{
   $req="delete from Groupe where idGroupe='$id'";
   $connexion->query($req);
}
// 
function modifierGroupe($connexion, $idGroupe, $nomGroupe, $nombrePersonnes, $ligue,$nompays,$hebergement)
{  
   $nomGroupe=str_replace("'", "''", $nomGroupe);
   $nombrePersonnes=str_replace("'","''", $nombrePersonnes);
   $ligue=str_replace("'","''", $ligue);
   $nompays=str_replace("'","''", $nompays);
   $hebergement=str_replace("'","''", $hebergement);
  
   $req="update Groupe set nomGroupe='$nomGroupe',nombrePersonnes='$nombrePersonnes',
         ligue='$ligue',nompays='$nompays',hebergement='$hebergement' where idGroupe = '$idGroupe'";
   
   $connexion->query($req);
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $req="select * From Attribution where idEtab='$id'";
   $rsAttrib=$connexion->query($req);
   return $rsAttrib->fetchAll();
   
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $req="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   $rsOccup=$connexion->query($req);
   $lgOccup=$rsOccup->fetchAll();
   foreach ($lgOccup as $row) 
   {
      $chambre = $row['totalChambresOccup'];
   }
   return $chambre;
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idGroupe, $nbChambres)
{
   $req="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idGroupe='$idGroupe'";
   $rsAttrib= $connexion->query($req);
   $lgAttrib=$rsAttrib->fetchAll();
   foreach($lgAttrib as $row)
   {
      $nombreAttribGroupe = $row['nombreAttribGroupe'];
   }
   if ($nbChambres==0)
      $req="delete from Attribution where idEtab='$idEtab' and idGroupe='$idGroupe'";
   else
   {
      if ($nombreAttribGroupe!=0)
         $req="update Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idGroupe='$idGroupe'";
      else
         $req="insert into Attribution values('$idEtab','$idGroupe', $nbChambres)";
   }
   $connexion->query($req);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $req="select distinct Groupe.idGroupe, Groupe.nomGroupe, nomPays from Groupe, Attribution where 
        Attribution.idGroupe=Groupe.idGroupe and idEtab='$id'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe)
{
   $req="select nombreChambres From Attribution where idEtab='$idEtab'
        and idGroupe='$idGroupe'";
   $rsAttribGroupe=$connexion->query($req);
   if ($lgAttribGroupe=$rsAttribGroupe->fetchAll())
   {
      foreach ($lgAttribGroupe as $row) 
      {
         $nombreChambres = $row['nombreChambres'];
      }
      return $nombreChambres;
   }
   else
      return 0;
}
//fonction relative aux stands


function obtenirStand ()
{
   $req ="SELECT nomGroupe, stand FROM groupe";
   return $req;
}

function envoyerStand($connexion, $nomGroupe, $stand)
{
   $req = "UPDATE groupe SET stand = '$stand' where nomGroupe = '$nomGroupe'";
   $rsGroupe= $connexion-> query($req);

}
function chercherStand($connexion, $nom)
{
   $req = 'SELECT nomGroupe, Stand FROM Groupe where nomGroupe LIKE "%'.$nom.'%"';
   return $req;
}

?>

