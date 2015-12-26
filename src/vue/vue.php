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
			$contenuAffichage .= '<p><input type="checkbox" name="intervention[' . $intervention->id . '][lier][]" value="' . $piece->id . '" ' . ((in_array ( $piece->id, $produits [$intervention->id] )) ? 'checked="checked"' : '') . '   /><label>' . $piece->libele . '</label></p>';
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
function affichageMecanicien($mecaniciens, $edt, $jour) {
	$contenuAffichage = affDeconexion ();
	$contenuAffichage .= affChoixEDT ( $mecaniciens );
	if (! empty ( $jour )) {
		$contenuAffichage .= affEDT ( $edt, $jour );
	}
	require_once 'gabarit.php';
}
function affChoixEDT($mecaniciens) {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Consulter emploie du temps</legend>
			<p><label>Nom du mecanicien :</label>
			<select  name="idMecanicien" required/>';
	
	foreach ( $mecaniciens as $mecanicien ) {
		$contenuAffichage .= '<option value="' . $mecanicien->id . '" >' . $mecanicien->nom . '</option>';
	}
	$contenuAffichage .= '</select>
			<label>Jour :</label><input type="date" name="jour" placeholder="aaaa/mm/jj" pattern="^[0-9]{4}/[0-9]{2}/[0-9]{2}$" required/></p>
			<p><input type="submit" value="Consulter" name="consulter_employe_du_temps_mecanicien"/></p>
			</fieldset>
			</form>
			';
	return $contenuAffichage;
}
function affEDT($edt, $jour) {
	$tache = 0;
	$jour = strtotime ( date_format ( $jour, 'Y/m/d' ) );
	$contenuAffichage = '<table><tr><th></th>';
	for($i = 0; $i < 24; $i ++) {
		$contenuAffichage .= '<th>' . $i . '</th>';
	}
	$contenuAffichage .= '</tr>';
	for($j = 1; $j < 8; $j ++) {
		$rel = $j - intval ( date ( 'N', $jour ) );
		$contenuAffichage .= '<tr><th>' . date ( 'd/m', strtotime ( "$rel days", $jour ) ) . '</th>';
		for($h = 0; $h < 24; $h ++) {
			$contenuAffichage .= '<td>';
			if ($tache < count ( $edt )) {
				if (date( 'Y/m/d H',strtotime($edt [$tache]->horaire) ) == date ( 'Y/m/d H', strtotime ( "$rel days $h hours", $jour ) )) {
					$contenuAffichage .= $edt [$tache]->type;
					$tache ++;
				}
			}
			$contenuAffichage .= '</td>';
		}
		$contenuAffichage .= '</tr>';
	}
	return $contenuAffichage;
}
function affichageErreur($msg) {
	$contenuAffichage = $msg;
	require_once 'vue/gabarit.php';
}