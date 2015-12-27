<?php

function getConnect(){
	require_once('connect.php');
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

<<<<<<< HEAD
function afficheEmployes(){
	$connexion=getConnect();
	$requete="select *
			from employe
			order by categorie";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

=======
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
////////////////////////////concernant les agents d'accueil//////////////////////////////////////

function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN){
	$connexion=getConnect();
<<<<<<< HEAD
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
=======
	$requete="insert into  client 
			values ('$nom', '$prenom', '$adresse', '$numTel', '$dateN','')";
	$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function ajouterSolde($idc, $diffMax, $diff, $etat){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="insert into table soldeclient 
			values ($diffmax, $diff, $etat, $idc)";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="insert into soldeclient 
			values ('$diffMax', '$diff', '$etat','')
			where (select soldeclient.id
					from client, soldeclient
					where client.id = '$idc'
					and soldeclient.id = client.id) ";
	$connexion->exec($requete);
	
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function modifClient ($idc, $nvnom, $nvprenom, $nvadresse, $nvnumtel, $nvdaten){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="update table client
			set (nom = '$nvnom', prenom = '$nvprenom', adresse = '$nvadresse', numTel = $nvnumtel, dateNaiss = $nvdaten)
			where id = $idc";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="update client
			set nom = '$nvnom', prenom = '$nvprenom', adresse = '$nvadresse', numTel = '$nvnumtel', dateNaiss = '$nvdaten'
			where id = '$idc'";
$connexion->exec($requete);

>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function supprimerClient ($idc){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="delete from table client
			where id = $idc";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="delete from client
			where id = '$idc'";
	$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function recupEDT ($idenMeca, $nomMeca){
	$connexion=getConnect();
	$requete="select jour, idMeca, intervention, formation
			from emploidutemps, mecanicien
			where mecanicien.edt = emploidutemps.idMeca
<<<<<<< HEAD
			and mecanicien.identifiant = $idenMeca
=======
			and mecanicien.identifiant = '$idenMeca'
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
			and mecanicien.nom = '$nomMeca';
			order by jour, intervention ";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$edt=$resultat->fetchall();
	$resultat->closeCursor();
<<<<<<< HEAD
=======
	return $edt;
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function syntheseClient($idc){
	$connexion=getConnect();
	$requete="select *
			from client, soldeclient, intervention
<<<<<<< HEAD
			where client.id = $idc
=======
			where client.id = '$idc'
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
			and client.id = soldeclient.id
			and soldeclient.intervention = intervention.idInter";
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
<<<<<<< HEAD
	$client=$resultat->fetchall();
	$resultat->closeCursor();
=======
	$client=$resultat->fetch();
	$resultat->closeCursor();
	return $client;
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function trouverIDclient ($nom, $dateN){
	$connexion=getConnect();
	$requete="select id
				from client
				where nom='$nom'
<<<<<<< HEAD
				and dateNaiss=$dateN";
=======
				and dateNaiss='$dateN'";
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
	$resultat = $connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$idclient=$resultat->fetchall();
	$resultat->closeCursor();
<<<<<<< HEAD
=======
	return $idclient;
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

/////////////////////////////////concernant le directeur/////////////////////////////////4

function creerIntervention($idinter, $typeinter, $matinter){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="insert into table typeintervention 
			values ($idinter, '$typeinter', '$matinter')";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="insert into  typeintervention 
			values ('$idinter', '$typeinter', '$matinter')";
	$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function suppimerIntervention($idtypeinter){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="delete from table typeintervention
			where id=$idtypeinter";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="delete from  typeintervention
			where id='$idtypeinter'";
$connexion->exec($requete);

>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function modifIntervention($idtypeinter, $nvid, $nvtype, $nvmat){
	$connexion=getConnect();
	$requete="update table typeintervention
<<<<<<< HEAD
			set (id = $nvid, type = $nvtype, materiel = $nvmat)
			where id = $idtypeinter";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
			set (id = '$nvid', type = '$nvtype', materiel = '$nvmat')
			where id = '$idtypeinter'";
$connexion->exec($requete);

>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function creerEmploye ($idemploye, $mdpemploye, $categorie){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="insert into table employe 
			values ($idemploye, '$mdpemploye', '$categorie')";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="insert into  employe 
			values ('$idemploye', '$mdpemploye', '$categorie')";
$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function modifEmploye ($idemploye, $mdpemploye, $categorie, $nvidemploye, $nvmdpemploye, $nvcategorie){
	$connexion=getConnect();
	$requete="update table employe
<<<<<<< HEAD
				set (identifiant = $nvidemploye, mdp = '$nvmdpemploye', categorie='$nvcategorie')
				where identifiant = $idemploye
				and mdp = '$mdpemploye'
				and categorie = '$categorie'";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
				set (identifiant = '$nvidemploye', mdp = '$nvmdpemploye', categorie='$nvcategorie')
				where identifiant = '$idemploye'
				and mdp = '$mdpemploye'
				and categorie = '$categorie'";
$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

function supprEmploye ($idemploye, $mdpemploye){
	$connexion=getConnect();
<<<<<<< HEAD
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
=======
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
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}

//////////////////////concernant les mecaniciens///////////////////////////////////////

function ajouterFormation($idmeca, $dateforma){
	$connexion=getConnect();
<<<<<<< HEAD
	$requete="insert into table formation values ($idmeca, $dateforma)";
	$resultat = $connexion->exec($requete);
	$resultat->closeCursor();
=======
	$requete="insert into table formation values ('$idmeca', '$dateforma')";
$connexion->exec($requete);
>>>>>>> e9b56676a1d7749003261f9cece228e3d46def80
}