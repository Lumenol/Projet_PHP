<?php
function affichageConnection() {
	$contenuAffichage = '
			<form method="post" action="index.php">
			<fieldset>
			<legend>Connection</legend>
			<p><label for="id">Identifiant</label><input type="text" name="id" id="id" required/></p>
			<p><label for="mdp">Mot de passe</label><input type="password" name="mdp" id="mdp" required/></p>
			<p><input type="submit" name="connection" value="Connection"/></p>
			</fieldset>
			</form>';
	require_once 'vue/gabarit.php';
}
function affDeconexion() {
	return '<p><a href="index.php">Deconection</a></p>';
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
						<legend>Crée employe</legend>
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
			<legend>Crée pièce</legend>
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
		$contenuAffichage .= '<p><label>Libele :</label><input type="text" name="libele[' . $piece->id . ']" value="' . $piece->libele . '" required/></p>';
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
	$contenuAffichage .= '<p><input type="submit" value="Supprier" name="supprimer_piece"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// ///////////////GESTION MECANICIEN
function affAjouterMecanicien() {
	return '<form method="post" action="index.php">
						<fieldset>
						<legend>Crée mecanicien</legend>
			<p><label>Nom :</label><input type="text" name="nom"  required/>
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
			<legend>Supprimer pièce</legend>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $mecanicien->id . '"/><label>' . $mecanicien->nom . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Supprier" name="supprimer_mecanicien"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// //////GESTION TYPE INTERVENTION
function affAjouterTypeIntervention($pieces) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Crée type intervention</legend>
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
			$contenuAffichage .= '<p><input type="checkbox" name="intervention[' . $intervention->id . '][lier][]" value="' . $piece->id . '" ' . (isset($produits[$intervention->id])?((in_array ( $piece->id, $produits [$intervention->id] )) ? 'checked="checked"' : ''):'') . '   /><label>' . $piece->libele . '</label></p>';
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
	$contenuAffichage .= '<p><input type="submit" value="Supprier" name="supprimer_type_intervention"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
// ///////////////////////////////MECANICIEN
function affichageMecanicien($mecaniciens, $edt, $jour,$id,$intervention,$client,$impayer,$interventions) {
	$contenuAffichage = affDeconexion ();
	$contenuAffichage .= affChoixEDT ( $mecaniciens,$id,$jour);
	if (! empty ( $jour )) {
		$contenuAffichage .= affEDT ( $edt, $jour );
		$contenuAffichage.=affReservationFormation($id, $jour);
	}

	if(!empty($intervention)){
		$contenuAffichage.=affSyntheseClient($client,$impayer,$interventions);
		$contenuAffichage.=affInterventionMecanicien($intervention);
	}
	
	require_once 'gabarit.php';
}
function affChoixEDT($mecaniciens,$id,$jour) {
	$jour = date_create_from_format ( 'Y/m/d', $jour );
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Consulter emploie du temps</legend>
			<p><label>Nom du mecanicien :</label>
			<select  name="idMecanicien" required/>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<option value="' . $mecanicien->id . '" '.(($mecanicien->id==$id)?'selected="selected"':'').'>' . $mecanicien->nom . '</option>';
	}
	$contenuAffichage .= '</select>
			<label>Jour :</label><input type="date" name="jour" placeholder="aaaa/mm/jj" value="'.(!empty($jour)? date_format($jour,'Y/m/d'):date('Y/m/d')).'" pattern="^[0-9]{4}/[0-9]{2}/[0-9]{2}$" required/></p>
			<p><input type="submit" value="Consulter" name="consulter_employe_du_temps_mecanicien"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
function affReservationFormation($idMecanicien,$jour){
$contenueAffichage='<form method="post" action="index.php">
									<input type="hidden" name="idMecanicien" value="'.$idMecanicien.'"/>
													<input type="hidden" name="jour" value="'.$jour.'"/>
															<p><label>Jour :</label><input type="date" name="date" placeholder="aaaa/mm/jj"  pattern="^[0-9]{4}/[0-9]{2}/[0-9]{2}$" required/> <label>Heure :</label><input type="number" min="0" max="23" step="1" name="heure" required></p>
		
							<input type="submit" value="Formation" name="bloquer_formation_mecanicien"/></form>';
return $contenueAffichage;
}
function affEDT($edt, $jour) {
	$tache = 0;
	$jour = date_create_from_format ( 'Y/m/d', $jour );
	$jour=date_format ( $jour, 'Y/m/d' );
	$jour_ = strtotime ( $jour) ;
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
				if (date ( 'Y/m/d H', strtotime ( $edt [$tache]->horaire ) ) == date ( 'Y/m/d H', strtotime ( "$rel days $h hours", $jour_ ) )) {
					switch ($edt [$tache]->type) {
						case 'intervention' :
							$contenuAffichage .= '<form method="post" action="index.php">
									<input type="hidden" name="intervention" value="'.$edt[$tache]->id_intervention.'"/>
													<input type="hidden" name="jour" value="'.$jour.'"/>
							<input type="submit" value="Intervention" name="consulter_intervention_mecanicien"/></form>';
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

function affSyntheseClient($client,$impayer,$interventions){
	$client=$client[0];
	$contenuAffichage='<p>Nom : '.$client->nom.' Prénom : '.$client->prenom.' Date de naissance : '.$client->date_naissance.'</br>
			Addresse : '.$client->adresse.' Numéro de téléphone : '.$client->num_tel.'</br>
					Crédit maximum : '.$client->credit.'€ Impayer : '.$impayer[0]->impayer.'€ Restant : '.(intval($client->credit)-intval($impayer[0]->impayer)).'€</p>';
	$contenuAffichage.='<table><tr><th>Id</th><th>Type d\'intervention</th><th>Mecanicien</th><th>Prix</th><th>Etat</th><th>Date</th></tr>';
	foreach ($interventions as $intervention) {
		$contenuAffichage.='<tr><th>'.$intervention->id.'</th><td>'.$intervention->type.'</td><td>'.$intervention->nom.'</td><td>'.$intervention->prix.'</td><td>'.$intervention->etat.'</td><td>'.$intervention->horaire.'</td></tr>';
	}
	$contenuAffichage.='</table>';
	return $contenuAffichage;
}

function affInterventionMecanicien($intervention){
	$inter=$intervention[0];
	$contenuAffichage='<table><tr><th>Type d\'intervention</th><th>Prix</th><th>Date</th></tr>
			<tr><td>'.$inter->type.'</td><td>'.$inter->prix.'</td><td>'.$inter->horaire.'</td></tr></table><p>Piece nécéssaire</p><ul>';
	foreach ($intervention as $piece){
		$contenuAffichage.='<li>'.$piece->libele.'</li>';
	}
	$contenuAffichage.='</ul>';
	return $contenuAffichage;
}

function affichageErreur($msg) {
	$contenuAffichage = $msg;
	require_once 'vue/gabarit.php';
}