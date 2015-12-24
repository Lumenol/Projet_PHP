<?php

function getConnect(){
	require_once('connect.php');
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

function afficheEmployes(){
	$connexion=getConnect();
	$requete="select *
			from employe
			order by categorie";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

////////////////////////////concernant les agents d'accueil//////////////////////////////////////

function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN){
	$connexion=getConnect();
	$requete="insert into table client 
			values ($nom, $prenom, $adresse, $numTel, $dateN) 
			where not exists (select *
				from client 
				where nom = '$nom'
				and prenom = '$prenom'
				and adresse = '$adresse'
				and numTel = $numTel
				and dateNaiss = $dateN)";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
}

function ajouterSolde($idc, $diffMax, $diff, $etat){
	$connexion=getConnect();
	$requete="insert into table soldeclient 
			values ($diffmax, $diff, $etat, $idc)";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
}

function modifClient ($idc, $nvnom, $nvprenom, $nvadresse, $nvnumtel, $nvdaten){
	$connexion=getConnect();
	$requete="update table client
			set (nom = '$nvnom', prenom = '$nvprenom', adresse = '$nvadresse', numTel = $nvnumtel, dateNaiss = $nvdaten)
			where id = $idc";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
}

function supprimerClient ($idc){
	$connexion=getConnect();
	$requete="delete from table client
			where id = $idc";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
}

function recupEDT ($idenMeca, $nomMeca){
	$connexion=getConnect();
	$requete="select jour, idMeca, intervention, formation
			from emploidutemps, mecanicien
			where mecanicien.edt = emploidutemps.idMeca
			and mecanicien.identifiant = $idenMeca
			and mecanicien.nom = '$nomMeca';
			order by jour, intervention ";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$edt=$resultat->fetchall();
	$resultat->closeCursor();
}

function syntheseClient($idc){
	$connexion=getConnect();
	$requete="select *
			from client, soldeclient, intervention
			where client.id = $idc
			and client.id = soldeclient.id
			and soldeclient.intervention = intervention.idInter";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$client=$resultat->fetchall();
	$resultat->closeCursor();
}

function trouverIDclient ($nom, $dateN){
	$connexion=getConnect();
	$requete="select id
				from client
				where nom='$nom'
				and dateNaiss=$dateN";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$idclient=$resultat->fetchall();
	$resultat->closeCursor();
}

/////////////////////////////////concernant le directeur/////////////////////////////////4

function creerIntervention($idinter, $typeinter, $matinter){
	$connexion=getConnect();
	$requete="insert into table typeintervention 
			values ($idinter, '$typeinter', '$matinter')";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function suppimerIntervention($idtypeinter){
	$connexion=getConnect();
	$requete="delete from table typeintervention
			where id=$idtypeinter";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function modifIntervention($idtypeinter, $nvid, $nvtype, $nvmat){
	$connexion=getConnect();
	$requete="update table typeintervention
			set (id = $nvid, type = $nvtype, materiel = $nvmat)
			where id = $idtypeinter";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function creerEmploye ($idemploye, $mdpemploye, $categorie){
	$connexion=getConnect();
	$requete="insert into table employe 
			values ($idemploye, '$mdpemploye', '$categorie')";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function modifEmploye ($idemploye, $mdpemploye, $categorie, $nvidemploye, $nvmdpemploye, $nvcategorie){
	$connexion=getConnect();
	$requete="update table employe
				set (identifiant = $nvidemploye, mdp = '$nvmdpemploye', categorie='$nvcategorie')
				where identifiant = $idemploye
				and mdp = '$mdpemploye'
				and categorie = '$categorie'";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function supprEmploye ($idemploye, $mdpemploye){
	$connexion=getConnect();
	$requete="delete from table employe
				where identifiant=$idemploye
				and mpd = '$mdpemploye'";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function creerPiece ($libelle, $idprod){
	$connexion=getConnect();
	$requete="insert into materiel
				values ('$libelle', $idprod)";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function modifPiece ($nvlibelle, $nvidprod, $idprod){
	$connexion=getConnect();
	$requete="update materiel
				set (libelle='$nvlibelle', idProd=$nvidprod)
				where idProd=$idprod";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

function supprimerPiece ($idprod){
	$connexion=getConnect();
	$requete="delete from materiel
				where idprod=$idprod";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}

//////////////////////concernant les mecaniciens///////////////////////////////////////

function ajouterFormation($idmeca, $dateforma){
	$connexion=getConnect();
	$requete="insert into table formation values ($idmeca, $dateforma)";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
}