<?php

function getConnect(){
	require_once('connect.php');
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN,$credit=0){
	$connexion=getConnect();
	$requete="insert into client VALUES('','$nom', '$prenom', '$adresse', '$numTel', '$dateN','$credit')"; 
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}

function modifClient ($id,$nom, $prenom, $adresse, $numTel, $dateN,$credit){
	$connexion=getConnect();
	$requete="update table client
			set nom = '$nom', prenom = '$prenom', adresse = '$adresse', numTel = '$numTel', dateNaiss = '$dateN' , credit='$credit'
			where id='$id'";
	$resultat=$connexion->exec($requete);
	$resultat->closeCursor();
}

function supprimerClient ($id){
	$connexion=getConnect();
	$requete="delete table,facture,intervention from facture,intervention,client
			where table.id='$id'
			and facture.id_client = table.id
			and intervention.id_cleint = table.id";
	$resultat=$connexion->exec($requete);
	$resultat=closeCursor();
}

function getCategorie($id, $mdp){
	$connexion=getConnect();
	$requete="select categorie from employe
	where id='$id'
	and mpd = '$mdp'";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$categorie=$resultat->fetch();
	$resultat->closeCursor();
	return $categorie;
}

