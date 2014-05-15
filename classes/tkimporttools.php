<?php 

class TKImportTools
{
	
	
	static function getEZXMLFromHTML($html)
	{
		$parser = new SQLIXMLInputParser();
		$parser->setParseLineBreaks( true );
		$document = $parser->process( $html ); // Result is a DOM Document
		return eZXMLTextType::domString( $document );
	}
	
	static function getEZXMLFromText($text)
	{
		return self::getEZXMLFromHTML('<p>'.$text.'</p>');
	}
	
	/**
	 * @param array
	 * @return $object
	 */
	static function createOrUpdateObject($params)
	{
		if (!$params['remote_id'])
		{
			return false;
		}
		
		$object = eZContentObject::fetchByRemoteID($params['remote_id']);
		
		if ($object instanceof eZContentObject)
		{
			eZContentFunctions::updateAndPublishObject($object,$params);
			//echo "\n UPDATE\n";
			return $object;
		} else {
			return eZContentFunctions::createAndPublishObject($params);
		}
	}
	
	
}

?>