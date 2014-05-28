<?php 
/**
 * Classe Utils
 * Fonctions utilitaires
 * @author Kamahunda MULAMBA <kmulamba@tikdem.com>
 *
 */
 
 
class Utils
{	 
	
				
	
	
	/**
	 * Méthode de lecture des variables de paramétrages
	 * @param string $fichierconfiguration
	 * @param string $prefix
	 * @param string $suffix
	 * @param string $cle
	 * @return 	Array
	 */
	 
	static function lireCleEtat($fichierconfiguration,$prefix, $suffix, $cle)
	{
		$retour="";
		
		$conf= eZINI::instance( $fichierconfiguration);
		$section=$prefix."-".$suffix;
		//echo "SECTION $section \n";
		if ($conf->hasSection($section))
		{
			//echo "********** LA SECTION EXISTE ****************\n";
			if ($conf->hasVariable($section, $cle)) 	
			{
				//echo "--- LA VARIABLE EXISTE ---\n";
				$retour = $conf->variable($section, $cle);
			}
			else
			{
				//echo "** LA VARIABLE N'EXISTE PAS ON LOGUUE **\n";
			}
		}
		else
		{
			//echo "---- LA SECTION N EXISTE PAS, ON LOGGUE ----\n";
		}
		
		return $retour;
	}
	
	
	/**
	 * Méthode de test si un utilisateur est dans un groupe donné
	 * @param int user_object_id //Identifiant de l'utilisateur
	 * @param int group_object_id //Identifiant de l'objet user group account
	 * @return 	boolean
	 */
	 
	static function isInGroup($user_object_id ,$group_object_id)
	{
		
		$user = eZUser::fetch( $user_object_id);
		//On récupère les groupes auxquels appartient l'utilisateur en cours
		$groups = $user->attribute( 'groups' );
		if (is_array($groups))
		{
			if (in_array($group_object_id, $groups))
			{
				return true;
			}
		}
		return false;
	}
	
	

	/**
	 * Méthode d'attribution de valeurs à des champs de type object relation ou object relations
	 * @param contentObjectAttribute //Attribut
	 * @param int value //valeur cible
	 * @return 	boolean
	 */
	 
	static function save_eZ_attribute( $contentObjectAttribute, $value )
	{
 
		switch( $contentObjectAttribute->attribute( 'data_type_string' ) )
		{
			case 'ezobjectrelation':
			{
				// Remove any exisiting value first from ezobjectrelation
				/*
				eZContentObject::removeContentObjectRelation( $contentObjectAttribute->attribute('data_int'),
															  $this->current_eZ_object->attribute('current_version'),
															  $this->current_eZ_object->attribute('id'),
															  $contentObjectAttribute->attribute('contentclassattribute_id')
															  );
				*/
				$contentObjectAttribute->setAttribute( 'data_int', 0 );
				$contentObjectAttribute->store();
	 
			}
			break;
	 
			case 'ezobjectrelationlist':
			{
				// Remove any exisiting value first from ezobjectrelationlist
	 
				$content = $contentObjectAttribute->content();
				$relationList =& $content['relation_list'];
				$newRelationList = array();
				for ( $i = 0; $i < count( $relationList ); ++$i )
				{
					$relationItem = $relationList[$i];
					eZObjectRelationListType::removeRelationObject( $contentObjectAttribute, $relationItem );
				}
				$content['relation_list'] =& $newRelationList;
				$contentObjectAttribute->setContent( $content );
				$contentObjectAttribute->store();
	 
			}
			break;
		}
	 
		// fromString returns false - even when it is successfull
		// create a bug report for that
		$contentObjectAttribute->fromString( $value );
		$contentObjectAttribute->store();
		
		
	}
	
	/**
	 * Méthode de création de nouvelles location pour un objet donné
	 * @param int objectID //Identifiant de l'objet
	 * @param int newNodeID //Identifiant du noeud parent cible
	 * @return 	boolean
	 */
	
	static function addLocation($objectID,$newNodeID) 
	{

		$object =eZContentObject::fetch( $objectID );
		$version_number = $object->attribute('current_version');
		
		$nodeID = $object->attribute("main_node_id");
		$version =$object->currentVersion();
		$class = $object->contentClass();
		
		$existingNode =eZContentObjectTreeNode::fetch( $nodeID );
		
		$selectedNodeIDArray = array($newNodeID);
		$assignedNodes =$version->nodeAssignments();
		$assignedIDArray = array();
		$setMainNode = false;
		$hasMainNode = false;
		foreach ( $assignedNodes as $assignedNode )
		{
			$assignedNodeID = $assignedNode->attribute( 'parent_node' );
			if ( $assignedNode->attribute( 'is_main' ) )
				$hasMainNode = true;
			$assignedIDArray[] = $assignedNodeID;
		}
		if ( !$hasMainNode )
			$setMainNode = true;
		
		$mainNodeID = $existingNode->attribute( 'main_node_id' );
		$objectName = $object->attribute( 'name' );
		foreach ( $selectedNodeIDArray as $selectedNodeID )
		{
			if ( !in_array( $selectedNodeID, $assignedIDArray ) )
			{
				$isPermitted = true;
				$parentNode =& eZContentObjectTreeNode::fetch( $selectedNodeID );
				$parentNodeObject = $parentNode->attribute( 'object' );
		
				$canCreate = $parentNode->checkAccess( 'create', $class->attribute( 'id' ), $parentNodeObject->attribute( 'contentclass_id' ) ) == 1;
				if ( $isPermitted )
				{
					$isMain = 0;
					if ( $setMainNode )
						$isMain = 1;
					$setMainNode = false;
					$nodeAssignment =&$version->assignToNode( $selectedNodeID, $isMain );
					$newNode =&$parentNode->addChild( $object->attribute( 'id' ), 0, true );
					$newNode->setAttribute( 'sort_field', $nodeAssignment->attribute( 'sort_field' ) );
					$newNode->setAttribute( 'sort_order', $nodeAssignment->attribute( 'sort_order' ) );
					$newNode->setAttribute( 'contentobject_version', $version->attribute( 'version' ) );
					$newNode->setAttribute( 'contentobject_is_published', 1 );
					$newNode->setAttribute( 'main_node_id', $mainNodeID );
					$newNode->setName( $objectName );
					$newNode->updateSubTreePath();
					$newNode->store();
					eZContentObjectTreeNode::updateNodeVisibility( $newNode, $parentNode, false );
					//echo "on a finit";
				}
			}
		}
		include_once( 'kernel/content/ezcontentoperationcollection.php' );
		eZContentOperationCollection::clearObjectViewCache( $objectID, true );
		eZContentObject::expireTemplateBlockCacheIfNeeded();
		
		$operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $object->ID,
	                                                                                  'version' => $version_number ) );
	}
	
	/**
	 * Méthode de création des lignes de valeur d'un champs eZ matrix
	 * @param object $object //Objet qui contient le datatype
	 * @param object $contentObjectAttribute //Objet attribut ($datamap['nom_attribut'])
	 * @param string $value //Chaine concaténée avec les valeurs de la martrice exemple $value="Ligne1|2|3&Ligne2|3|4&Ligne3|5|6";
	 * @return 	boolean
	 */
	//static function  storeMatrixAttribute($object, $contentObjectAttribute, $cells )
	static function  storeMatrixAttribute($object, $contentObjectAttribute, $value )
    {
      
	    $version_number = $object->attribute('current_version');
		
		
		
		$contentObjectAttribute->fromString($value);
		$contentObjectAttribute->store();
		
		/*
		$matrix = $contentObjectAttribute->attribute( 'content' );
		// On supprimme les lignes existantes avant d'ajouter de nouvelles
		for ( $i=0; $i < $matrix->attribute( "rowCount" ); $i++ )
		{
			$matrix->removeRow( $i );
		}
		//$rowCount=3;
		$rowCount=$matrix->attribute( "rowCount" );
		
		$matrix->addRow( false, $rowCount );
        $matrix->Cells = $cells;
        $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
        $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );
        $contentObjectAttribute->setContent( $matrix );
		$contentObjectAttribute->store();
		*/
		
		$operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $object->ID,
	                                                                                  'version' => $version_number ) );
																					  
																							 
		
		
		
		
    }
	
	/**
	 * Méthode d'identification de l'état actuel d'un objet dans un groupe d'états donnée
	 * @param object $object //objet concerné
	 * @param string $groupe_etats //Identifier du du groupe 
	 * @return 	false ou id actuel de l'objet.
	 */
	 
	static function retournerEtatObjet( $object, $groupe_etats)
	{
		$result=false;
		$current_states_identifiers = $object->stateIdentifierArray ();
		//print_r($current_states_identifiers);
		//echo "\n dans retournerEtatObjet $groupe_etats\n";
		$version= $object->version($object->attribute('current_version'));
		$datamap=$version->attribute( 'data_map' );
		$id_object = $object->attribute('id');
		//echo "\n id_objet  $id_object\n";
		
		$stateGroup = eZContentObjectStateGroup::fetchByIdentifier($groupe_etats);
		$group_id = $stateGroup->attribute( 'id' );
		
		//echo "\n group_id $group_id\n";
		
		if ($stateGroup)
		{
			
			foreach($current_states_identifiers as $current_states_identifier)
			{
				
				//echo "\n appel fetchbyidentifier $current_states_identifier et groupe_id=$group_id \n";
				$state_identifier_temp = explode("/", $current_states_identifier);
				$state_identifier=$state_identifier_temp[1];


				$state_actuel = eZContentObjectState::fetchByIdentifier( $state_identifier, $group_id );
				
				//var_dump($state_actuel);
				
				if ($state_actuel)
				{
					//echo "\n etat actuel = $state_identifier ";
					$result=$state_actuel->attribute( 'id' );
				}
				
			}
			//echo "</br> sortie de boucle avec etat_actuel=$etat_actuel";
		}
	
		return $result;
	}
	
	/**
	 * Méthode qui retourne le libellé d'un état connaissant son id
	 * @param int $id_etat//id_etat
	 * @return 	string // libellé de l'état
	 */
	
	static function retourneNomEtat($id_etat)
	{
		
		$libelle="";
		if ($id_etat)
		{
			$objectEtat = eZContentObjectState::fetchById($id_etat);
			if ($objectEtat)
			{
				$current_translation = $objectEtat->currentTranslation();
				$libelle= $current_translation ->attribute( 'name' );
				

			}
			
		}
		return $libelle;
	}
}  


?>
