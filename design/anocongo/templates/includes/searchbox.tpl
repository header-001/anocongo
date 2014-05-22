{default
    id = 'mainSearchBox'
    placeholder = ''
    searchText = ''
}
<form class="searchbox" method="get" action={'content/search'|ezurl}>
    <label for="{$id}">{'Search:'|i18n('basek/searchbox')}</label>
    <input
    	type="search"
    	name="SearchText"
    	id="{$id}"
    	{if $placeholder}placeholder="{$placeholder}"{/if}
        {if and( ezini_hasvariable( 'AutoCompleteSettings', 'AutoComplete', 'ezfind.ini' ), 
                 ezini( 'AutoCompleteSettings', 'AutoComplete', 'ezfind.ini' )|eq( 'enabled' ) 
        )}
    	    {ezscript_require( array( 'ezjsc::jquery', 'jquery.ezajax_autocomplete.js' ) ) }
    	    autocomplete="off"
            data-autocompleteurl={'ezjscore/call/basefind::autocomplete'|ezurl}
            data-minquerylength="{ezini( 'AutoCompleteSettings', 'MinQueryLength', 'ezfind.ini' )}"
            data-resultlimit="{ezini( 'AutoCompleteSettings', 'Limit', 'ezfind.ini' )}"
            data-searchtype="search"
    	{/if}
    	value="{$searchText|wash}"
    	 />
    <input type="submit" value="{'OK'|i18n('basek/searchbox')}" />
</form>
{/default}