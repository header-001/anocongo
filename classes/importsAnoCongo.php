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
		
		$sheetNames = $objPHPExcel->getSheetNames();
		for($i=1; $i <= $objPHPExcel->getSheetCount()-1;$i++){
			$cli->output("ActiveSheetIndex:" . $i);
			$province = $sheetNames[$i];
			$cli->output("Province: ".$province);
			eZLog::write("Province: ".$province  , $logName = 'ano.log', $dir = 'var/log' );
				
			if($objPHPExcel->setActiveSheetIndex($i)){

				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				//Nombre de ligne
				$highestRow = $objWorksheet->getHighestRow();
				$cli->output("highestRow:" . $highestRow); 
				//if($stop==true)continue;
				
				for ($row = 5; $row <= $highestRow; $row++) 
				{	
					$j=0;
					if(in_array($province, array("N. KIVU","S. KIVU","MANIEMA"))){
						$district = self::provinceName($province);
					}
					else
						$district = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$commune = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$sigle = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$nom = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Type = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Creation = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Adresse = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Representants = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Telephones = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Emails_sites_internet = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$Acces_internet= trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$Org_femmes = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$DH_justice = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Sante_VIH_Sida = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Dev_Rural_infrastructures = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Education_capacités = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Culture_sport_medias = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Envt_res_naturelles = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Syndicat_ordre = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Micro_finance_sect_privé = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Nb_membres = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$Zones_actions = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Adhesion_reseaux = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Partenaires_financiers = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Autres_Partenaires = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$Inf_1000 = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$De_1000_10000= trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$De_10000_100000 = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Sup_100000 = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$Compte_bancaire_propre_organisation = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Principales_activites = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Points_forts_organisation = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Points_faibles_organisation = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					$Besoins = trim($objWorksheet->getCellByColumnAndRow(++$j, $row)->getCalculatedValue());
					
					$cli->output("nom : $nom | sigle : $sigle");
					eZLog::write( "nom : $nom | sigle : $sigle"  , $logName = 'ano.log', $dir = 'var/log' );
						
					if($nom =="" && $sigle==""){
						//$stop=true;
						break;
					}
					
					$parentTag = null;
					$tagsParams = array('remoteID' =>'Province_'.$province, 
									'parentRemoteID' =>'Provinces',
									'keyWord' => self::provinceName($province));
					
					$tag_prov = self::createTag($tagsParams, $parentTag);
					
					$prov = $tag_prov->attribute( 'id' ) . "|#" . $tag_prov->attribute( 'keyword' ) . "|#" . $tag_prov->attribute( 'parent_id' );
					
					eZLog::write($tag_prov->attribute( 'id' ) . "|#" . $tag_prov->attribute( 'keyword' ) . "|#" . $tag_prov->attribute( 'parent_id' ), $logName = 'ano.log', $dir = 'var/log' );
					
					$tagsParams = array('remoteID' =>'District_'.$district, 
									'keyWord' => $district);
					
					$tag_dict = self::createTag($tagsParams, $tag_prov);
					$dict = $tag_dict->attribute( 'id' ) . "|#" . $tag_dict->attribute( 'keyword' ) . "|#" . $tag_dict->attribute( 'parent_id' );
					
					$tagsParams = array('remoteID' =>'Commune_'.$commune, 
									'keyWord' => $commune);
					
					$tag_com = self::createTag($tagsParams, $tag_dict);
					$com = $tag_com->attribute( 'id' ) . "|#" . $tag_com->attribute( 'keyword' ) . "|#" . $tag_com->attribute( 'parent_id' );
					
					

					$cli->output("Telephones : $Telephones | Emails_sites_internet : $Emails_sites_internet");
					eZLog::write( "Telephones : $Telephones | Emails_sites_internet : $Emails_sites_internet"  , $logName = 'ano.log', $dir = 'var/log' );
					
					$tels = array();
					$tels = self::formate($Telephones);
					$internets = self::formate($Emails_sites_internet);
					$adresses = self::extrateAdress($internets);
					$zones = self::returnZones($Zones_actions);
					$tab_zones =array('id'=>array(),'keyword'=>array(),'parent_id'=>array());
					if($zones){
						foreach ($zones as $zone){
							$tab_zones['id'][]			= $zone->attribute( 'id' );
							$tab_zones['keyword'][]		= $zone->attribute( 'keyword' );
							$tab_zones['parent_id'][]	= $zone->attribute( 'parent_id' );
							//$str_zones = $str_zones . $zone->attribute( 'id' ) . "|#" . $zone->attribute( 'keyword' ) . "|#" . $zone->attribute( 'parent_id' );
						}
					}
					//print_r($str_zones);
					$str_zones = implode("|#", $tab_zones['id']) . "|#" . implode("|#", $tab_zones['keyword']) . "|#" . implode("|#", $tab_zones['parent_id']);
					$cli->output($str_zones);
					eZLog::write($str_zones  , $logName = 'ano.log', $dir = 'var/log' );
					
					$partenaires_financiers = self::explodeStr($Partenaires_financiers);
					$partenaires_financiers = self::ezMatrixFromStringSerialize($partenaires_financiers,4);
					$autres_partenaires = self::explodeStr($Autres_Partenaires);
					$autres_partenaires = self::ezMatrixFromStringSerialize($autres_partenaires,4);
					/*$part_fin = array();
					foreach ($partenaires_financiers as $partenaire){
						$part_fin[] = self::createpartenaire($partenaire, $prefix_remote_id);
					}
					print_r($part_fin);
					 */
					 
					//exit(1);
					
					//Attribution des valeurs
					$params['attributes']['nom'] 							= $nom;
					$params['attributes']['sigle']	 						= $sigle;
					$params['attributes']['creation'] 						= $Creation;
					$params['attributes']['logo'] 							= "";
					$params['attributes']['adresse'] 						= $Adresse;
					$params['attributes']['code_postal'] 					= "";
					$params['attributes']['province'] 						= $prov;
					$params['attributes']['district'] 						= $dict;
					$params['attributes']['commune'] 						= $com;
					
					if($tels[0])
						$params['attributes']['telephone1'] 				= $tels[0];
					if($tels[1])
						$params['attributes']['telephone2'] 				= $tels[1];
					if($tels[2])
						$params['attributes']['telephone3'] 				= $tels[2];
					
					if($adresses['email'][0])
						$params['attributes']['email1'] 					= $adresses['email'][0];
					if($adresses['email'][1])
						$params['attributes']['email2'] 					= $adresses['email'][1];
					if($adresses['email'][2])
						$params['attributes']['email3'] 					= $adresses['email'][2];
					if($adresses['url'][0])
						$params['attributes']['site_web'] 					= $adresses['url'][0];
					
					
					$params['attributes']['facebook'] 						= "";
					$params['attributes']['twitter'] 						= "";
					$params['attributes']['linkedin'] 						= "";
					$params['attributes']['skype'] 							= "";
					$params['attributes']['secteurs_activites'] 			= $str_zones;
					$params['attributes']['adhesion_reseaux'] 				= "";
					$params['attributes']['presentation'] 					= "";
					$params['attributes']['objectifs'] 						= "";
					$params['attributes']['mission'] 						= "";
					$params['attributes']['vision'] 						= "";
					$params['attributes']['zones_actions'] 					= "";
					$params['attributes']['obedience'] 						= "";
					$params['attributes']['nbr_membre_asbl'] 				= "";
					$params['attributes']['partenaires_financiers']			= $partenaires_financiers;
					$params['attributes']['autres_partenaires'] 			= "";
					$params['attributes']['partenaire_local'] 				= "";
					$params['attributes']['partenaire_inter'] 				= "";
					$params['attributes']['budget'] 						= "";
					$params['attributes']['compte_bancaire1'] 				= "";
					$params['attributes']['compte_bancaire2'] 				= "";
					$params['attributes']['principales_activites'] 			= TKImportTools::getEZXMLFromText($Principales_activites);
					$params['attributes']['points_forts_organisation'] 		= TKImportTools::getEZXMLFromText($Points_forts_organisation);
					$params['attributes']['points_faibles_organisation'] 	= TKImportTools::getEZXMLFromText($Points_faibles_organisation);
					$params['attributes']['besoins'] 						= TKImportTools::getEZXMLFromText($Besoins);
					$params['attributes']['representants'] 					= $Representants;
					$params['attributes']['seo'] 							= "";
					
					//Définition du remoteID
					$remote_id = $prefix_remote_id . "_" . $province . "_" . $district . "_" . $commune . "_" . $sigle;
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
	static function replace($str){
		$str = trim(trim(trim($str,",")," "),",");
		return eregi_replace("[^[:blank:]|^[:space:]|^;|^,|[:blank:]$|[:space:]$|;$|,$|[:cntrl:]||^[:alnum:]:|^[:digit:][:space:]]", 
				"",$str);
	}
	static function formate($str){
		$str = eregi_replace("[[:blank:]|[:space:]|[:cntrl:]|;|/]", "||",$str);
		$tab = explode("||", $str);
		$tabs = array();
		foreach ($tab as $t){
			//$tabs[] = trim(trim($t,",")," "),",");
			$tabs[] = self::replace($t);
		}
		//print_r($tabs);
		return $tabs;
	} 
	
	static function extrateAdress($adresses){
		$email =array();
		$url =array();
		foreach ($adresses as $adresse){
			if(eregi("@",$adresse)){
				$email[]= trim($adresse," ");
			}else
				$url[]= trim($adresse," ");
		}
		$result = array("email"=>$email,"url"=>$url);
		//print_r($result);
		return $result;
	}

	static function explodeStr($str){
		$items=array();
		foreach (explode(",", $str) as $item){
			//$items[] = trim(trim(trim($item,",")," "),",");
			$items[] = self::replace($item);
		}
		//print_r($items);
		return $items;
	}
	
	static function returnZones($str){
		$tags=array();
		$zones = self::explodeStr($str);
		$parentTag = eZTagsObject::fetchByRemoteID( "Secteurs_Activites" );
		foreach ($zones as $zone){
			$tagsParams = array('remoteID' =>'zone_'.$zone,
								'keyWord' => self::provinceName($zone));
			$tag = self::createTag($tagsParams, $parentTag);
			$tags[] = $tag;
		}
		//print_r($tags);
		return $tags;
	}
	
	static function ezMatrixFromStringSerialize($tab, $cols){
		$glue="";
		for ($i=1; $i<$cols; $i++){
			$glue .= "|";
		}
		$glue .="&";
		$str = implode($glue, $tab);
		print $str;
		eZLog::write($str  , $logName = 'ano.log', $dir = 'var/log' );
		return $str;
	}
	
	/* 
	 * 
	 * Retourne le nom de la province
	 */
	static function provinceName($key){
		
		$province = array(	"KIN"=>"Kinshasa",
							"BANDUNDU"=>"Bandundu",
							"B.CONGO"=>"Bas-congo",
							"N. KIVU"=>"Nord Kivu",
							"S. KIVU"=>"Sud Kivu",
							"MANIEMA"=>"Maniema",
							"PR. ORIENT."=>"Province Orientale",
							"K. OR."=>"Kasaï Orientale",
							"K. OCC."=>"Kasaï Occidentale",
							"KATANGA"=>"Katanga",
							"EQUATEUR"=>"Equateur");
		
		if($province[$key])
			return $province[$key];
		else
			return $key;
	}
	
	static function createTag(  array $params, eZTagsObject $parentTag = null )
	{
		if( !( $parentTag instanceof eZTagsObject ) )
		{
			$parentRemoteID = $params['parentRemoteID' ];
			$parentTag = eZTagsObject::fetchByRemoteID( $parentRemoteID );
		}
	
		$remoteID = $params['remoteID'];
		$alwaysAvailable = $params['alwaysAvailable'] === 'true';
		$keyword = $params['keyWord'];
		/*
		if( empty( $keywords['translations'] ) )
		{
			$this->writeMessage( 'No translation defined. Skipping.', 'warning' );
			return false;
		}
		*/
		$tag = null;
		if( $remoteID )
		{
			$tag = eZTagsObject::fetchByRemoteID( $remoteID, true );
		}
	
	
		$db = eZDB::instance();
		$db->begin();
	
		if( !$tag instanceof eZTagsObject )
		{
			$exists = false;
	
			//check if tag already exists within parent
			/*
			foreach( $keywords['translations'] as $kw )
			{
				$exists = eZTagsObject::exists(0, $kw, $parentTag instanceof eZTagsObject ? $parentTag->ID : 0 );
				if( $exists )
					break;
			}
			*/
			$exists = eZTagsObject::exists(0, $keyword, $parentTag instanceof eZTagsObject ? $parentTag->ID : 0 );
			if( $exists )
				return $tag;
			
			if( $exists )
			{
				eZLog::write( $keyword . ':  already exists in parent. Processing children.', 'warning' );
			}
			else
			{
				eZLog::write( 'Creating tag ' . $keyword );
				$tag = new eZTagsObject( array( 'parent_id'        => $parentTag instanceof eZTagsObject ? $parentTag->ID : 0,
						'main_tag_id'      => 0,
						'depth'            => $parentTag instanceof eZTagsObject ? $parentTag->Depth + 1 : 1,
						'path_string'      => $parentTag instanceof eZTagsObject ? $parentTag->PathString : '/',
						'main_language_id' => 0,
						'language_mask'    => 0,
                    	'keyword'     		=> $keyword,
				) );
	
				if( $remoteID )
				{
					$tag->setAttribute( 'remote_id', $remoteID );
				}
	
				$tag->store();
				$tag->PathString = $tag->PathString . $tag->ID . '/';
			}
		}
	
		$db->commit();
	
		return $tag;
	}
	
	static function createpartenaire($nom,$prefix_remote_id){

		$prm = eZINI::instance( 'anocongo.ini' );
		$remote_travail_id=$prm->variable('Importation','remote_partenaire_id');
		$classe_partenaire=$prm->variable('Importation','classe_partenaire');
		$partenaire = eZContentObject::fetchByRemoteID($remote_travail_id);
		$parent_node_id = $partenaire->mainNodeID();
		
		$params=array();
		$params['parent_node_id']		= $parent_node_id;
		$params['class_identifier']		= $classe_partenaire;
		$params['attributes']['nom']	= $nom;
		$params['remote_id']			= $prefix_remote_id . "_Part_" . $nom;
		$content_object = TKImportTools::createOrUpdateObject($params);
		
		if ($content_object instanceof eZContentObject)
			return $content_object;
		else 
			return null;
	}
}  


?>
