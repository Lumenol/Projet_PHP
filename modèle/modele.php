<?php

function getConnect(){
	require_once('connect.php');
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

////////////////////////////concernant les agents d'accueil//////////////////////////////////////

function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN){
	$connexion=getConnect();
	$requete="insert into  client 
			values ('$nom', '$prenom', '$adresse', '$numTel', '$dateN','')";
	$connexion->exec($requete);
}

function ajouterSolde($idc, $diffMax, $diff, $etat){
	$connexion=getConnect();
	$requete="insert into soldeclient 
			values ('$diffMax', '$diff', '$etat','')
			where (select soldeclient.id
					from client, soldeclient
					where client.id = '$idc'
					and soldeclient.id = client.id) ";
	$connexion->exec($requete);
	
}

function modifClient ($idc, $nvnom, $nvprenom, $nvadresse, $nvnumtel, $nvdaten){
	$connexion=getConnect();
	$requete="update client
			set nom = '$nvnom', prenom = '$nvprenom', adresse = '$nvadresse', numTel = '$nvnumtel', dateNaiss = '$nvdaten'
			where id = '$idc'";
$connexion->exec($requete);

}

function supprimerClient ($idc){
	$connexion=getConnect();
	$requete="delete from client
			where id = '$idc'";
	$connexion->exec($requete);
}

function recupEDT ($idenMeca, $nomMeca){
	$connexion=getConnect();
	$requete="select jour, idMeca, intervention, formation
			from emploidutemps, mecanicien
			where mecanicien.edt = emploidutemps.idMeca
			and mecanicien.identifiant = '$idenMeca'
			and mecanicien.nom = '$nomMeca';
			order by jour, intervention ";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$edt=$resultat->fetchall();
	$resultat->closeCursor();
	return $edt;
}

function syntheseClient($idc){
	$connexion=getConnect();
	$requete="select *
			from client, soldeclient, intervention
			where client.id = '$idc'
			and client.id = soldeclient.id
			and soldeclient.intervention = intervention.idInter";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$client=$resultat->fetch();
	$resultat->closeCursor();
	return $client;
}

function trouverIDclient ($nom, $dateN){
	$connexion=getConnect();
	$requete="select id
				from client
				where nom='$nom'
				and dateNaiss='$dateN'";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$idclient=$resultat->fetchall();
	$resultat->closeCursor();
	return $idclient;
}

/////////////////////////////////concernant le directeur/////////////////////////////////4

function creerIntervention($idinter, $typeinter, $matinter){
	$connexion=getConnect();
	$requete="insert into  typeintervention 
			values ('$idinter', '$typeinter', '$matinter')";
	$connexion->exec($requete);
}

function suppimerIntervention($idtypeinter){
	$connexion=getConnect();
	$requete="delete from  typeintervention
			where id='$idtypeinter'";
$connexion->exec($requete);

}

function modifIntervention($idtypeinter, $nvid, $nvtype, $nvmat){
	$connexion=getConnect();
	$requete="update table typeintervention
			set (id = '$nvid', type = '$nvtype', materiel = '$nvmat')
			where id = '$idtypeinter'";
$connexion->exec($requete);

}

function creerEmploye ($idemploye, $mdpemploye, $categorie){
	$connexion=getConnect();
	$requete="insert into  employe 
			values ('$idemploye', '$mdpemploye', '$categorie')";
$connexion->exec($requete);
}

function modifEmploye ($idemploye, $mdpemploye, $categorie, $nvidemploye, $nvmdpemploye, $nvcategorie){
	$connexion=getConnect();
	$requete="update table employe
				set (identifiant = '$nvidemploye', mdp = '$nvmdpemploye', categorie='$nvcategorie')
				where identifiant = '$idemploye'
				and mdp = '$mdpemploye'
				and categorie = '$categorie'";
$connexion->exec($requete);
}

function supprEmploye ($idemploye, $mdpemploye){
	$connexion=getConnect();
	$requete="delete from  employe
				where identifiant='$idemploye'
				and mdp = '$mdpemploye'";
$connexion->exec($requete);

}

function getCategorie($idemploye, $mdpemploye){
	$connexion=getConnect();
	$requete="select categorie
	from employe
	where identifiant='$idemploye'
	and mdp='$mdpemploye'";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$employe=$resultat->fetch();
	$resultat->closeCursor();
	return $employe->categorie;
}

//////////////////////concernant les mecaniciens///////////////////////////////////////

function ajouterFormation($idmeca, $dateforma){
	$connexion=getConnect();
	$requete="insert into table formation values ('$idmeca', '$dateforma')";
$connexion->exec($requete);
}