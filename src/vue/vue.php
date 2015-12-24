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
function affichageDirecteur() {
	$contenuAffichage = '<form method="post" action="index.php">
						<fieldset>
						<legend>Cr�e employe</legend>
			<p><label>Categorie :</label>
			<select  name="categorie" required/> 
			<option value="agent" selected="selected">Agent</option>
			<option value="mecanicien">Mecanicien</option>
			<option value="directeur">Directeur</option>
			</select></p>
			<p><label>Login :</label><input type="text" name="id"  required/></p>
			<p><label>Mot de passe :</label><input type="text" name="mdp" required/></p>
			<p><input type="submit" value="Ajouter" name="cree_employe"/></p>
			</fieldset>
			</form>';
	
	$contenuAffichage.='<form method="post" action="index.php">
						<fieldset>
						<legend>Modifier identifiant</legend>';
			
			$employes=getEmployes();
	foreach ($employes as $employe){
		$contenuAffichage.='<p><label>Categorie :</label>
			<select  name="categorie[]" required/> 
			<option value="agent" '.(($employe->categorie='agent') ? 'selected="selected"':'').' >Agent</option>
			<option value="mecanicien" '.(($employe->categorie='mecanicien') ? 'selected="selected"':'').' >Mecanicien</option>
			<option value="directeur" '.(($employe->categorie='directeur') ? 'selected="selected"':'').' >Directeur</option>
			</select>
			<label>Login :</label><input type="text" name="id[]" value="'.$employe->id.'" required/>
				<label>Mot de passe :</label><input type="text" name="mdp[]" value="'.$employe->mdp.'" required/>	
					</p>';
	}
	
	$contenuAffichage.='<p><input type="submit" value="Modifier" name="modifier_employe"/></p>
			</fieldset>
			</form>';
	
	
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Cr�e pi�ce</legend>
			<p><label>Libel� :</label><input type="text" name="libele" required/><p>
			<p><input type="submit" name="ajouter_piece"/></p>
			</fieldset>
			</form>
			';
	
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer pi�ce</legend>';
	
	/*$pieces = getPieces();
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="checkbox" name="pieces_sup[]" value="' . $piece->idProd . '"/><label>' . $piece->libele . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" name="supprimer_piece"/></p>
			</fieldset>
			</form>
			';
	
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Modifier pi�ce</legend>
			<p><label>Libel� :</label><input type="text" name="libele" required/></p>';
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="radio" name="pieces_modifier" value="' . $piece->idProd . '"/><label>' . $piece->libele . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" name="modifier_piece"/></p>
			</fieldset>
			</form>
			';*/
	require_once 'gabarit.php';
}

function affichageErreur($msg){
	$contenuAffichage=$msg;
	require_once 'vue/gabarit.php';
}