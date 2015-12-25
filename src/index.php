<?php
require_once 'controleur/controleur.php';

try {
	//connection
	if (isset ( $_POST ['connection'] )) {
		$login=$_POST['id'];
		$mdp=$_POST['mdp'];
		ctlConnection($login, $mdp);
		//employe
	}elseif (isset($_POST['cree_employe'])){
		$categorie=$_POST['categorie'];
		$login=$_POST['id'];
		$mdp=$_POST['mdp'];
		ctlCreeEmploye($categorie,$login,$mdp);
	}elseif (isset($_POST['modifier_employe'])){
		$categorie=$_POST['categorie'];
		$login=$_POST['id'];
		$mdp=$_POST['mdp'];
			ctlModifierEmployes($categorie,$login,$mdp);
	}elseif (isset($_POST['supprimer_employe'])){
		$supprimer=$_POST['supprimer'];
		ctlSupprimerEmploye($supprimer);
		//piece
	}elseif (isset($_POST['ajouter_piece'])){
		$libele=$_POST['libele'];
		ctlAjouterPiece($libele);
	}elseif (isset($_POST['supprimer_piece'])){
		$pieces=$_POST['supprimer'];
		ctlSupprimerPieces($pieces);
	}elseif (isset($_POST['modifier_piece'])){
		$libele=$_POST['libele'];
		ctlModifierPieces($libele);
	}
	//typeIntervention
	elseif (isset($_POST['cree_type_intervention'])){
		$type=$_POST['type'];
		$prix=$_POST['prix'];
		$lien=$_POST['lier'];
		ctlCreeTypeIntervention($type,$prix,$lien);
	}elseif (isset($_POST['modifier_type_intervention'])){
		$interventions=$_POST['intervention'];
		ctlModifierTypeInterventions($interventions);
	}elseif (isset($_POST['supprimer_type_intervention'])){
		$supprimer=$_POST['supprimer'];
		ctlSupprimerTypeInterventions($supprimer);
	}
	
	
	
	
	
	
	else {
		ctlAffConnection ();
	}
} catch ( Exception $e ) {
	$msg=$e->getMessage();
	ctlErreur($msg);
}