{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{if $attribute.data_text}
<a href="{$attribute.content|wash( xhtml )}" target="_blank" rel="external">{$attribute.data_text|wash( xhtml )}</a>
{else}
<a href="{$attribute.content|wash( xhtml )}" target="_blank" rel="external">{$attribute.content|wash( xhtml )}</a>
{/if}