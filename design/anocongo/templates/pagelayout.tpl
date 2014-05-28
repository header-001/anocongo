{if and( is_set( $module_result.content_info.persistent_variable.redirect ),
         $module_result.content_info.persistent_variable.redirect )}{redirect( $module_result.content_info.persistent_variable.redirect )}{/if}
{def
    $user_hash         = concat( $current_user.role_id_list|implode( ',' ), ',', $current_user.limited_assignment_value_list|implode( ',' ) )
    $current_node_id   = cond($module_result.node_id, $module_result.node_id, 0)
    $index_page        = basek_root_node_id()
    $front_page        = fetch( 'content', 'node', hash( 'node_id', $index_page ) )
    $current_node      = fetch( 'content', 'node', hash( 'node_id', $current_node_id ) )
    $page_css_class    = first_set( basek_call_php_func('pageCSSClass', array( $current_node ) ), '')


    $expiry            = ezini( 'CacheBlockSettings', 'Expiry', 'basekit.ini' )
    $subtree_expiry    = ezini( 'CacheBlockSettings', 'SubtreeExpiry', 'basekit.ini' )

    $cache_blocks      = array( 'PageHead', 'Header', 'Footer', 'PageFoot' )
    $cache_block_keys  = hash()
    $cache_block_subexp= hash()
    $cache_settings    = false()
    $tmp_keys          = array()
}
{if is_set( $extra_cache_key )|not}{def $extra_cache_key = ''}{/if}
<!doctype html>
<!--[if lt IE 7 ]> <html lang="{$site.http_equiv.Content-language|wash}" class="no-js ie6 {$page_css_class}"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$site.http_equiv.Content-language|wash}" class="no-js ie7 {$page_css_class}"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$site.http_equiv.Content-language|wash}" class="no-js ie8 {$page_css_class}"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$site.http_equiv.Content-language|wash}" class="no-js ie9 {$page_css_class}"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{$site.http_equiv.Content-language|wash}" class="no-js {$page_css_class}"> <!--<![endif]-->
<head>

{* On charge les clés des différents cache-blocks *}
{foreach $cache_blocks as $name}
    {set
        $cache_settings = ezini( 'CacheBlockSettings', concat( $name, 'Keys' ), 'basekit.ini' )
        $tmp_keys = array()
    }
    {foreach $cache_settings as $alias}
        {switch match=$alias}
            {case match='uri'}
                {set $tmp_keys = $tmp_keys|append( cond( $module_result.uri, $module_result.uri, '_index_page_') )}
            {/case}
            {case match='siteaccess'}
                {set $tmp_keys = $tmp_keys|append( $access_type.name )}
            {/case}
            {case match='user'}
                {set $tmp_keys = $tmp_keys|append( $current_user.contentobject_id )}
            {/case}
            {case match='permissions'}
                {set $tmp_keys = $tmp_keys|append( $user_hash )}
            {/case}
            {case}{/case}
        {/switch}
    {/foreach}
    {set $cache_block_keys = $cache_block_keys|merge( hash( $name, $tmp_keys|append( $extra_cache_key ) ) )}

	{* gestion des alias pour le subtree_expiry *}
    {if is_set( $subtree_expiry[$name] )}
    	{if $subtree_expiry[$name]|eq('node_id')}
    		{set $cache_block_subexp = $cache_block_subexp|merge( hash( $name, $current_node.node_id ) )}
    	{elseif $subtree_expiry[$name]|begins_with('path:')}
    		{set $cache_block_subexp = $cache_block_subexp|merge( hash( $name, $current_node.path_array[ $subtree_expiry[$name]|explode(':').1 ] ) )}
    	{else}
			{set $cache_block_subexp = $cache_block_subexp|merge( hash( $name, $subtree_expiry[$name] ) )}
    	{/if}
    {/if}
{/foreach}

{debug-log var=$cache_block_keys msg="Cache-block Keys"}
{debug-log var=$cache_block_subexp msg="Cache-block Subtree Expiry"}

	{cache-block
	   keys=$cache_block_keys['PageHead']
	   expiry=cond( is_set( $expiry.PageHead ), $expiry.PageHead, 7200 )
	   ignore_content_expiry=true()
	   subtree_expiry=cond( is_set( $cache_block_subexp.PageHead ), $cache_block_subexp.PageHead, 1 )
	}
	   {include uri='design:page_head.tpl'}
    {/cache-block}
</head>

<body>
	{cache-block
	  keys=$cache_block_keys['Header'] expiry=10
      expiry=cond( is_set( $expiry.Header ), $expiry.Header, 7200 )
      ignore_content_expiry=true()
      subtree_expiry=cond( is_set( $cache_block_subexp.Header ), $cache_block_subexp.Header, 1 )
	}
		{include uri='design:includes/header.tpl' current_node=$current_node}
	{/cache-block}
    <div class="container">
	
	    {include uri="design:includes/sidebar_left.tpl"}
	    
	    {include uri="design:includes/messages.tpl" name="messages"}
		{$module_result.content}
	
	    {include uri="design:includes/sidebar_right.tpl"}
	</div>
	{cache-block
	   keys=$cache_block_keys['Footer']
       expiry=cond( is_set( $expiry.Footer ), $expiry.Footer, 7200 )
       ignore_content_expiry=true()
       subtree_expiry=cond( is_set( $cache_block_subexp.Footer ), $cache_block_subexp.Footer, 1 )
	}
	    {set $current_node=first_set( $current_node, fetch( 'content', 'node', hash( 'node_id', $current_node_id ) ) )}
		{include uri='design:includes/footer.tpl' current_node=$current_node}
	{/cache-block}

	{cache-block
	   keys=$cache_block_keys['PageFoot']
       expiry=cond( is_set( $expiry.PageFoot ), $expiry.PageFoot, 7200 )
       ignore_content_expiry=true()
       subtree_expiry=cond( is_set( $cache_block_subexp.PageFoot ), $cache_block_subexp.PageFoot, 1 )
	}
        {include uri='design:page_foot.tpl' current_node=$current_node}
        {include uri='design:baselightbox.tpl'}
	{/cache-block}

	<!--DEBUG_REPORT-->

</body>
</html>