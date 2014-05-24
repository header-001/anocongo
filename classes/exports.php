<?php 
/**
 * Classe pfExports
 * Export des contenus (Projet, Fiche de Résultat, Prodoc) dans un format de sortie donné (Word, PDF)
 * @author Kamahunda MULAMBA <kmulamba@tikdem.com>
 *
 */
 
 
class pfExports
{
	
	

	
	/**
	 * Méthode d'export des fiches de projet
	 * @param int $projet_id // Identifiant du projet
	 * @return Void
	 */
	static function exporterProjetWord($projet_id)
	{
		$project_objet =eZContentObject::fetch( $projet_id);
		if ($project_objet)
		{
			//Traitement des attributs
			$version = $project_objet->version($project_objet->attribute('current_version'));
			$datamap = $version->attribute( 'data_map' );
			
			$titre = $datamap['titre']->attribute('data_text');
			
			//Nom et Acronyme de l'organisation
			$organisation = $datamap['organisation'];
			//print_r($organisation);
			$organisation_class_content= $datamap['organisation']->attribute("contentclass_attribute")->attribute('content');
			
			//print_r($organisation_class_content);
			$organisation_content= $datamap['organisation']->attribute('content');
			
			//print_r($organisation_content);
			
			$organisation_object_id = $organisation_content['relation_list'][0]['contentobject_id'];
			$organisation_object_contentclass_identifier = $organisation_content['relation_list'][0]['contentclass_identifier'];
			$organisation_object_contentobject_remote_id = $organisation_content['relation_list'][0]['contentobject_remote_id'];
			
			
			//Recherche de l'année
			$node_id = $project_objet->attribute( 'main_node_id' );
			$node = eZContentObjectTreeNode::fetch( $node_id );
			$parent_node_id = $node->attribute( 'parent_node_id');
			
			//Eléments du parent (Identifiant du projet dans la Database);
			$parent_node =eZContentObjectTreeNode::fetch($parent_node_id);
			$grand_parent_node_id = $parent_node->attribute( 'parent_node_id');
			$grand_parent_node =eZContentObjectTreeNode::fetch($grand_parent_node_id);
			
			
			$gpobject = $grand_parent_node->object();
			$versiongp = $gpobject->version($gpobject->attribute('current_version'));
			$datamapgp = $versiongp->attribute( 'data_map' );
			$annee = $datamapgp['libelle']->attribute('data_int');
			
			
			//
			$datamap['cluster_coordination_montant']->attribute('data_text');
			$datamap['cluster_education_montant']->attribute('data_text');
			
			/*
			//Génération du document WORD
			$PHPWord = new PHPWord();
			$fichier_template = eZExtension::baseDirectory() .'/pfsp/docstemplates/word/ficheprojet/TemplateFP.docx';

			$document = $PHPWord->loadTemplate($fichier_template);

			$document->setValue('Organisation', 'Suny');
			$document->setValue('Value2', 'Mercury');

			
			//$document->setValue('weekday', date('l'));
			//$document->setValue('time', date('H:i'));



			
			$var_directory =  eZSys::varDirectory();
			$filepath = eZSys::varDirectory() ."/docsgeneres/fichesprojets/";

			//$storage_directory =  eZSys::storageDirectory();
			//$cache_directory =  eZSys::cacheDirectory();
			//$root_directory =  eZSys::rootDir();
			//$site_directory =  eZSys::siteDir();

			echo "var_directory=$var_directory \n";
			//echo "storage_directory=$storage_directory \n";
			//echo "cache_directory=$cache_directory \n";
			//echo "root_directory=$root_directory \n";
			//echo "site_directory=$site_directory \n";

			//$filepath="C:/wamp/www/pfsharepoint/var/pfsp/docsgeneres/fichesprojets/";
			$filename=$filepath.'projettest.docx';
			$document->save($filename);
			*/
		}
		
	}
	 
	
	
	/**
	 * Méthode de traitement des fiches de résultats (Export)
	 * @param int $fiche_resultats_id // Identifiant de la FR
	 * @return Void
	 */
	static function exporterFicheResultatsWord($fiche_resultats_id)
	{
		$objet =eZContentObject::fetch( $fiche_resultats_id);
		
		if ($objet)
		{
			//Informations de configuration
			$conf= eZINI::instance( 'pfconfiguration.ini' );
			$fichier_template_fiche_resultats = $conf->variable('exports','fichier_template_fiche_resultats');
			$repertoire_cible_fiche_resultats = $conf->variable('exports','repertoire_cible_fiche_resultats');
			$prefix_nom_cible_fiche_resultats = $conf->variable('exports','prefix_nom_cible_fiche_resultats');

			
			//Traitement des attributs
			$fiche_resultat_object_id = $objet->ID;
			$version = $objet->version($objet->attribute('current_version'));
			$datamap = $version->attribute( 'data_map' );

			$titre = $datamap['titre']->attribute('data_text');
			
			echo "\n FR $fiche_resultats_id a pour titre $titre \n";
			
			//Recherche des informations du projet et celles de l'allocation
		
			$node_id = $objet->attribute( 'main_node_id' );
			$node = eZContentObjectTreeNode::fetch( $node_id );
			
			
			$etape_node_id = $node->attribute( 'parent_node_id');
			$etape_node = eZContentObjectTreeNode::fetch( $etape_node_id);
			$projet_node_id = $etape_node->attribute( 'parent_node_id');
			$projet_node = eZContentObjectTreeNode::fetch( $projet_node_id );
			$projet_object = $projet_node->object();
			$projet_object_id = $projet_object->ID;
			$version_projet = $projet_object->version($projet_object->attribute('current_version'));
			$datamap_projet = $version_projet->attribute( 'data_map' );
			
			
			$allocation_node_id = $projet_node->attribute( 'parent_node_id');
			$allocation_node = eZContentObjectTreeNode::fetch( $allocation_node_id );
			$allocation_object = $allocation_node->object();
			$version_allocation = $allocation_object->version($allocation_object->attribute('current_version'));
			$datamap_allocation = $version_allocation->attribute( 'data_map' );
			$fund_source=$datamap_allocation['source']->attribute('data_int');  
			$fund_Round=$datamap_allocation['round']->attribute('data_int');
			$libelle_allocation = $datamap_allocation['libelle']->attribute('data_text');
			
			$annee_node_id = $allocation_node->attribute( 'parent_node_id');
			$annee_node = eZContentObjectTreeNode::fetch( $annee_node_id );
			$annee_object = $annee_node->object();
			$version_annee = $annee_object->version($annee_object->attribute('current_version'));
			$datamap_annee = $version_annee->attribute( 'data_map' );
			$annee=$datamap_annee['libelle']->attribute('data_int');  
			
			echo " fund_source=$fund_source fund_Round=$fund_Round annee=$annee`\n";
			
			//Nom de l'organisation
			$organisation_content= $datamap_projet['organisation']->attribute('content');
			$organisation_object_id = $organisation_content['relation_list'][0]['contentobject_id'];
			$organisation_object =eZContentObject::fetch( $organisation_object_id);
			$version_organisation = $organisation_object->version($organisation_object->attribute('current_version'));
			$datamap_organisation = $version_organisation->attribute( 'data_map' );
			$nom_organisation=$datamap_organisation['nom_complet']->attribute('data_text'); 
			
			echo "\n organisation=$nom_organisation \n";
			$titre_projet =  $datamap_projet['titre']->attribute('data_text');
			$projet_duree =  $datamap_projet['projet_duree']->attribute('data_int');
			$total_fonds_sollicites =  $datamap_projet['total_fonds_sollicites']->attribute('data_text');
			
			$date_demarrage_effectif =  date("d-m-Y", $datamap_projet['date_demarrage_effectif']->metaData() );
			
			echo "titre=$titre_projet projet_duree=$projet_duree total_fonds_sollicites=$total_fonds_sollicites date_demarrage_effectif=$date_demarrage_effectif \n";
			
			$libelle_province="";
			$libelle_cluster="";
			
			pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_nordkivu_proportion', 'database_tbllookup_provinces_id');
			if ($datamap_projet['localisation_bandundu_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_bandundu_proportion', 'libelle_fr').", ";
				
			}
			
			if ($datamap_projet['localisation_bascongo_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_bascongo_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_equateur_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_equateur_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_ituri_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_ituri_proportion', 'libelle_fr').", ";
			}
			
			
			if ($datamap_projet['localisation_hautbasuele_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_hautbasuele_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_kasaioccidental_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_kasaioccidental_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_kasaioriental_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_kasaioriental_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_katanga_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_katanga_proportion', 'libelle_fr').", ";
			}
			
			
			if ($datamap_projet['localisation_kinshasa_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_kinshasa_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_maniema_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_maniema_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_nordkivu_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_nordkivu_proportion', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['localisation_provinceorientale_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_provinceorientale_proportion', 'libelle_fr').", ";
			}
			
			
			if ($datamap_projet['localisation_sudkivu_proportion']->attribute('data_text')!="0")
			{
				$libelle_province = $libelle_province.pfUtils::lireCleEtat('pfconfiguration.ini','province', 'localisation_sudkivu_proportion', 'libelle_fr').", ";
			}
			$longueur_chaine=strlen($libelle_province)-2;
			$libelle_province=substr($libelle_province, 0, $longueur_chaine);
			
			echo "\n libelle_province=$libelle_province \n";
			
			
			if ($datamap_projet['cluster_coordination_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_coordination_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_education_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_education_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_sante_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_sante_montant', 'libelle_fr').", ";
			}
			if ($datamap_projet['cluster_logistique_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_logistique_montant', 'libelle_fr').", ";
			}
			
			
			if ($datamap_projet['cluster_relevementprecoce_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_relevementprecoce_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_abrisetbna_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_abrisetbna_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_eha_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_eha_montant', 'libelle_fr').", ";
			}
			if ($datamap_projet['cluster_assistancemultisectorielle_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_assistancemultisectorielle_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_nutrition_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_nutrition_montant', 'libelle_fr').", ";
			}
			
			if ($datamap_projet['cluster_securitealimentaire_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_securitealimentaire_montant', 'libelle_fr').", ";
			}
			if ($datamap_projet['cluster_protection_montant']->attribute('data_text')!="0")
			{
				$libelle_cluster = $libelle_cluster.pfUtils::lireCleEtat('pfconfiguration.ini','cluster', 'cluster_protection_montant', 'libelle_fr').", ";
			}
			
			$longueur_chaine=strlen($libelle_cluster)-2;
			$libelle_cluster=substr($libelle_cluster, 0, $longueur_chaine);
			
			echo "\n libelle_cluster=$libelle_cluster\n";
			
			
			//Voir pour Date payement :
			//Date prévue de soumission
			$date_probable =  date("d-m-Y", $datamap['date_probable']->metaData() );

			//Type de rapports (Fiches de résultats trimestrielle ou finale)
			$type_rapport = $datamap['type_rapport']->attribute('data_text');
			
			echo "\n date_probable=$date_probable type_rapport=$type_rapport \n";
			
			$beneficiaires = $datamap['beneficiaires']->toString();
			echo "\n  beneficiaires=$beneficiaires \n";
			$lignes_beneficiaires = explode("&", $beneficiaires);
			
			$personnes="";
			$familles="";
			$hommes="";
			$femmes="";
			$garcons="";
			$filles="";
			
						
			$prevus_personnes="";
			$atteint_personnes="";
			
			$prevus_familles="";
			$atteint_familles="";
			
			$prevus_hommes="";
			$atteint_hommes="";
			
			$prevus_femmes="";
			$atteint_femmes="";
			
			$prevus_garcons="";
			$atteint_garcons="";
			
			$prevus_filles="";
			$atteint_filles="";
			foreach($lignes_beneficiaires as $ligne_beneficiaires)
			{
				$ligne = explode("|", $ligne_beneficiaires);
				
				$tabl_beneficiaires=explode("##",$ligne[0]);
				$id_beneficiaire= $tabl_beneficiaires[0];
				$type_beneficiaire= $tabl_beneficiaires[1];
				
				$prevus=$ligne[1];
				$atteint=$ligne[2];
				echo "\n id_beneficiaire=$id_beneficiaire type_beneficiaire=$type_beneficiaire prevus=$prevus atteint=$atteint \n";
				switch( $type_beneficiaire) 
				{
					case "Personnes" :
						$personnes=$type_beneficiaire;
						$prevus_personnes=$prevus;
						$atteint_personnes=$atteint;
						break;
					case "Familles" :
						$familles=$type_beneficiaire;
						$prevus_familles=$prevus;
						$atteint_familles=$atteint;
						break;
					case "Hommes" :
						$prevus_hommes=$prevus;
						$atteint_hommess=$atteint;
						break;
					case "Femmes" :
						$prevus_femmes=$prevus;
						$atteint_femmes=$atteint;
						break;
					case "Garçons" :
						$prevus_garcons=$prevus;
						$atteint_garcons=$atteint;
						break;
					case "Filles" :
						$prevus_filles=$prevus;
						$atteint_filles=$atteint;
						break;
					default:
						break;
				}
			}
			
			
			//Indicateurs
			$indicateurs_resultats = $datamap['indicateurs_resultats']->toString();
		
			echo "\n  Indicateurs de résultats=$indicateurs_resultats \n";
			$lignes_resultats = explode("&", $indicateurs_resultats);
			
			
			foreach($lignes_resultats as $ligne_resultats)
			{
				$ligne = explode("|", $ligne_resultats);
				
				$indicateur=explode("##",$ligne[0]);
				$id_indicateur= $indicateur[0];
				$libelle_indicateur=$indicateur[1];
				$cible=$ligne[1];
				$atteint=$ligne[2];
				echo "\n id_indicateur=$id_indicateur libelle_indicateur=$libelle_indicateur cible=$cible atteint=$atteint \n";
				
			}
			
			//Utilisation des fonds
			$utilisation_fonds = $datamap['utilisation_fonds']->toString();
		
			echo "\n utilisation_fonds=$utilisation_fonds  \n";
			$lignes_utilisation_fonds = explode("&", $utilisation_fonds);
		
			//On constitue les champs de la requête
			//Il n'y a qu'une ligne au tableau donc on travail sur l'indice 0
			$ligne_utilisation_fonds = explode("|", $lignes_utilisation_fonds[0]);
			$depenses=$ligne_utilisation_fonds[0];
			$engages=$ligne_utilisation_fonds[1];
			$solde=$ligne_utilisation_fonds[2];
			
			echo "\n utilisation des fonds depenses=$depenses engages=$engages solde=$solde \n";
			
			$detail_sous_financements = $datamap['detail_sous_financements']->toString();
			$lignes_detail_sous_financements = explode("&", $detail_sous_financements);
			
			
			foreach($lignes_detail_sous_financements  as $ligne_detail_sous_financements )
			{
				echo "\n ligne_detail_sous_financements=$ligne_detail_sous_financements \n";
				
				$ligne = explode("|", $ligne_detail_sous_financements);
				$nom_organisation=$ligne[0];
				if( $nom_organisation!="")
				{
					
					$type_organisation=$ligne[1];
					$activite=$ligne[2];
					$montant_alloue=$ligne[3];
					echo "\n nom_organisation=$nom_organisation type_organisation=$type_organisation activite=$activite montant_alloue=$montant_alloue \n";
				}
			}
			
			
			//Génération du document WORD
			$PHPWord = new PHPWord();
			$fichier_template = eZExtension::baseDirectory() .$fichier_template_fiche_resultats;

			$document = $PHPWord->loadTemplate($fichier_template);
			
		
			$document->setValue('Value1', $type_rapport);
			$document->setValue('Value2', $date_probable);
			$document->setValue('Value3', $nom_organisation);
			$document->setValue('Value4', $fund_source);
			$document->setValue('Value5', $libelle_allocation);
			$document->setValue('Value6', $titre_projet);
			$document->setValue('Value7', $projet_duree);
			$document->setValue('Value8', $libelle_province);
			$document->setValue('Value9', $libelle_cluster);
			$document->setValue('Value10', $date_demarrage_effectif);
	
			
			$var_directory =  eZSys::varDirectory();
			$filepath = eZSys::varDirectory() .$repertoire_cible_fiche_resultats;

			echo "var_directory=$var_directory \n";
			
			$filename=$filepath.$prefix_nom_cible_fiche_resultats.$projet_object_id."_".$fiche_resultat_object_id.".docx";
			$document->save($filename);
			
		}
	}
  
	
}  


?>
