<?php
require_once ('modele/modele.php');
require_once ('vue/vue.php');
function ctlConnection($login, $mdp) {
	if (empty ( $login ) || empty ( $mdp )) {
		throw new Exception ( 'login ou mdp vide' );
	} else {
		switch (getCategorie ( $login, $mdp )) {
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
	}
}
function ctlChercherClient() {
}
function ctlAffConnection() {
	affichageConnection ();
}
function ctlModifierIdentifiant($categorie, $login, $mpd) {
	if (empty ( $categorie ) || empty ( $login ) || empty ( $mpd )) {
		throw new Exception ( "categorie ou login ou mdp vide" );
	} else {
		// modification id
	}
	affichageDirecteur ();
}
function ctlAjouterPiece($libele) {
	if (empty ( $libele )) {
		throw new Exception ( 'libele vide' );
	} else {
		// ajouter piece
	}
	affichageDirecteur ();
}
function ctlSupprimerPiece($pieces) {
	foreach ( $pieces as $key => $val ) {
		supprimerPiece ( $val );
	}
	affichageDirecteur ();
}

function ctlErreur($msg){
	affichageErreur($msg);
}