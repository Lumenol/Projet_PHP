<?php
require_once '../src/modele/modele.php';
require_once '../src/vue/vue.php';

//ajouterEmploye("agent", "ag1",1);
//ajouterEmploye("meca1", "mc11",2);
//ajouterEmploye("meca2", "mc2",2);
//ajouterEmploye("ag2", "ag1",1);

//ajouterClient('nom', 'prenom', 'ad', '0392837', '2015/02/13');
//supprimerClient(1);
//supprimerMateriel(1);
//echo creerTypeIntervention("test", 200.4);
//affichageDirecteur();
//modifierEmploye($id, $mdp, $categorie)
// $pieces=getPieces();
// foreach ($pieces as $key=>$val){
// 	echo $key;
// }

//getProduit(13, 4);
// $act=activiteMecanicien(2, '2015/12/25');
// foreach ($act as $value) {
// 	foreach ($value as $k => $v) {
// 		echo $k.'='.$v.'</br>';
// 	}
// }

//ajouterFormation(2, "2015/12/26 16:00:00");
$impayer = getInterventionClient(1);
foreach ($impayer as $i){
	foreach ($i as $key => $value) {
		echo $key.'='.$value;
	}
}