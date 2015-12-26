<?php
require_once 'controleur/controleur.php';

try {
	// connection
	if (isset ( $_POST ['connection'] )) {
		$login = $_POST ['id'];
		$mdp = $_POST ['mdp'];
		ctlConnection ( $login, $mdp );
		/////////////DIRECTEUR///////////////////////
		// employe
	} elseif (isset ( $_POST ['cree_employe'] )) {
		$categorie = $_POST ['categorie'];
		$login = $_POST ['id'];
		$mdp = $_POST ['mdp'];
		ctlCreeEmploye ( $categorie, $login, $mdp );
	} elseif (isset ( $_POST ['modifier_employe'] )) {
		$categorie = $_POST ['categorie'];
		$login = $_POST ['id'];
		$mdp = $_POST ['mdp'];
		ctlModifierEmployes ( $categorie, $login, $mdp );
	} elseif (isset ( $_POST ['supprimer_employe'] )) {
		$supprimer = isset ( $_POST ['supprimer'] ) ? $_POST ['supprimer'] : array ();
		ctlSupprimerEmploye ( $supprimer );
		// piece
	} elseif (isset ( $_POST ['ajouter_piece'] )) {
		$libele = $_POST ['libele'];
		ctlAjouterPiece ( $libele );
	} elseif (isset ( $_POST ['supprimer_piece'] )) {
		$pieces = isset ( $_POST ['supprimer'] ) ? $_POST ['supprimer'] : array ();
		ctlSupprimerPieces ( $pieces );
	} elseif (isset ( $_POST ['modifier_piece'] )) {
		$libele = isset ( $_POST ['libele'] ) ? $_POST ['libele'] : array ();
		ctlModifierPieces ( $libele );
	} // typeIntervention
elseif (isset ( $_POST ['cree_type_intervention'] )) {
		$type = $_POST ['type'];
		$prix = $_POST ['prix'];
		$lien = isset ( $_POST ['lier'] ) ? $_POST ['lier'] : array ();
		ctlCreeTypeIntervention ( $type, $prix, $lien );
	} elseif (isset ( $_POST ['modifier_type_intervention'] )) {
		$interventions = $_POST ['intervention'];
		ctlModifierTypeInterventions ( $interventions );
	} elseif (isset ( $_POST ['supprimer_type_intervention'] )) {
		$supprimer = isset ( $_POST ['supprimer'] ) ? $_POST ['supprimer'] : array ();
		ctlSupprimerTypeInterventions ( $supprimer );
	} elseif (isset ( $_POST ['cree_mecanicien'] )) {
		$nom = $_POST ['nom'];
		ctlAjouterMecanicien ( $nom );
	} elseif (isset ( $_POST ['modifier_mecanicien'] )) {
		$noms = isset ( $_POST ['noms'] ) ? $_POST ['noms'] : array ();
		ctlModifierMecaniciens ( $noms );
	} elseif (isset ( $_POST ['supprimer_mecanicien'] )) {
		$supprimers = isset ( $_POST ['supprimer'] ) ? $_POST ['supprimer'] : array ();
		ctlSupprimerMecaniciens ( $supprimers );
	} 
//////////////////////////////////////////////////////////MECANICIEN
elseif (isset($_POST['consulter_employe_du_temps_mecanicien'])){
	$idMecanicien=$_POST['idMecanicien'];
	$jour=$_POST['jour'];
	consulterEDT($idMecanicien, $jour);
}

	
	
	
	else {
		ctlAffConnection ();
	}
} catch ( Exception $e ) {
	$msg = $e->getMessage ();
	ctlErreur ( $msg );
}