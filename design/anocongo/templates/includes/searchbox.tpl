{default
    id = 'mainSearchBox'
    searchText = ''
}
<div id="tabs-1">
	<form class="searchbox" method="get" action={'content/search'|ezurl}>
		<input type="hidden" name="SearchType" value="ong" />
		<div class="input-field">
			<label>{"What, Who?"|i18n("ano")}</label>
			<input
				type="search"
				name="SearchWho"
				id="{$id}"
		    	placeholder="{"ex: plombier"|i18n("ano")}"
		    	value="{$searchText|wash}"
			/>
		</div>
		<div class="input-field">
			<label>{"Where?"|i18n("ano")}</label>
    		<input
		    	type="search"
		    	name="SearchWhere"
		    	id="{$id}"
		    	placeholder="{"ex: kinshasa"|i18n("ano")}"
		    	value="{$searchText|wash}"
		   	/>
		</div>
		<div class="go">
	    	<input type="submit" value="{'search'|i18n('ano')}" />
		</div>
	</form>
</div>
<div id="tabs-2">
	<form class="searchbox" method="get" action={'content/search'|ezurl}>
		<div class="input-field">
			<label>{"Who?"|i18n("ano")}</label>
    		<input
		    	type="search"
		    	name="SearchWho"
		    	id="{$id}"
		    	placeholder="{"ex: plombier"|i18n("ano")}"
		    	value="{$searchText|wash}"
		   	/>
		</div>
		<div class="input-field">
			<label>{"Where?"|i18n("ano")}</label>
    		<input
		    	type="search"
		    	name="SearchWhere"
		    	id="{$id}"
		    	placeholder="{"ex: kinshasa"|i18n("ano")}"
		    	value="{$searchText|wash}"
		   	/>
		</div>
		<div class="go">
	    	<input type="submit" value="{'search'|i18n('ano')}" />
		</div>
	</form>
</div>
<div id="tabs-3">
</div>{*
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
</form>*}
{/default}