<?php
require_once ('modele/modele.php');
require_once ('vue/vue.php');
// ////////////////////// connection
function ctlConnection($login, $mdp) {
	if (empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( 'login ou mdp vide' );
	} else {
		$categorie = getCategorie ( $login, $mdp );
		if (! empty ( $categorie )) {
			switch ($categorie [0]->categorie) {
				case 'directeur' :
					ctlAffichageDirecteur ();
					break;
				case 'mecanicien' :
					ctlAffichageMecanicien ();
					break;
				
				case 'agent' :
					ctlAffichageAgent ();
					break;
				
				default :
					affichageConnection ();
					break;
			}
		} else {
			affichageConnection ();
		}
	}
}
function ctlAffConnection() {
	affichageConnection ();
}
function ctlAffichageDirecteur() {
	$employes = getEmployes ();
	$mecaniciens = getMecanicien ();
	$pieces = getPieces ();
	$typeIntervention = getTypeIntervention ();
	$produit = getProduit ();
	$produits = array ();
	foreach ( $produit as $p ) {
		if (! array_key_exists ( $p->id_produit, $produits )) {
			$produits [$p->id_produit] = array ();
		}
		array_push ( $produits [$p->id_produit], $p->id_materiel );
	}
	affichageDirecteur ( $employes, $mecaniciens, $pieces, $typeIntervention, $produits );
}
function ctlAffichageMecanicien($edt = NULL, $jour = NULL, $idMecanicien = NULL, $intervention = NULL, $client = NULL, $impayer = NULL, $interventions = NULL) {
	$mecaniciens = getMecanicien ();
	affichageMecanicien ( $mecaniciens, $edt, $jour, $idMecanicien, $intervention, $client, $impayer, $interventions );
}
function ctlAffichageAgent($client = NULL, $idMecanicien = NULL, $jour = NULL) {
	$jour = empty ( $jour ) ? date ( 'Y-m-d' ) : $jour;
	$clients = getClients ();
	$mecaniciens = getMecanicien ();
	$types = getTypeIntervention ();
	$edt = (! empty ( $idMecanicien ) ? ctlGetEDT ( $idMecanicien, $jour ) : null);
	$facture = empty ( $client ) ? null : getInterventionClientEtat ( $client, 'en différé' );
	$attente = empty ( $client ) ? null : getInterventionClientEtat ( $client, 'en attente de payment' );
	$payer = empty ( $client ) ? null : getInterventionClientEtat ( $client, 'payée' );
	$piece = null;
	if (! empty ( $attente )) {
		foreach ( $attente as $val ) {
			$piece [$val->id] = getMaterielIntervention ( $val->id );
		}
	}
	$impaye = empty ( $client ) ? null : getSommeImpayer ( $client );
	if (! empty ( $client )) {
		$client = getInformationClient ( $client );
	}
	affichageAgent ( $clients, $client, $mecaniciens, $idMecanicien, $jour, $edt, $types, $facture, $attente, $piece, $impaye, $payer );
}
// /////////////////////////AGENT/////////////////////
function ctlAjouterClient($nom, $prenom, $dateN, $adresse, $num, $credit) {
	$d = explode ( '-', $dateN );
	if (checkdate ( $d [1], $d [2], $d [0] )) {
		ajouterClient ( $nom, $prenom, $adresse, $num, $dateN, $credit );
	}
	ctlAffichageAgent ();
}
function ctlChercherClient($nom, $prenom, $dateN, $jour = null, $idMecanicien = null) {
	$client = chercherClient ( $nom, $prenom, $dateN );
	$client = empty ( $client ) ? null : $client [0]->id;
	ctlAffichageAgent ( $client, $idMecanicien, $jour );
}
function ctlModifierClient($id, $nom, $prenom, $dateN, $adresse, $num, $credit, $jour, $idMecanicien) {
	$d = explode ( '-', $dateN );
	if (checkdate ( $d [1], $d [2], $d [0] )) {
		modifClient ( $id, $nom, $prenom, $adresse, $num, $dateN, $credit );
	}
	ctlAffichageAgent ( $id, $idMecanicien, $jour );
}
function ctlDiffereIntervention($differe, $idMecanicien, $idClient, $jour) {
	foreach ( $differe as $id ) {
		differeFacture ( $id );
	}
	ctlAffichageAgent ( $idClient, $idMecanicien, $jour );
}
function ctlPlaniffierIntervention($idClient, $type, $idMecanicien, $date, $heure, $jour) {
	$d = explode ( '-', $date );
	$horaire = $date . ' ' . $heure;
	if (checkdate ( $d [1], $d [2], $d [0] ) and empty ( isDisponible ( $idMecanicien, $horaire ) )) {
		$id = ajouterIntervention ( $idMecanicien, $horaire, $idClient, $type );
		ajouterInterventionEdt ( $idMecanicien, $id, $horaire );
		nouvelleFacture ( $id, $idClient );
	}
	ctlAffichageAgent ( $idClient, $idMecanicien, $jour );
}
function ctlPayerInterventions($payer, $id_Mecanicien, $id_Client, $jour) {
	foreach ( $payer as $id ) {
		payerIntervention ( $id );
	}
	ctlAffichageAgent ( $id_Client, $id_Mecanicien, $jour );
}
// ///////////////////////MECANICIEN///////////////////////////////////////
function ctlConsulterEDT($idMecanicien, $jour) {
	$edt = (! empty ( $idMecanicien ) ? ctlGetEDT ( $idMecanicien, $jour ) : null);
	ctlAffichageMecanicien ( $edt, $jour, $idMecanicien );
}
function ctlGetEDT($idMecanicien, $jour) {
	$jour = date_create_from_format ( 'Y-m-d', $jour );
	$semaineA = date_format ( $jour, 'W' );
	$anneeA = date_format ( $jour, 'Y' );
	$jour->add ( new DateInterval ( 'P7D' ) );
	$semaineB = date_format ( $jour, 'W' );
	$anneeB = date_format ( $jour, 'Y' );
	return edtMecanicien ( $idMecanicien, $semaineA - 1, $anneeA, $semaineB - 1, $anneeB );
}
function ctlConsulterInterventionMecanicien($jour, $idIntervention) {
	$intervention = getIntervention ( $idIntervention );
	$client = getInformationClient ( $intervention [0]->id_client );
	$impayer = getSommeImpayer ( $intervention [0]->id_client );
	$interventions = getInterventionClient ( $intervention [0]->id_client );
	$idMecanicien = $intervention [0]->id_mecanicien;
	$edt = ctlGetEDT ( $idMecanicien, $jour );
	
	ctlAffichageMecanicien ( $edt, $jour, $idMecanicien, $intervention, $client, $impayer, $interventions );
}
function ctlBloquerFormation($date, $heure, $jour, $idMecanicien) {
	$d = explode ( '-', $date );
	$date .= ' ' . $heure . ':00:00';
	
	if (checkdate ( $d [1], $d [2], $d [0] ) && empty ( isDisponible ( $idMecanicien, $date ) )) {
		$id = ajouterFormation ( $idMecanicien, $date );
		ajouterFormationEdt ( $idMecanicien, $id, $date );
	}
	$edt = ctlGetEDT ( $idMecanicien, $jour );
	ctlAffichageMecanicien ( $edt, $jour, $idMecanicien );
}

// //////////////////////////////////////////////////////////////////////
// ///////////////////////DIRECTEUR//////////////////////////////////////
// employe
function ctlModifierEmploye($lastLogin, $categorie, $login, $mdp) {
	if (empty ( $lastLogin ) || empty ( $categorie ) || empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( "login pr�cedent categorie ou login ou mdp vide" );
	} else {
		modifierEmploye ( $lastLogin, $login, $mdp, $categorie );
	}
}
function ctlModifierEmployes($categorie, $login, $mdp) {
	if (! empty ( $categorie ) && (empty ( $login ) || empty ( $mdp ))) {
		throw new Exception ( "categorie ou login ou mdp vide" );
	} else {
		foreach ( $categorie as $key => $val ) {
			ctlModifierEmploye ( $key, $categorie [$key], $login [$key], $mdp [$key] );
		}
	}
	ctlAffichageDirecteur ();
}
function ctlCreeEmploye($categorie, $login, $mdp) {
	if (empty ( $categorie ) || empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( "categorie ou login ou mdp vide" );
	} else {
		// creeEmploye
		
		ajouterEmploye ( $login, $mdp, $categorie );
	}
	ctlAffichageDirecteur ();
}
function ctlSupprimerEmployes($id) {
	foreach ( $id as $key => $val ) {
		ctlSupprimerEmploye ( $val );
	}
	ctlAffichageDirecteur ();
}
function ctlSupprimerEmploye($id) {
	if (! empty ( $id )) {
		// supprimerEmploye
		supprimerEmploye ( $id );
	}
}
// piece
function ctlModifierPieces($libele) {
	foreach ( $libele as $key => $val ) {
		ctlModifierPiece ( $key, $val );
	}
	ctlAffichageDirecteur ();
}
function ctlModifierPiece($id, $libele) {
	if (empty ( $id ) || empty ( $libele )) {
		throw new Exception ( "id ou libele vide" );
	} else {
		modifierMateriel ( $id, $libele );
	}
}
function ctlAjouterPiece($libele) {
	if (empty ( $libele )) {
		throw new Exception ( 'libele vide' );
	} else {
		// ajouter piece
		ajouterMateriel ( $libele );
	}
	ctlAffichageDirecteur ();
}
function ctlSupprimerPieces($pieces) {
	foreach ( $pieces as $key => $val ) {
		supprimerMateriel ( $val );
	}
	ctlAffichageDirecteur ();
}
// typeIntervention
function ctlCreeTypeIntervention($type, $prix, $lien) {
	if (empty ( $type )) {
		throw new Exception ( "type vide" );
	} else {
		$id = creerTypeIntervention ( $type, $prix );
		ctlModifierProduitLier ( $id, $lien );
	}
	ctlAffichageDirecteur ();
}
function ctlModifierProduitLier($idTypeIntervention, $produits) {
	if (empty ( $idTypeIntervention )) {
		throw new Exception ( 'idTypeIntervention est vide' );
	} else {
		$pieces = getPieces ();
		foreach ( $pieces as $piece ) {
			if (in_array ( $piece->id, $produits )) {
				
				ajouterProduit ( $idTypeIntervention, $piece->id );
			} else {
				supprimerProduit ( $idTypeIntervention, $piece->id );
			}
		}
	}
}
function ctlModifierTypeInterventions($interventions) {
	foreach ( $interventions as $key => $val ) {
		ctlModifierTypeIntervention ( $key, $interventions [$key] ['type'], $interventions [$key] ['prix'], isset ( $interventions [$key] ['lier'] ) ? $interventions [$key] ['lier'] : array () );
	}
	ctlAffichageDirecteur ();
}
function ctlModifierTypeIntervention($id, $type, $prix, $materiel) {
	if (empty ( $type )) {
		throw new Exception ( 'type vide' );
	} else {
		modifierTypeIntervention ( $id, $type, $prix );
		ctlModifierProduitLier ( $id, $materiel );
	}
}
function ctlSupprimerTypeInterventions($supprimer) {
	foreach ( $supprimer as $key => $val ) {
		supprimerTypeIntervention ( $val );
	}
	ctlAffichageDirecteur ();
}
// mecanicien
function ctlAjouterMecanicien($nom) {
	if (empty ( $nom )) {
		throw new Exception ( 'nom vide' );
	} else {
		ajouterMecanicien ( $nom );
	}
	ctlAffichageDirecteur ();
}
function ctlModifierMecaniciens($noms) {
	foreach ( $noms as $key => $val ) {
		modifierMecanicien ( $key, $val );
	}
	ctlAffichageDirecteur ();
}
function ctlModifierMecanicien($id, $nom) {
	if (empty ( $id ) || empty ( $nom )) {
		throw new Exception ( "id ou nom vide" );
	} else {
		modifierMecanicien ( $id, $nom );
	}
}
function ctlSupprimerMecaniciens($supprimers) {
	foreach ( $supprimers as $sup ) {
		supprimerMecanicien ( $sup );
	}
	ctlAffichageDirecteur ();
}

// /////////////////////////////////////////////////////////////////////////
// erreur
function ctlErreur($msg) {
	affichageErreur ( $msg );
}