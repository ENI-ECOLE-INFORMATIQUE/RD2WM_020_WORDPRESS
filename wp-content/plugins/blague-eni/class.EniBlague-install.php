<?php
/**
* Classe en charge de d'alimenter la table eniBlague dans la base de données.
* @package eniBlagueCitation
* @version 0.6
* @since 0.2
* @author Denis - Stagiaires
*/

/*
* Fonction en charge d'alimenter la BD en blagues.
*/
function eniBlague_install_BD($table_eniBlague){
	$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES ('1', 'Toto fait des maths', '– Toto si tu as 10 bonbons et que Mathieu t’en prends un combien il t’en reste ?\r\n\r\n– 10 bonbons et un cadavre', 'toto-math', 'Blagues à Toto');";
	dbDelta($insert);
	
	$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES (2,\"Toto arrête de tourner\",\"Toto arrête de tourner …

TOTO arrête de tourner …

TOTO ARRÊTE DE TOURRRNNNNER …

Toto arrête de tourner où je te cloue l’autre pied !\",\"Toto – tourner\",\"Blague à Toto\");";
dbDelta($insert);
$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES (3,\"Toto mal au ventre\",\"– Toto si je te donne 50 gâteaux et tu en manges 48 tu as donc ?

– Mal au ventre .\",\"Toto-mal au ventre\",\"Blague à Toto\");";
	dbDelta($insert);
	
	$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES (4,\"Citation JCVD: Eau de Javel\",\"– Si tu parles à ton eau de Javel pendant que tu fais la vaisselle, elle est moins concentrée.\",\"JCVD-Jean Claude-Van-Damme\",\"Déclaration officiel Jean Claude Van Damme\");";
	dbDelta($insert);
	$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES (5,\"Citation JCVD: Voyante \",\"– Si tu téléphones à une voyante et qu'elle ne décroche pas avant que ça sonne, raccroche.\",\"JCVD-Jean Claude-Van-Damme\",\"Déclaration officiel Jean Claude Van Damme\");";
	dbDelta($insert);
	$insert="INSERT INTO `$table_eniBlague` (`id`, `blague`, `description`, `motscles`, `source`) VALUES (6,\"Citation JCVD: l'air \",\"– Je suis fascine par l'air. Si on enlevait l'air du ciel, tous les oiseaux tomberaient par terre....Et les avions aussi.... En même temps l'air tu peux pas le toucher...ça existe et ça n'existe pas...Ça nourrit l'homme sans qu'il ait faim...It's magic...L'air c'est beau en même temps tu peux pas le voir, c'est doux et tu peux pas le toucher.....L'air c'est un peu comme mon cerveau....\",\"JCVD-Jean Claude-Van-Damme\",\"Déclaration officiel Jean Claude Van Damme\");";
	dbDelta($insert);
	
}
?>