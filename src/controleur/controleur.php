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
function ctlAffichageMecanicien($edt = array(),$jour=NULL) {
	$mecaniciens = getMecanicien ();
	affichageMecanicien ( $mecaniciens, $edt,$jour);
}
function ctlAffichageAgent() {
	affichageAgent ();
}

// ///////////////////////MECANICIEN///////////////////////////////////////
function consulterEDT($idMecanicien, $jour) {
	$jour = date_create_from_format ( 'Y/m/d', $jour );
	$semaine = date_format ( $jour, 'W' );
	$annee = date_format ( $jour, 'Y' );
	$edt = edtMecanicien ( $idMecanicien, $semaine-1, $annee );	
	ctlAffichageMecanicien ( $edt,$jour );
}
// //////////////////////////////////////////////////////////////////////
// ///////////////////////DIRECTEUR//////////////////////////////////////
// employe
function ctlModifierEmploye($lastLogin, $categorie, $login, $mdp) {
	if (empty ( $lastLogin ) || empty ( $categorie ) || empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( "login précedent categorie ou login ou mdp vide" );
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