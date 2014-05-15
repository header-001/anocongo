<?php 
/**
 * Classe ImportsAnoCongo
 * Méthodes d'imports des ong
 * @author Alain MANGANA <alainmakis@gmail.com>
 *
 */
 
 
class ImportsAnoCongo
{

	static $compteurligne = 0;
	static $tab_remote_id=array();
	
	/**
	 * Methode de création d'un projet à partir de  documents Excel
	 * $fichier_excel  ,Chemin absolu du fichier Excel
	 * $parent_node_id ,id du noeud parent
	 * $prefix_remote_id, un préfixe que l'on ajoute pour caractériser le remote_id
	 * $classe_objet_importe, classe de l'objet à importer
	 * @return void
	 */
	static function creerContenu($fichier_excel, $parent_node_id, $prefix_remote_id, $classe_objet_importe)
	{
		
		$cli = new eZCLI();
		eZLog::write( 'Lancement de la création de contenu pour le fichier '. $fichier_excel, $logName = 'ano.log', $dir = 'var/log' );
		
		//Données de base des objets à créer
		$params=array();
		
		$params['parent_node_id']=$parent_node_id; 
		$params['class_identifier']=$classe_objet_importe;
		
		
		//Traitement des données Excel
		//Ouverture du fichier
		eZLog::write( 'OUVERTURE FICHIER '.$fichier_excel , $logName = 'ano.log', $dir = 'var/log' ); 
		$objPHPExcel = PHPExcel_IOFactory::load($fichier_excel);
		$stop = false;
		
		//Init
		$keyword_params = array( 'keyword' => array( 'like', trim( 'Pronvices' ) ), 'parent_id' => 0 );
		$tag = eZTagsObject::fetchList( $keyword_params);
		if(is_array($tag))
			$tag = $tag[0];
			
		if(!$tag){
			$db = eZDB::instance();
			$db->begin();
			$parentTag = false;
			$tag = new eZTagsObject( array( 'parent_id'   => ( $parentTag instanceof eZTagsObject ) ? $parentTag->attribute( 'id' ) : 0,
											'main_tag_id' => 0,
											'keyword'     => 'Pronvices',
											'depth'       => ( $parentTag instanceof eZTagsObject ) ? (int) $parentTag->attribute( 'depth' ) + 1 : 1,
											'path_string' => ( $parentTag instanceof eZTagsObject ) ? $parentTag->attribute( 'path_string' ) : '/' ) );

			$tag->store();
			$tag->setAttribute( 'path_string', $root_province_tags->attribute( 'path_string' ) . $root_province_tags->attribute( 'id' ) . '/' );
			$tag->store();
			$tag->updateModified();
			
			$db->commit();
		}
		$province_tag_id = $tag->attribute( 'id' );
		//print_r($province_tag_id);exit(1);
		
		for($i=1; $i <= $objPHPExcel->getSheetCount()-1;$i++){
			$cli->output("ActiveSheetIndex:" . $i . "Title :" . $objPHPExcel->getSheet($i)->getTitle());
			if($objPHPExcel->setActiveSheetIndex($i)){

				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				//Nombre de ligne
				$highestRow = $objWorksheet->getHighestRow();
				$cli->output("highestRow:" . $highestRow); 
				//if($stop==true)continue;
				
				$province = $objPHPExcel->getSheet($i)->getTitle();
				for ($row = 5; $row <= $highestRow; $row++) 
				{
					
					
					$dist = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
					$comm = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue());
					$sigle = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue());
					$nom = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue());
					
					
					$cli->output("nom : $nom | sigle : $sigle");
					
					if($nom =="" && $sigle==""){
						//$stop=true;
						break;
					}
					
					$province_tag = self::creerTag($province, $province_tag_id);
					
					/*if($province){
						if($dist){
							if($comm){
							}
						}
					}
					*/
					//Creation des tags
					$tag_id = $province_tag->attribute( 'id' );
					$dist_tag = self::creerTag($dist, $tag_id);
					
					$tag_id = $dist_tag->attribute( 'id' );
					$comm_tag = self::creerTag($comm, $tag_id);
					
					$tag_id = $comm_tag->attribute( 'id' );
					
					//Attribution des valeurs
					$params['attributes']['nom'] = $nom;
					
					//Définition du remoteID
					if(strlen($nom) > 90)
						$remote = substr($nom,0,90);
					else $remote = $nom;
					
					$remote_id = $prefix_remote_id . "_" . $province . "_" . $dist . "_" . $comm . "_" . $sigle;
					$params['remote_id']=$remote_id;
				
					eZLog::write( 'LIGNE  '.$row.'  '.$nom  , $logName = 'ano.log', $dir = 'var/log' );  
					
					self::creerTag($province, $dist, $comm);
					
					//Création de l'enregistrement
					if ($params['remote_id'])
					{
						//Création de l'objet
						$content_object = TKImportTools::createOrUpdateObject($params);
						
						eZLog::write( '|||||| '.$params['remote_id'].' via lecture excel OK' , $logName = 'ano.log', $dir = 'var/log' ); 
						
						//Test de la bonne création du contenu
						
						if(key_exists($remote_id, self::$tab_remote_id)){
							eZLog::write(":::::". $nom.' => '.$remote_id . ' est déjà créé', $logName = 'ano.log', $dir = 'var/log' );
							continue;
						}
						
						if ($content_object instanceof eZContentObject)
						{
							$cli->output("::ONG:: $nom");
							self::$compteurligne++;
							eZLog::write( 'creation du contenu n°' . self::$compteurligne . ' avec '.$params['remote_id'].' via lecture excel OK' , $logName = 'ano.log', $dir = 'var/log' );
							
							self::$tab_remote_id[$remote_id] = $nom;
							
						} else {
							eZLog::write( 'ERREUR creation du contenu '.$params['remote_id'].' via lecture excel OK' , $logName = 'ano.log', $dir = 'var/log' );
						}
						
					}
				}
			}
		}
		
		
			
		//On ferme le fichier
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
			
		
	}
	
	static function creerTag($newKeyword, $parentTagID){
			$cli = new eZCLI();
			if ( $parentTagID > 0 )
			{
				$parentTag = eZTagsObject::fetch( $parentTagID );

				if ( !( $parentTag instanceof eZTagsObject ) )
				{
					return false;
				}

				if ( $parentTag->attribute( 'main_tag_id' ) != 0 )
				{
					return false;
				}
				
				$params = array( 'keyword' => array( 'like', trim( $newKeyword ) ), 'parent_id' => $parentTagID );
				$tag = eZTagsObject::fetchList( $params);
				if($tag){
					$cli->output("le Mot clé : $newKeyword :  existe dans le tag $parentTagID" );
					if(is_array($tag))
						$tag = $tag[0];
				}
				else{
				
					$cli->output("on crée : $newKeyword :  dans le tag $parentTagID" );
				
					$db = eZDB::instance();
					$db->begin();

					$tag = new eZTagsObject( array( 'parent_id'   => ( $parentTag instanceof eZTagsObject ) ? $parentTag->attribute( 'id' ) : 0,
													'main_tag_id' => 0,
													'keyword'     => $newKeyword,
													'depth'       => ( $parentTag instanceof eZTagsObject ) ? (int) $parentTag->attribute( 'depth' ) + 1 : 1,
													'path_string' => ( $parentTag instanceof eZTagsObject ) ? $parentTag->attribute( 'path_string' ) : '/' ) );

					$tag->store();
					$tag->setAttribute( 'path_string', $tag->attribute( 'path_string' ) . $tag->attribute( 'id' ) . '/' );
					$tag->store();
					$tag->updateModified();
					
					$db->commit();
				}
				return $tag;
			}
			return null;
	}
}  


?>
