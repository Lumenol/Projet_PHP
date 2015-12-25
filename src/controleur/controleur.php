<?php
require_once ('modele/modele.php');
require_once ('vue/vue.php');
// connection
function ctlConnection($login, $mdp) {
	if (empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( 'login ou mdp vide' );
	} else {
		$categorie = getCategorie ( $login, $mdp );
		if (! empty ( $categorie )) {
			switch ($categorie [0]->categorie) {
				case 'directeur' :
					affichageDirecteur ();
					break;
				case 'mecanicien' :
					affichageMecanicien ();
					break;
				
				case 'agent' :
					affichageAgent ();
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

// Client
function ctlChercherClient() {
}
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
	affichageDirecteur ();
}
function ctlCreeEmploye($categorie, $login, $mdp) {
	if (empty ( $categorie ) || empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( "categorie ou login ou mdp vide" );
	} else {
		// creeEmploye
		ajouterEmploye ( $login, $mdp, $categorie );
	}
	affichageDirecteur ();
}
function ctlSupprimerEmployes($id) {
	foreach ( $id as $key => $val ) {
		ctlSupprimerEmploye ( $val );
	}
	affichageDirecteur ();
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
	affichageDirecteur ();
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
	affichageDirecteur ();
}
function ctlSupprimerPieces($pieces) {
	foreach ( $pieces as $key => $val ) {
		supprimerMateriel ( $val );
	}
	affichageDirecteur ();
}
// typeIntervention
function ctlCreeTypeIntervention($type, $prix, $lien) {
	if (empty ( $type )) {
		throw new Exception ( "type vide" );
	} else {
		$id = creerTypeIntervention ( $type, $prix );
		echo $id;
		ctlModifierProduitLier ( $id, $lien );
	}
	affichageDirecteur ();
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
		ctlModifierTypeIntervention ( $key, $interventions [$key] ['type'], $interventions [$key] ['prix'], $interventions [$key] ['lier'] );
	}
	affichageDirecteur ();
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
	affichageDirecteur ();
}

// erreur
function ctlErreur($msg) {
	affichageErreur ( $msg );
}