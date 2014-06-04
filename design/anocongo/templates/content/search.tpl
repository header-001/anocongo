{basek_persistent_var_set( 'sidebar_right',hash('hide',true()))}
{def $limit = 10
	$baseURI	= '/content/search'
	$searchType=""
	$searchWho=""
	$class_id = array()
	$subtree_array=2
	$filterParameters = fetch( 'ezfind', 'filterParameters' )
	$defaultSearchFacets =array()
	$page_uri_suffix=""
	$activeFacetParameters = array()
	$uriSuffix = ''
}
{set  $search_text ="*"}
{set  $defaultSearchFacets = $defaultSearchFacets|append(hash( 'field','attr_province_lk','name',"Province"),
														hash( 'field','attr_district_lk','name',"District"),
														hash( 'field','attr_commune_lk','name',"Commune"),
														hash( 'field','attr_secteurs_activites_lk','name',"Secteurs d'activité")
														)}

{if ezhttp_hasvariable( 'activeFacets', 'get' )}
    {set $activeFacetParameters = ezhttp( 'activeFacets', 'get' )}
{/if}
{foreach $activeFacetParameters as $facetField => $facetValue}
    {set $uriSuffix = concat( $uriSuffix, '&activeFacets[', $facetField, ']=', $facetValue )}
{/foreach}
{foreach $filterParameters as $name => $value}
    {set $uriSuffix = concat( $uriSuffix, '&filter[]=', $name, ':', $value )}
{/foreach}
{if ezhttp_hasvariable( 'SearchType', 'get' )}
    {set $searchType = ezhttp( 'SearchType', 'get' )}
    {set $class_id = $class_id|append($searchType)}
    {set $subtree_array= array(ezini( 'General', 'OngsRootId', 'anocongo.ini' ))}
    {set $baseURI = concat($baseURI,"?SearchType=",$searchType)}
{/if}
{if ezhttp_hasvariable( 'SearchWho', 'get' )}
    {set $searchWho = ezhttp( 'SearchWho', 'get' )}
    {set $filterParameters = $filterParameters|merge(hash('attr_nom_t',$searchWho))}
    {set $baseURI = concat($baseURI,"&SearchWho=",$searchWho)}
    {set $page_uri_suffix = concat("?SearchType=",$searchType,"&SearchWho=",$searchWho, $uriSuffix )}
{/if}
{set-block scope=root variable=basek_page_title}{'Results for your search "%searchText"'|i18n("basekit/search", '', hash( '%searchText', $search_text ) )}{/set-block}

{def 	$search = array()
		$hash = hash( 	'query', $search_text,
	             		'subtree_array', $subtree_array,
	                	'class_id', $class_id,
	             		'offset', $view_parameters.offset,
	                  	'facet', $defaultSearchFacets,
	                  	'filter', $filterParameters,
	                   	'limit', $limit,
	              		'spell_check', array( true() ),
                		'sort_by', hash( 'score', 'desc' ),
                      )}                     
{set $search=fetch( 'ezfind', 'search',$hash)}
{set $search_result=$search['SearchResult']}
{set $search_count=$search['SearchCount']}
{def $search_extras=$search['SearchExtras']}

{*$search_count*}
{*$hash|attribute(show,3)*}    
{*$search_result|attribute(show,1)*} 

<div class="row row-offcanvas row-offcanvas-left">
	{include name=facet
	         uri='design:includes/facet.tpl'
	         page_uri_suffix=$page_uri_suffix
	         baseURI=$baseURI
	         search_extras=$search_extras
	         defaultSearchFacets=$defaultSearchFacets
	         filterParameters=$filterParameters
	         activeFacetParameters=$activeFacetParameters
	         activeFacetsCount=0
	         uriSuffix=$uriSuffix}
	<div id="search-results" class="col-xs-12 col-sm-9">
	  	<p class="pull-left visible-xs">
	    	<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
	  	</p>
	    {include name=Navigator
	             uri='design:navigator/google.tpl'
	             page_uri='/content/search'
	             page_uri_suffix=$page_uri_suffix
	             item_count=$search_count
	             view_parameters=$view_parameters
	             item_limit=$limit}
		<ol>
	    {foreach $search_result as $k => $result}
	       	{*node_view_gui view=ezfind_line sequence=$bgColor use_url_translation=$use_url_translation content_node=$result*}
	    	{node_view_gui view=line 
							content_node=$result
							range=sum(sum($k,1),$view_parameters.offset)
							}
	    {/foreach}
		</ol>
	    {include name=Navigator
	             uri='design:navigator/google.tpl'
	             page_uri='/content/search'
	             page_uri_suffix=$page_uri_suffix
	             item_count=$search_count
	             view_parameters=$view_parameters
	             item_limit=$limit}
	  </div> 
</div>