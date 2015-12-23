<?php
require_once 'controleur/controleur.php';

try {
	if (isset ( $_POST ['connection'] )) {
		$login=$_POST['id'];
		$mdp=$_POST['mdp'];
		ctlConnection($login, $mdp);
	}elseif (isset($_POST['modifier_identifiant'])){
		$categorie=$_POST['categorie'];
		$login=$_POST['id'];
		$mdp=$_POST['mdp'];
		ctlModifierIdentifiant($categorie,$login,$mdp);
	}elseif (isset($_POST['ajouter_piece'])){
		$libele=$_POST['libele'];
		ctlAjouterPiece($libele);
	}elseif ($_POST['supprimer_piece']){
		$pieces=$_POST['pieces_sup'];
		ctlSupprimerPiece($pieces);
	}
	
	
	
	
	
	
	
	else {
		ctlAffConnection ();
	}
} catch ( Exception $e ) {
	$msg=$e->getMessage();
	ctlErreur($msg);
}