<?php
function getConnect() {
	require_once ('connect.php');
	$connexion = new PDO ( 'mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD );
	$connexion->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$connexion->query ( 'SET NAMES UTF8' );
	return $connexion;
}
function ajouterClient($nom, $prenom, $adresse, $numTel, $dateN) {
}
function modifierClient() {
}

function getCategorie($login,$mdp){
	
}