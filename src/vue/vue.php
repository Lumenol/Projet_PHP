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
	//identifiant
	//cree
	$contenuAffichage = '<form method="post" action="index.php">
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
	//modifier
	$contenuAffichage.='<form method="post" action="index.php">
						<fieldset>
						<legend>Modifier identifiant</legend>';
			
			$employes=getEmployes();
	foreach ($employes as $employe){
		$contenuAffichage.='<p><label>Categorie :</label>
			<select  name="categorie['.$employe->id.']" required/> 
			<option value="agent" '.(($employe->categorie=='agent') ? 'selected="selected"':'').' >Agent</option>
			<option value="mecanicien" '.(($employe->categorie=='mecanicien') ? 'selected="selected"':'').' >Mecanicien</option>
			<option value="directeur" '.(($employe->categorie=='directeur') ? 'selected="selected"':'').' >Directeur</option>
			</select>
			<label>Login :</label><input type="text" name="id['.$employe->id.']" value="'.$employe->id.'" required/>
				<label>Mot de passe :</label><input type="text" name="mdp['.$employe->id.']" value="'.$employe->mdp.'" required/>	
					</p>';
	}
	$contenuAffichage.='<p><input type="submit" value="Modifier" name="modifier_employe"/></p>
			</fieldset>
			</form>';
	//supprimer
	$contenuAffichage.='<form method="post" action="index.php">
						<fieldset>
						<legend>Supprimer identifiant</legend>';
		
foreach ($employes as $employe){
		$contenuAffichage.='<p><input type="checkbox" name="supprimer[]" value="'.$employe->id.'"><label>Categorie :</label><input type="text" value="'.$employe->categorie.'" readonly="readonly" />
			<label>Login :</label><input type="text" name="id[]" value="'.$employe->id.'" readonly="readonly" />		
					</p>';
	}
	
	$contenuAffichage.='<p><input type="submit" value="Supprimer" name="supprimer_employe"/></p>
			</fieldset>
			</form>';
	
	//Piece
	//cree
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Crée pièce</legend>
			<p><label>Libelé :</label><input type="text" name="libele" required/><p>
			<p><input type="submit" value="Ajouter" name="ajouter_piece"/></p>
			</fieldset>
			</form>';
//modifier
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Modifier pièce</legend>';
	$pieces = getPieces();
	foreach ($pieces as $piece){
		$contenuAffichage.='<p><label>Libele :</label><input type="text" name="libele['.$piece->id.']" value="'.$piece->libele.'" required/></p>';
	}
	
	$contenuAffichage .= '<p><input type="submit" value="Modifier" name="modifier_piece"/></p>
			</fieldset>
			</form>';
	//supprimer
	$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer pièce</legend>';
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $piece->id . '"/><label>' . $piece->libele . '</label></p>';
	}
	$contenuAffichage .= '<p><input type="submit" value="Supprier" name="supprimer_piece"/></p>
			</fieldset>
			</form>
			';
	//TypeIntervention
	//crée
	$contenuAffichage .= '<form method="post" action="index.php">
						<fieldset>
						<legend>Crée type intervention</legend>
			<p><label>Type :</label><input type="text" name="type"  required/>
			<label>Prix :</label><input type="number" name="prix" min="0" step="0.01" required/></p>';
	
	foreach ( $pieces as $piece ) {
		$contenuAffichage .= '<p><input type="checkbox" name="lier[]" value="' . $piece->id . '"/><label>' . $piece->libele . '</label></p>';
	}
	
			$contenuAffichage.='<p><input type="submit" value="Ajouter" name="cree_type_intervention"/></p>
			</fieldset>
			</form>';
	//modifier
			$contenuAffichage .= '<form method="post" action="index.php">
						<fieldset>
						<legend>Modifier type intervention</legend>';
			$interventions=getTypeIntervention();		
			foreach ($interventions as $intervention){
			$contenuAffichage.='<p><label>Type :</label><input type="text" name="intervention['.$intervention->id.'][type]" value="'.$intervention->type.'" required/>
			<label>Prix :</label><input type="number" name="intervention['.$intervention->id.'][prix]" min="0" step="0.01"  value="'.$intervention->prix.'" required/></p>';
				foreach ( $pieces as $piece ) {
					$contenuAffichage .= '<p><input type="checkbox" name="intervention['.$intervention->id.'][lier][]" value="' . $piece->id . '" '.((!empty(getProduit($intervention->id, $piece->id)))?'checked="checked"':'').'   /><label>' . $piece->libele . '</label></p>';
				}
			}	
			$contenuAffichage.='<p><input type="submit" value="Modifier" name="modifier_type_intervention"/></p>
			</fieldset>
			</form>';
			//supprimer
			$contenuAffichage .= '<form method="post" action="index.php">
			<fieldset>
			<legend>Supprimer type intervention</legend>';
			
			foreach ( $interventions as $intervention ) {
				$contenuAffichage .= '<p><input type="checkbox" name="supprimer[]" value="' . $intervention->id . '"/><label>' . $intervention->type . '</label></p>';
			}
			$contenuAffichage .= '<p><input type="submit" value="Supprier" name="supprimer_type_intervention"/></p>
			</fieldset>
			</form>
			';
	require_once 'gabarit.php';
}

function affichageErreur($msg){
	$contenuAffichage=$msg;
	require_once 'vue/gabarit.php';
}