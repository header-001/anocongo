{def $internal = $node.data_map.cible.has_content
     $cible    = cond( $internal,
                       $node.data_map.cible.content.main_node,
                       false()
                 )
     $valid =    cond( $internal, 
                       and( $cible.can_read, $cible.is_hidden|not, $cible.is_invisible|not ),
                       $node.data_map.location.has_content
                 )
     $url = ''
     $accroche = false()
     $visuels = false()
}

{if $valid}
	{set $url =      cond( $internal,
	                       $cible.url_alias,
	                       $node.data_map.location.content
	                 )
	     $visuels =  cond( $internal,
	                       cond( $node.data_map.visuels.has_content,
	                             $node.data_map.visuels,
	                             $cible.data_map.visuels
	                       ),
	                       $node.data_map.visuels
	                 )
	}
<article class="embed class-{$node.class_identifier}" id="o{$node.object.id}">
    <a href={$url|ezurl}{if $node.data_map.nouvel_onglet.content} rel="external"{/if}>
        {if and( $visuels, $visuels.has_content )}
            {def $visuel = fetch( 'content', 'object', hash( 'object_id', $visuels.content.relation_list.0.contentobject_id ) )}
            <div class="visuels">
                {content_view_gui content_object=$visuel view='visuel' image_class='line'}
            </div>
            {undef $visuel}
        {/if}
    </a>
</article>
{/if}
{undef $internal $cible $valid $url $visuels}