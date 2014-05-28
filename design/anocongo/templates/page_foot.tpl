
{ezscript_require(array( 'ezjsc::jquery', 'ezjsc::jqueryio') )}
{def
	$scriptfiles = ezini('JavaScriptSettings', 'FrontendJavaScriptList', 'design.ini')
}

{ezscript_require($scriptfiles)}
{ezscript_load()}

{def $analytics_config = ezini('GoogleTools', 'Analytics', 'basekit.ini') }
{if $analytics_config.key}
{literal}
  <script>
   var _gaq = [
    ['_setAccount', '{/literal}{$analytics_config.key}{literal}'],{/literal}
    {if $analytics_config.domain}
    {literal}['_setDomainName', '{/literal}{$analytics_config.domain}{literal}'],
    ['_setAllowLinker', true],
    ['_setAllowHash', false],
    {/literal}
    {/if}
    {if $analytics_config.TrackPageSpeed|eq('enabled')}
    ['_trackPageLoadTime'],
    {/if}
    {literal}['_trackPageview']
   ];
   (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
   })();
  </script>
{/literal}

{/if}
{include uri="design:specific_page_foot.tpl"}
