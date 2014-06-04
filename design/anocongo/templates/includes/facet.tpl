<aside class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
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
	<div id="facet-list" class="accordion">
          {foreach $defaultSearchFacets as $key => $defaultFacet}
              {if array_keys( $activeFacetParameters )|contains( concat( $defaultFacet['field'], ':', $defaultFacet['name']  ) )|not}
			<div class="accordion-group">
                {def $facetData=$search_extras.facet_fields.$key}
                  <div class="accordion-heading">
                  	 <a href="#collapse{$key}" data-parent="#facet-list" data-toggle="collapse" class="accordion-toggle">{$defaultFacet['name']}</a>
                  </div>
                  <div class="accordion-body collapse" id="collapse{$key}">
                  	<ul>
                    {foreach $facetData.nameList as $key2 => $facetName}
                        {if ne( $key2, '' )}
                        <li>
                            <a href={concat(
                                $baseURI, '&filter[]=', $facetData.fieldList[$key2], ':"', $key2|solr_quotes_escape, '"',
                                '&activeFacets[', $defaultFacet['field'], ':', $defaultFacet['name'], ']=',
                                $facetName,
                                $uriSuffix )|ezurl}>
                            {$facetName|wash}</a> ({$facetData.countList[$key2]})
                        </li>
                        {/if}
                    {/foreach}
                    </ul>
                  </div>
                  {undef $facetData}
              </div>
              {/if}
          {/foreach}
	</div>
</aside>
