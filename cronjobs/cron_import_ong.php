<?php 

/*
Script d'intégration des fichiers Excel

@author Alain MANGANA <alainmakis@gmail.com>
*/


$cli = eZCLI::instance();						  
$cli->output("Démarrage du script cron_import_ong.php \n");


// lecture des paramètres 
$prm = eZINI::instance( 'anocongo.ini' );
$remote_travail_id=$prm->variable('Importation','remote_travail_id');
//$noeud_travail_id=$prm->variable('Importation','noeud_travail_id');
$classe_objet_importe=$prm->variable('Importation','classe_objet_importe');
$prefix_remote_id=$prm->variable('Importation','prefix_remote_id');

$fichier_in = eZExtension::baseDirectory() .'/anocongo/fichiers_in/_24OO ORGANISATION DE LA SOCIETE CIVILE REPERTORIEES PAR MONUSCO.xlsx';

$ong = eZContentObject::fetchByRemoteID($remote_travail_id);
$noeud_travail_id = $ong->mainNodeID();
$node_recherche = eZContentObjectTreeNode::fetch($noeud_travail_id);
$cli->output('noeud_travail_id='.$noeud_travail_id.' classes_a_traiter='.$classe_objet_importe);

//Séquence d'import
if($node_recherche)
{
	$cli->output('Traitement du fichier : '.$fichier_in ."\n"); 
	ImportsAnoCongo::creerContenu($fichier_in, $noeud_travail_id,$prefix_remote_id, $classe_objet_importe);
	$cli->output("\nFin Traitement du fichier : ".$fichier_in); 

}

$cli->output("\nFin du script cron_import_ong.php");
?>