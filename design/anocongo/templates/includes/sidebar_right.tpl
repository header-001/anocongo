{def $sidebar_right = base_persistent_var_get( 'sidebar_right' )}
{if and( is_set( $sidebar_right ), $sidebar_right.hide )|not}
	{def $col_droite = fetch( 'content', 'object', hash( 'remote_id', 'COLONNE_DROITE' ) ) 
		$children = fetch( 'content', 'list',  hash( 'parent_node_id', $col_droite.main_node_id,
                                    'sort_by', $node.sort_array))}
	    <aside id="sidebar-right" class="sidebar">
			    {attribute_view_gui attribute=$col_droite.data_map.description}
			    
		    <ul>
			{foreach $children as $child}
				<li>{node_view_gui view='embed' content_node=$child}</li>
			{/foreach}
			</ul>
	    </aside>
	    
	{undef $col_droite}
{/if}
{undef $sidebar_right}