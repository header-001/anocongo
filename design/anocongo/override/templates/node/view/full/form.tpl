{def
    $object = $node.object
    $field_error = ""
    $error_display = ezini( 'FormSettings', 'ErrorDisplay', 'basek.ini' )
    
    $alias = cond( 'gallery_slideshow', 'gallery' )
    $hash = concat( $node.object.id, $node.object.current_version, $alias, rand( 0, 256 ) )|md5
}

<div class="full class-form form-{$object.class_identifier}">
    {if and( $object.data_map.long_title,  $object.data_map.long_title.has_content )}
    <h1>{$object.data_map.long_title.content|wash}</h1>
    {else}
    <h1>{$object.name|wash}</h1>
    {/if}

    
    <form action={'contentlink/collectinformation'|ezurl} method="post" enctype="multipart/form-data">

        {if and(
                $validation.processed,
                array( 'global', 'all' )|contains( $error_display )
        )}
	        {include name=Validation uri='design:content/collectedinfo_validation.tpl'
	                 class='message-warning'
	                 validation=$validation collection_attributes=$collection_attributes}
        {elseif and( $object.data_map.intro, $object.data_map.intro.has_content) }
            <div class="intro ezxmltext">{attribute_view_gui attribute=$object.data_map.intro}</div>
        {/if}

        {foreach $object.data_map as $attribute}
            {if $attribute.is_information_collector}
                {set $field_error = cond(
                       is_set( $validation ),
                       $validation.attributes|base_find_hash_with_value( 'id', $attribute.id ),
                       null
                    )
                }
                {attribute_view_gui
                    attribute=$attribute error=$field_error
                    show_error=array( 'field', 'all' )|contains( $error_display )
                    error_message=cond( $field_error, $field_error.description, '')
                }
            {/if}
        {/foreach}

        <div class="form-buttons">
            <input type="hidden" name="ContentObjectID" value="{$object.id}" />
            <input type="hidden" name="ContentNodeID" value="{$object.main_node_id}" />
            <input type="submit" name="ActionCollectInformation" value="{'Send'|i18n('basek/forms')}" />
        </div>
    </form>
    
    {include uri="design:includes/related_object.tpl" current_node=$node}   
    
</div>