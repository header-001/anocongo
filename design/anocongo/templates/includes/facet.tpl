<aside class="">
	<ul id="active-facets-list">
		{foreach $defaultSearchFacets as $key => $defaultFacet}
	      {if array_keys( $activeFacetParameters )|contains( concat( $defaultFacet['field'], ':', $defaultFacet['name']  ) )}
	          {def $facetData=$search_extras.facet_fields.$key}
	
	          {foreach $facetData.nameList as $key2 => $facetName}
	              {if eq( $activeFacetParameters[concat( $defaultFacet['field'], ':', $defaultFacet['name'] )], $facetName )}
	                  {set $activeFacetsCount=sum( $key, 1 )}
	                  {def $suffix=$uriSuffix|explode( concat( '&filter[]=', $facetData.fieldList[$key2], ':"', $key2|solr_quotes_escape, '"' ) )|implode( '' )|explode( concat( '&activeFacets[', $defaultFacet['field'], ':', $defaultFacet['name'], ']=', $facetName ) )|implode( '' )}
	                  <li>
	                      <a href={concat( $baseURI, $suffix )|ezurl}>[x]</a> <strong>{$defaultFacet['name']}</strong>: {$facetName|trim('"')|wash}
	                  </li>
	              {/if}
	          {/foreach}
	          {undef $facetData}
	      {/if}
	  	{/foreach}
	</ul>
	<ul id="facet-list">
          {foreach $defaultSearchFacets as $key => $defaultFacet}
              {if array_keys( $activeFacetParameters )|contains( concat( $defaultFacet['field'], ':', $defaultFacet['name']  ) )|not}
              <li>
                {def $facetData=$search_extras.facet_fields.$key}
                  <span {*style="background-color: #F2F1ED"*}><strong>{$defaultFacet['name']}</strong></span>
                  <ul>
                    {foreach $facetData.nameList as $key2 => $facetName}
                        {if ne( $key2, '' )}
                        <li>
                            <a href={concat(
                                $baseURI, '&filter[]=', $facetData.fieldList[$key2], ':"', $key2|solr_quotes_escape|rawurlencode, '"',
                                '&activeFacets[', $defaultFacet['field'], ':', $defaultFacet['name'], ']=',
                                $facetName|rawurlencode,
                                $uriSuffix )|ezurl}>
                            {$facetName|wash}</a> ({$facetData.countList[$key2]})
                        </li>
                        {/if}
                    {/foreach}
                  </ul>
                  {undef $facetData}
              </li>
              {/if}
          {/foreach}
	</ul>
</aside>