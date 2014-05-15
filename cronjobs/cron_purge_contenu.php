<?php 

/*
Fichier de purge des contenus stockés sous un noeud donné.
Permet de supprimer en asynchrone les objets

@author 
*/


$cli = eZCLI::instance();						  
$cli->output('Demarrage du script cron_purge_contenu ');


// lecture des paramétres 
$prm = eZINI::instance( '__projet__.ini' );
$noeud_travail_id=$prm->variable('purge','noeud_travail_id');
$classes_a_purger=Array(); 
$classes_a_purger=$prm->variable('purge','classes_a_purger');
$profondeur=$prm->variable('purge','profondeur');


$cli->output('noeud_travail_id='.$noeud_travail_id.' classes_a_purger='.$classes_a_purger);


$node_recherche = eZContentObjectTreeNode::fetch($noeud_travail_id);

//On se place en admin, au cas où on va gérér des utilisateurs
$admin_user_id= 14;
$user = eZUser::fetch( $admin_user_id );
$user->loginCurrent();
			
if($node_recherche)
{
		eZLog::write( 'TRaitement des alertes relances ', $logName = 'alertesrelances.log', $dir = 'var/log' );
		
		$cli->output('Le noeud existe, on recherche ses enfants ');
		$noeud = eZContentObjectTreeNode::subTreeByNodeID( array(	'Depth' => $profondeur,
																	'ClassFilterType' => 'include',
																	'ClassFilterArray' => $classes_a_purger
																	),
																	$noeud_travail_id );
																		 
		
		foreach($noeud as $node_item)
		{
			$nom = $node_item->attribute( 'name' );
			$node_item_id = $node_item->attribute( 'node_id' );
			$cli->output('traitement du noeud  '.$node_item_id.'  '.$nom);
			
			$object_item=$node_item->object();
			
			$user =eZUser::fetch( $object_item->ID);
			if ($user)
			{
				$cli->output(' utilisateur '.$object_item->ID.'  '.$nom);
				//$existUser ) { $userId =& $existUser->id(); eZUser::removeUser( $userId ) ...
				eZUser::removeUser($object_item->ID);
			}
			
			$object_item->remove();
			$object_item->purge();
			
			
		}
		
}





$cli->output('Fin du script cron_purge_contenu ');
?>