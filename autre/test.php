<?php
require_once '../modèle/modele.php';
//creerEmploye(998, "aze", 2);
echo getCategorie(998, "aze");
//ajouterClient("Jean", "pierre", "20 rue truc", 03928372, "2000/12/03");
//$idc=trouverIDclient("Jean", "2000/12/03")[0];
echo ($idc=3).'</br>';
//modifClient($idc, "Pierre", "Jean", "19 rue machin", 030203040, "2012/02/03");
//\\ajouterSolde($idc, 20000, 50, 1);
//supprimerClient(3);
/*$synthese=syntheseClient(2);
foreach ($synthese as $key=>$val){
	echo $key.'='.$val.'</br>';
}*/

//creerIntervention(12, 2, 1);
//suppimerIntervention(12);
supprEmploye(998, "aze");