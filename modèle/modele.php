<?php

function getConnect(){
	require_once('connect.php');
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN){
	$connexion=getConnect();
	$requete="insert into table client ($nom, $prenom, $adresse, $numTel, $dateN) 
			if not exists (select *
				from client 
				where nom = $nom
				and prenom = $prenom
				and adresse = $adresse
				and numTel = $numTel
				and dateNaiss = $dateN)";
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}

function ajouterSolde($nom, $prenom, $dateN, $diffMax, $diff, $etat){
	$connexion=getConnect();
	$requete="insert into table soldeclient ($diffmax, $diff, $etat)
			where (select soldeclient.id
					from client, soldeclient
					where nom = $nom
					and prenom = $prenom
					and dateNaiss = $dateN
					and soldeclient.id = client.id) ";
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}

function modifClient ($nom, $prenom, $dateN, $nvnom, $nvprenom, $nvadresse, $nvnumtel, $nvdaten){
	$connexion=getConnect();
	$requete="update table client
			set (nom = $nvnom, prenom = $nvprenom, adresse = $nvadresse, numTel = $nvnumtel, dateNaiss = $nvdaten)
			where nom = $nom
			and prenom = $prenom 
			and dateNaiss = $dateN";
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}

function supprimerClient ($nom, $prenom, $dateN){
	$connexion=getConnect();
	$requete="delete from table client
			where nom = $nom
			and prenom = $prenom
			and dateNaiss = $dateN";
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}


