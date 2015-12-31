<?php
function affichageConnection() {
	$contenuAffichage = '
			<form method="post" action="index.php">
			<fieldset>
			<legend>Connexion</legend>
			<p><label for="id">Identifiant</label><input type="text" name="id" id="id" required/></p>
			<p><label for="mdp">Mot de passe</label><input type="password" name="mdp" id="mdp" required/></p>
			<p><input type="submit" name="connection" value="Connection"/></p>
			</fieldset>
			</form>';
	require_once 'vue/gabarit.php';
}
function affDeconexion() {
	return '<p><a href="index.php">Deconexion</a></p>';
}
// ///////////////////////////////////DIRECTEUR
function affichageDirecteur($employes, $mecaniciens, $pieces, $typeIntervention, $produits) {
	$contenuAffichage = affDeconexion ();
	
	$contenuAffichage .= affAjouterEmploye ();
	$contenuAffichage .= affModifierEmployer ( $employes );
	$contenuAffichage .= affSupprimerEmployer ( $employes );
	
	$contenuAffichage .= affAjouterMecanicien ();
	$contenuAffichage .= affModifierMecanicien ( $mecaniciens );
	$contenuAffichage .= affSupprimerMecanicien ( $mecaniciens );
	
	$contenuAffichage .= affAjouterPiece ();
	$contenuAffichage .= affModifierPiece ( $pieces );
	$contenuAffichage .= affSupprimerPiece ( $pieces );
	
	$contenuAffichage .= affAjouterTypeIntervention ( $pieces );
	$contenuAffichage .= affModifierTypeIntervention ( $typeIntervention, $pieces, $produits );
	$contenuAffichage .= affSupprimerTypeIntervention ( $typeIntervention );
	
	require_once 'gabarit.php';
}

// ///////////////GESTION EMPLOYE
function affAjouterEmploye() {
	return '<form method="post" action="index.php">
						<fieldset>
						<legend>Créer employe</legend>
			<p><label>Categorie :</label>
			<select  name="categorie" required/> 
			<option value="agent" selected="selected">Agent</option>
			<option value="mecanicien">Mecanicien</option>
			<option value="directeur">Directeur</option>
			</select>
			<label>Login :</label><input type="text" name="id"  required/>
			<label>Mot de passe :</label><input type="text" name="mdp" required/></p>
			<p><input type="submit" value="Ajouter" name="cree_employe"/></p>
			</fieldset>
			</form>';
}
function affModifierEmployer($employes) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Modifier identifiant</legend>';
	
	foreach ( $employes as $employe ) {
		$contenuAffichage .= '<p><label>Categorie :</label>
			<select  name="categorie[' . $employe->id . ']" required/>
			<option value="agent" ' . (($employe->categorie == 'agent') ? 'selected="selected"' : '') . ' >Agent</option>
			<option value="mecanicien" ' . (($employe->categorie == 'mecanicien') ? 'selected="selected"' : '') . ' >Mecanicien</option>
			<option value="directeur" ' . (($employe->categorie == 'directeur') ? 'selected="selected"' : '') . ' >Directeur</option>
			</select>
			<label>Login :</label><input type="text" name="id[' . $employe->id . ']" value="' . $employe->id . '" required/>
				<label>Mot de passe :</label><input type="text" name="mdp[' . $employe->id . ']" value="' . $employe->mdp . '" required/>
					</p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Modifier" name="modifier_employe"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affSupprimerEmployer($employes) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Supprimer identifiant</legend>';
	
	foreach ( $employes as $employe ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $employe->id . '"><label>Categorie :</label><input type="text" value="' . $employe->categorie . '" readonly="readonly" />
			<label>Login :</label><input type="text" name="id[]" value="' . $employe->id . '" readonly="readonly" />
					</p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Supprimer" name="supprimer_employe"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
// ////GESTION PIECES
function affAjouterPiece() {
	return '<form method="post" action="index.php">
			<fieldset>
			<legend>Créer pièce</legend>
			<p><label>Libelé :</label><input type="text" name="libele" required/><p>
			<p><input type="submit" value="Ajouter" name="ajouter_piece"/></p>
			</fieldset>
			</form>';
}
function affModifierPiece($pieces) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Modifier pièce</legend>';
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><label>libellé :</label><input type="text" name="libele[' . $piece->id . ']" value="' . $piece->libele . '" required/></p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Modifier" name="modifier_piece"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affSupprimerPiece($pieces) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer pièce</legend>';
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $piece->id . '"/><label>' . $piece->libele . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Supprimer" name="supprimer_piece"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// ///////////////GESTION MECANICIEN
function affAjouterMecanicien() {
	return '<form method="post" action="index.php">
						<fieldset>
						<legend>Créer mecanicien</legend>
			<p><label>Nom :</label><input type="text" name="nom"  required/></p>
			<p><input type="submit" value="Ajouter" name="cree_mecanicien"/></p>
			</fieldset>
			</form>';
}
function affModifierMecanicien($mecaniciens) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Modifier mécanicien</legend>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<p><label>Nom :</label><input type="text" name="noms[' . $mecanicien->id . ']" value="' . $mecanicien->nom . '" required/></p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Modifier" name="modifier_mecanicien"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affSupprimerMecanicien($mecaniciens) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer Mécanicien</legend>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $mecanicien->id . '"/><label>' . $mecanicien->nom . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Supprimer" name="supprimer_mecanicien"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// //////GESTION TYPE INTERVENTION
function affAjouterTypeIntervention($pieces) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Créer type intervention</legend>
			<p><label>Type :</label><input type="text" name="type"  required/>
			<label>Prix :</label><input type="number" name="prix" min="0" step="0.01" required/></p>';
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="checkbox" name="lier[]" value="' . $piece->id . '"/><label>' . $piece->libele . '</label></p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Ajouter" name="cree_type_intervention"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affModifierTypeIntervention($interventions, $pieces, $produits) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Modifier type intervention</legend>';
	foreach ( $interventions as $intervention ) {
		$contenuAffichage .= '<p><label>Type :</label><input type="text" name="intervention[' . $intervention->id . '][type]" value="' . $intervention->type . '" required/>
			<label>Prix :</label><input type="number" name="intervention[' . $intervention->id . '][prix]" min="0" step="0.01"  value="' . $intervention->prix . '" required/></p>';
		foreach ( $pieces as $piece ) {
			$contenuAffichage .= '<p><input type="checkbox" name="intervention[' . $intervention->id . '][lier][]" value="' . $piece->id . '" ' . (isset ( $produits [$intervention->id] ) ? ((in_array ( $piece->id, $produits [$intervention->id] )) ? 'checked="checked"' : '') : '') . '   /><label>' . $piece->libele . '</label></p>';
		}
	}
	$contenuAffichage .= '<p><input type="submit" value="Modifier" name="modifier_type_intervention"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affSupprimerTypeIntervention($interventions) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer type intervention</legend>';
	
	foreach ( $interventions as $intervention ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $intervention->id . '"/><label>' . $intervention->type . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Supprimer" name="supprimer_type_intervention"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// ///////////////////////////////AGENT
function affichageAgent($clients, $client = null, $mecaniciens = null, $idMecanicien = null, $jour = null, $edt = null, $types, $factures = NULL, $attente = NULL, $piece = null, $impaye = null, $payer = NULL) {
	$contenuAffichage = affDeconexion ();
	$contenuAffichage .= affAjouterClient ();
	$contenuAffichage .= affChoixEDT ( $mecaniciens, $idMecanicien, $jour, TRUE, ! empty ( $client ) ? $client [0]->id : null );
	if (isset ( $edt )) {
		$contenuAffichage .= affEDT ( $edt, $jour, true );
	}
	$contenuAffichage .= affRechercheClient ( $clients, $idMecanicien, $jour );
	if (! empty ( $client )) {
		$contenuAffichage .= affModifierClient ( $client [0], $idMecanicien, $jour );
		$contenuAffichage .= affSyntheseClient ( $client, $impaye, $payer );
		
		if (! empty ( $factures )) {
			$contenuAffichage .= affPayerIntervention ( $factures, $jour, $idMecanicien, $client [0]->id );
		}
	}
	if (! empty ( $client ) and ! empty ( $idMecanicien )) {
		$contenuAffichage .= affPlanificationIntervention ( $types, $idMecanicien, $client [0]->id, $jour );
	}
	if (! empty ( $attente )) {
		$contenuAffichage .= affInterventionEnAttente ( $attente, $jour, $idMecanicien, $client [0]->id, $client [0]->credit - $impaye [0]->impayer, $piece );
	}
	require_once 'gabarit.php';
}
function affAjouterClient() {
	return '<form method="post" action="index.php">
						<fieldset>
						<legend>Créer client</legend>
			<p><label>Nom :</label><input type="text" name="nom"  required/><label>Prénom :</label><input type="text" name="prenom"  required/><label>Date de naissance :</label><input type="text" name="naissance" placeholder="aaaa-mm-jj"  pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required /><label>Adresse :</label><input type="text" name="adresse"  required/><label>Numéro de téléphone :</label><input type="tel" name="num" pattern="^0[0-9]{9}$" required/><label>Crédit :</label><input type="number" name="credit" min="0" step="0.01"  required/></p>
			<p><input type="submit" value="Ajouter" name="cree_client"/></p>
			</fieldset>
			</form>';
}
function affModifierClient($client, $idMecanicien = null, $jour = null) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Modifier client</legend>
			<input type="hidden" name="idClient" value="' . $client->id . '" />
					<input type="hidden" value="' . $idMecanicien . '" name ="idMecanicien"/>
					<input type="hidden" value="' . $jour . '" name="jour" />
			<p><label>Nom :</label><input type="text" name="nom" value="' . $client->nom . '"  required/><label>Prénom :</label><input type="text" name="prenom" value="' . $client->prenom . '" required/><label>Date de naissance :</label><input type="text" name="naissance" value="' . $client->date_naissance . '" placeholder="aaaa-mm-jj"  pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required /><label>Adresse :</label><input type="text" name="adresse" value="' . $client->adresse . '" required/><label>Numéro de téléphone :</label><input type="tel" name="num" pattern="^[0-9]{10}$" value="' . $client->num_tel . '" required/><label>Crédit :</label><input type="number" name="credit" min="0" step="0.01" value="' . $client->credit . '" required/></p>
			<p><input type="submit" value="Modifier" name="modifier_client"/></p>
					</fieldset>
			</form>';
	return $contenuAffichage;
}
function affPlanificationIntervention($types, $idMecanicien, $idClient, $jour) {
	$contenuAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Programmer une intervention</legend>
			<input type="hidden" name="idMecanicien" value="' . $idMecanicien . '"/>
			<input type="hidden" name="idClient" value="' . $idClient . '"/>
					<input type="hidden" name="jour" value="' . $jour . '"/>
	<p><label>Type d\'intervention :</label><select name="type" >';
	foreach ( $types as $type ) {
		$contenuAffichage .= '<option value="' . $type->id . '" >' . $type->type . '</option>';
	}
	$contenuAffichage .= '</select>
			<label>Date :</label><input type="text" name="date" placeholder="aaaa-mm-jj"  pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required/><label>Heure :</label><input type="number" min="0" 
															23" step="1" name="heure" required></p>
			<p><input type="submit" value="Programmer" name="planifier_intervention"/></p>
			</fieldset></form>';
	return $contenuAffichage;
}
function affRechercheClient($clients, $idMecanicien = null, $jour = null) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Consulter client</legend>
			<p><label>Nom :</label>
			<input type="hidden" value="' . $idMecanicien . '" name ="idMecanicien"/>
					<input type="hidden" value="' . $jour . '" name="jour" />
			<input list="nom" name="nom" required/>
				<label>Prénom :</label>
			<input list="prenom" name="prenom" required/>
				<label>Date de naissance :</label>
			<input type="text" name="naissance" placeholder="aaaa-mm-jj"  pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required/></p>
				<datalist id="nom">';
	
	foreach ( $clients as $client ) {
		$contenuAffichage .= '<option value="' . $client->nom . '" >' . $client->nom . '</option>';
	}
	$contenuAffichage .= '</datalist> <datalist id="prenom">';
	foreach ( $clients as $client ) {
		$contenuAffichage .= '<option value="' . $client->prenom . '" >' . $client->prenom . '</option>';
	}
	$contenuAffichage .= '</datalist><p><input type="submit" value="Chercher" name="chercher_client"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
function affPayerIntervention($interventions, $jour, $idMecanicien, $idClient) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Payer intervention</legend>
			<input type="hidden" name="idMecanicien" value="' . $idMecanicien . '"/>
			<input type="hidden" name="idClient" value="' . $idClient . '"/>
					<input type="hidden" name="jour" value="' . $jour . '"/>';
	
	foreach ( $interventions as $intervention ) {
		$contenuAffichage .= '<p><input type="checkbox" name="paye[]" value="' . $intervention->id . '"><label>Type :</label><input type="text" value="' . $intervention->type . '" readonly="readonly" /><label>Prix :</label><input type="text" value="' . $intervention->prix . '" readonly="readonly" /><label>Horaire :</label><input type="text" value="' . $intervention->horaire . '" readonly="readonly" />
					</p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Payer" name="payer_intervention"/></p>
			</fieldset>
			</form>';
	return $contenuAffichage;
}
function affInterventionEnAttente($interventions, $jour, $idMecanicien, $idClient, $credit, $piece) {
	$contenuAffichage = '';
	foreach ( $interventions as $intervention ) {
		$solde = $credit - $intervention->prix;
		$contenuAffichage .= '<form method="post" action="index.php">
						<fieldset>
						<legend>En attente de payment</legend>
				<input type="hidden" name="idMecanicien" value="' . $idMecanicien . '"/>
			<input type="hidden" name="idClient" value="' . $idClient . '"/>
					<input type="hidden" name="jour" value="' . $jour . '"/>
					<input type="hidden" name="paye[]" value="' . $intervention->id . '"/>		
							<p><label>Type :</label><input type="text" value="' . $intervention->type . '" readonly="readonly" /><label>Prix :</label><input type="text" value="' . $intervention->prix . '" readonly="readonly" /><label>Horaire :</label><input type="text" value="' . $intervention->horaire . '" readonly="readonly" />
					' . ($solde >= 0 ? '<input type="submit" value="Différer" name="differe_intervention"/>' : '') . '<input type="submit" value="Payer" name="payer_intervention"/></p><ul>';
		if (! empty ( $piece [$intervention->id] )) {
			foreach ( $piece [$intervention->id] as $p ) {
				$contenuAffichage .= '<li>' . $p->libele . '</li>';
			}
		}
		$contenuAffichage .= '</ul></fieldset></form>';
	}
	return $contenuAffichage;
}
// //////////////////////////////////////////
// ///////////////////////////////MECANICIEN
function affichageMecanicien($mecaniciens, $edt, $jour, $id, $intervention, $client, $impayer, $interventions) {
	$contenuAffichage = affDeconexion ();
	$contenuAffichage .= affChoixEDT ( $mecaniciens, $id, $jour );
	if (! empty ( $jour )) {
		$contenuAffichage .= affEDT ( $edt, $jour );
		$contenuAffichage .= affReservationFormation ( $id, $jour );
	}
	
	if (! empty ( $intervention )) {
		$contenuAffichage .= affSyntheseClient ( $client, $impayer, $interventions );
		$contenuAffichage .= affInterventionMecanicien ( $intervention );
	}
	
	require_once 'gabarit.php';
}
function affChoixEDT($mecaniciens, $id, $jour, $agent = FALSE, $idClient = null) {
	$jour = date_create_from_format ( 'Y/m/d', $jour );
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Consulter emploi du temps</legend>
			<input type="hidden" value="' . $idClient . '" name="idClient"/>
			<p><label>Nom du mecanicien :</label>
			<select  name="idMecanicien" required/>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<option value="' . $mecanicien->id . '" ' . (($mecanicien->id == $id) ? 'selected="selected"' : '') . '>' . $mecanicien->nom . '</option>';
	}
	$contenuAffichage .= '</select>
			<label>Jour :</label><input type="text" name="jour" placeholder="aaaa-mm-jj" value="' . (! empty ( $jour ) ? date_format ( $jour, 'Y-m-d' ) : date ( 'Y-m-d' )) . '" pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required/></p>
			<p><input type="submit" value="Consulter" name="consulter_employe_du_temps_mecanicien' . ($agent ? '_agent' : '') . '"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
function affReservationFormation($idMecanicien, $jour) {
	$contenueAffichage = '<form method="post" action="index.php">
			<fieldset>
			<legend>Ajouter une formation</legend>
									<input type="hidden" name="idMecanicien" value="' . $idMecanicien . '"/>
													<input type="hidden" name="jour" value="' . $jour . '"/>
															<p><label>Jour :</label><input type="text" name="date" placeholder="aaaa-mm-jj"  pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" required/> <label>Heure :</label><input type="number" min="0" 
															23" step="1" name="heure" required></p>
		
							<input type="submit" value="Formation" name="bloquer_formation_mecanicien"/></fieldset></form>';
	return $contenueAffichage;
}
function affEDT($edt, $jour, $agent = FALSE) {
	$tache = 0;
	$jour = date_create_from_format ( 'Y-m-d', $jour );
	$jour = date_format ( $jour, 'Y-m-d' );
	$jour_ = strtotime ( $jour );
	$contenuAffichage = '<table><tr><th></th>';
	for($i = 0; $i < 24; $i ++) {
		$contenuAffichage .= '<th>' . $i . '</th>';
	}
	$contenuAffichage .= '</tr>';
	for($j = 1; $j < 8; $j ++) {
		$rel = $j - intval ( date ( 'N', $jour_ ) );
		$contenuAffichage .= '<tr><th>' . date ( 'd/m', strtotime ( "$rel days", $jour_ ) ) . '</th>';
		for($h = 0; $h < 24; $h ++) {
			$contenuAffichage .= '<td>';
			if ($tache < count ( $edt )) {
				if (date ( 'Y-m-d H', strtotime ( $edt [$tache]->horaire ) ) == date ( 'Y-m-d H', strtotime ( "$rel days $h hours", $jour_ ) )) {
					switch ($edt [$tache]->type) {
						case 'intervention' :
							if ($agent) {
								$contenuAffichage .= "Intervention";
							} else {
								$contenuAffichage .= '<form method="post" action="index.php">
									<input type="hidden" name="intervention" value="' . $edt [$tache]->id_intervention . '"/>
													<input type="hidden" name="jour" value="' . $jour . '"/>
							<input type="submit" value="Intervention" name="consulter_intervention_mecanicien"/></form>';
							}
							break;
						case 'formation' :
							$contenuAffichage .= "Formation";
							break;
					}
					$tache ++;
				}
			}
			$contenuAffichage .= '</td>';
		}
		$contenuAffichage .= '</tr>';
	}
	$contenuAffichage .= '</table>';
	return $contenuAffichage;
}
function affSyntheseClient($client, $impayer, $interventions) {
	$client = $client [0];
	$impayer = empty ( $impayer [0]->impayer ) ? 0 : $impayer [0]->impayer;
	$contenuAffichage = '<p>Synthese client</p>';
	$contenuAffichage .= '<p>Nom : ' . $client->nom . ' Prénom : ' . $client->prenom . ' Date de naissance : ' . $client->date_naissance . '</br>
			Adresse : ' . $client->adresse . ' Numéro de téléphone : ' . $client->num_tel . '</br>
					Crédit maximum : ' . $client->credit . '€ En différé : ' . $impayer . ' € Restant : ' . (intval ( $client->credit ) - intval ( $impayer )) . '€</p>';
	if (! empty ( $interventions )) {
		$contenuAffichage .= '<table><tr><th>Id</th><th>Type d\'intervention</th><th>Mecanicien</th><th>Prix</th><th>Etat</th><th>Date</th></tr>';
		foreach ( $interventions as $intervention ) {
			$contenuAffichage .= '<tr><th>' . $intervention->id . '</th><td>' . $intervention->type . '</td><td>' . $intervention->nom . '</td><td>' . $intervention->prix . '</td><td>' . $intervention->etat . '</td><td>' . $intervention->horaire . '</td></tr>';
		}
		$contenuAffichage .= '</table>';
	}
	return $contenuAffichage;
}
function affInterventionMecanicien($intervention) {
	$inter = $intervention [0];
	$contenuAffichage = '<table><tr><th>Type d\'intervention</th><th>Prix</th><th>Date</th></tr>
			<tr><td>' . $inter->type . '</td><td>' . $inter->prix . '</td><td>' . $inter->horaire . '</td></tr></table><p>Piece nécéssaire</p><ul>';
	foreach ( $intervention as $piece ) {
		$contenuAffichage .= '<li>' . $piece->libele . '</li>';
	}
	$contenuAffichage .= '</ul>';
	return $contenuAffichage;
}
function affichageErreur($msg) {
	$contenuAffichage = $msg;
	require_once 'vue/gabarit.php';
}