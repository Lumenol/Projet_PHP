<?php
function getConnect() {
	require_once ('connect.php');
	$connexion = new PDO ( 'mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD );
	$connexion->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
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
	$today = date ( 'Y/m/d H:i:s' );
	$connexion = getConnect ();
	$requete = "delete client,facture,intervention from facture,intervention,client
		where client.id='$id' and facture.id_client = client.id and facture.id_intervention=intervention.id and intervention.horaire > '$today' ";
	$connexion->exec( $requete );
	$requete="update facture,intervention set facture.id_client='NULL',intervention.id_client='NULL' where facture.id_client='$id' and facture.id_intervention=intervention.id";
	$connexion->exec( $requete );
}



// /////connection
function getCategorie($id, $mdp) {
	$connexion = getConnect ();
	$requete = "select categorie from employe
	where id='$id'
	and mdp = '$mdp'";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$categorie = $resultat->fetchAll();
	$resultat->closeCursor ();
	return $categorie;
}

// /////directeur
function ajouterMateriel($libele) {
	$connexion = getConnect ();
	$requete = "insert into materiel VALUES('','$libele')";
	$connexion->exec ( $requete );
}
function modifierMateriel($id) {
	$connexion = getConnect ();
	$requete = "update materiel set libele='$libele' where id='$id'";
	$connexion->exec ( $requete );
}
function supprimerMateriel($id) {
	$connexion = getConnect ();
	$requete = "delete materiel,produit from materiel,produit where materiel.id='$id' or produit.id_materiel='$id'";
	$connexion->exec ( $requete );
}
function ajouterProduit($id_produit, $id_materiel) {
	$connexion = getConnect ();
	$requete = "insert into produit VALUES('$id_produit','$id_materiel')";
	$connexion->exec ( $requete );
}
function supprimerProduit($id_produit, $id_materiel) {
	$connexion = getConnect ();
	$requete = "delete produit where id_produit='$id_produit' and id_materiel='$id_materiel'";
	$connexion->exec ( $requete );
}
function creerTypeIntervention($type, $prix) {
	$connexion = getConnect ();
	$requete = "insert into type_intervention VALUES('','$type','$prix')";
	$connexion->exec ( $requete );
	return $connexion->lastInsertId ();
}

function supprimerTypeIntervention($id){
	$today = date ( 'Y/m/d H:i:s' );
	$connexion = getConnect ();
	$requete = "delete facture,intervention,type_intervention,produit from facture,intervention,type_intervention
	where type_intervention.id='$id' and intervention.type=type_intervention.id and facture.id_intervention=intervention.id and intervention.horaire > '$today' and produit.id_produit=type_intervention.id ";
	$connexion->exec( $requete );
	$requete="update intervention set intervention.type='NULL' where intervention.type='$id'";
	$connexion->exec( $requete );
}

function modifierTypeIntervention($id,$type,$prix) {
	$connexion = getConnect ();
	$requete="update type_intervention set type='$type',prix='$prix' where id='$id'";
	$connexion->exec( $requete );
}

function ajouterMecanicien($nom){
	$connexion = getConnect ();
	$requete = "insert into mecanicien VALUES('','$nom')";
	$connexion->exec ( $requete );
}

function getEmployes(){
	$connexion = getConnect ();
	$requete = "select * from employe";
	$resultat = $connexion->query ( $requete );
	$resultat->setFetchMode ( PDO::FETCH_OBJ );
	$employes = $resultat->fetchAll();
	$resultat->closeCursor();
	return $employes;
}

function ajouterEmploye($id,$mdp){
	
}