{if $attribute.data_text|wash( xhtml )|begins_with('0')}
	{$attribute.data_text|replace( 0, 1, '+243' )|wash( xhtml )}
{else}
	{$attribute.data_text|wash( xhtml )}
{/if}