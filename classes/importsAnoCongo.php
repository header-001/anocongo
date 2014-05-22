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
		
		for($i=1; $i <= $objPHPExcel->getSheetCount()-1;$i++){
			$cli->output("ActiveSheetIndex:" . $i);
			if($objPHPExcel->setActiveSheetIndex($i)){

				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				//Nombre de ligne
				$highestRow = $objWorksheet->getHighestRow();
				$cli->output("highestRow:" . $highestRow); 
				//if($stop==true)continue;
				
				for ($row = 5; $row <= $highestRow; $row++) 
				{
					
					
					$nom = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue());
					$sigle = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue());
					$cli->output("nom : $nom | sigle : $sigle");
					if($nom =="" && $sigle==""){
						//$stop=true;
						break;
					}
					
					//Attribution des valeurs
					$params['attributes']['nom'] = $nom;
					
					//Définition du remoteID
					$remote_id = $prefix_remote_id.$nom;
					$params['remote_id']=$remote_id;
				
					eZLog::write( 'LIGNE  '.$row.'  '.$nom  , $logName = 'ano.log', $dir = 'var/log' );  
					
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
}  


?>
