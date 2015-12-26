<?php
function getConnect() {
	require_once ('connect.php');
	$connexion = new PDO ( 'mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD );
	$connexion->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	// $connexion->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERR_NONE );
	$connexion->query ( 'SET NAMES UTF8' );
	return $connexion;
}
// /////////////////////agent
function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN, $credit = 0) {
	$connexion = getConnect ();
	$requete = "insert into client VALUES('','$nom', '$prenom', '$adresse', '$numTel', '$dateN','$credit')";
	$connexion->exec ( $requete );
}
function modifClient($id, $nom, $prenom, $adresse, $numTel, $dateN, $credit) {
	$connexion = getConnect ();
	$requete = "update table client
			set nom = '$nom', prenom = '$prenom', adresse = '$adresse', numTel = '$numTel', dateNaiss = '$dateN' , credit='$credit'
			where id='$id'";
	$connexion->exec ( $requete );
}
function supprimerClient($id) {
	$connexion = getConnect ();
	$requete = "delete from intervention,client
		where client.id='$id'";
	$connexion->exec ( $requete );
}

function getInformationClient($id){
	$connexion = getConnect ();
	$requete = "select * from client where id='$id'";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$client = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $client;
}

function getSommeImpayer($idClient){
	$connexion = getConnect ();
	$requete = "select sum(type_intervention.prix) as impayer from type_intervention,intervention,facture where intervention.id_client='$idClient' and facture.id_intervention=intervention.id and facture.etat='en différé' and type_intervention.id=intervention.type";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$impayer = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $impayer;
}

function getInterventionClient($id){
	$connexion = getConnect ();
	$requete = "select intervention.horaire,intervention.id,intervention.id_client,facture.etat,type_intervention.type,type_intervention.prix,mecanicien.nom from mecanicien,intervention,facture,type_intervention where intervention.id=facture.id_intervention and type_intervention.id=intervention.type and mecanicien.id=intervention.id_mecanicien and intervention.id_client='$id'";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$interventions = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $interventions;
}

function getIntervention($id){
	$connexion = getConnect ();
	$requete = "select intervention.id_client,intervention.id_mecanicien,type_intervention.type,intervention.horaire,materiel.libele,mecanicien.nom,type_intervention.prix,client.nom from client,mecanicien,type_intervention,intervention,produit,materiel where intervention.id='$id' and intervention.type=produit.id_produit and materiel.id=produit.id_materiel and type_intervention.id=intervention.type and mecanicien.id=intervention.id_mecanicien and client.id=intervention.id_client";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$interventions = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $interventions;
}

// /////connection
function getCategorie($id, $mdp) {
	$connexion = getConnect ();
	$requete = "select categorie from employe
	where id='$id'
	and mdp = '$mdp'";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$categorie = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $categorie;
}

// /////directeur

// materiel
function getPieces() {
	$connexion = getConnect ();
	$requete = "select * from materiel";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$pieces = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $pieces;
}
function ajouterMateriel($libele) {
	$connexion = getConnect ();
	$requete = "insert into materiel VALUES('','$libele')";
	$connexion->exec ( $requete );
}
function modifierMateriel($id, $libele) {
	$connexion = getConnect ();
	$requete = "update materiel set libele='$libele' where id='$id'";
	$connexion->exec ( $requete );
}
function supprimerMateriel($id) {
	$connexion = getConnect ();
	$requete = "delete from materiel where materiel.id='$id' ";
	$connexion->exec ( $requete );
}
// produit
function ajouterProduit($id_produit, $id_materiel) {
	$connexion = getConnect ();
	$requete = "insert ignore into produit VALUES('$id_produit','$id_materiel')";
	$connexion->exec ( $requete );
}
function supprimerProduit($id_produit, $id_materiel) {
	$connexion = getConnect ();
	$requete = "delete from produit where id_produit='$id_produit' and id_materiel='$id_materiel'";
	$connexion->exec ( $requete );
}
// typeIntervention
function getTypeIntervention() {
	$connexion = getConnect ();
	$requete = "select * from type_intervention";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$interventions = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $interventions;
}
function getProduit() {
	$connexion = getConnect ();
	$requete = "select * from produit";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$produit = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $produit;
}
function creerTypeIntervention($type, $prix) {
	$connexion = getConnect ();
	$requete = "insert into type_intervention VALUES('','$type','$prix')";
	$connexion->exec ( $requete );
	return $connexion->lastInsertId ();
}
function supprimerTypeIntervention($id) {
	$connexion = getConnect ();
	$requete = "delete from type_intervention where id='$id'";
	$connexion->exec ( $requete );
}
function modifierTypeIntervention($id, $type, $prix) {
	$connexion = getConnect ();
	$requete = "update type_intervention set type='$type',prix='$prix' where id='$id'";
	$connexion->exec ( $requete );
}
function getMaterielIntervention($id) {
	$connexion = getConnect ();
	$requete = "select materiel.id,materiel.libele from materiel,type_intervention,produit where materiel.id=produit.id_materiel and produit.id_produit=type_intervention.id";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$pieces = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $pieces;
}

// mecanicien
function ajouterMecanicien($nom) {
	$connexion = getConnect ();
	$requete = "insert into mecanicien VALUES('','$nom')";
	$connexion->exec ( $requete );
}
function modifierMecanicien($id, $nom) {
	$connexion = getConnect ();
	$requete = "update mecanicien set nom='$nom' where id='$id'";
	$connexion->exec ( $requete );
}
function supprimerMecanicien($id) {
	$connexion = getConnect ();
	$requete = "delete from mecanicien where id='$id'";
	$connexion->exec ( $requete );
}
function getMecanicien() {
	$connexion = getConnect ();
	$requete = "select * from mecanicien";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$mecanicien = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $mecanicien;
}
// employe
function getEmployes() {
	$connexion = getConnect ();
	$requete = "select * from employe";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$employes = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $employes;
}
function ajouterEmploye($id, $mdp, $categorie) {
	$connexion = getConnect ();
	$requete = "insert ignore into employe VALUES('$id','$mdp','$categorie')";
	$connexion->exec ( $requete );
}
function modifierEmploye($idP, $id, $mdp, $categorie) {
	$connexion = getConnect ();
	$requete = "update ignore employe SET id='$id',mdp='$mdp',categorie='$categorie' where id='$idP'";
	$connexion->exec ( $requete );
}
function supprimerEmploye($id) {
	$connexion = getConnect ();
	$requete = "delete employe where id='$id'";
	$connexion->exec ( $requete );
}
////////////////MECANICIEN///////////////////

function edtMecanicien($idMecanicien,$semaine,$annee){
	$connexion = getConnect ();
	$requete = "select * from edt where id_mecanicien='$idMecanicien' and YEAR(horaire)='$annee' and WEEK(horaire)='$semaine' order by horaire asc";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$edt = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $edt;
}

function ajouterFormation($idMecanicien,$horaire){
	$connexion = getConnect ();
	$requete = "insert ignore into formation values('','$idMecanicien','$horaire')";
	$connexion->exec ( $requete );
	return $connexion->lastInsertId();
}

function ajouterFormationEdt($idMecanicien,$idFormation,$horaire){
	$connexion = getConnect ();
	$requete = "insert ignore into edt values('','formation','$idMecanicien','$horaire',NULL,'$idFormation')";
	$connexion->exec ( $requete );
}

function isDisponible($idMecanicien,$horaire){
	$connexion = getConnect ();
	$requete = "select * from edt where id_mecanicien='$idMecanicien' and horaire='$horaire'";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$edt = $resultat->fetchAll ();
	$resultat->closeCursor ();
	return $edt;
}
