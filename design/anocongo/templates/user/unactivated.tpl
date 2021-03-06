<div class="full">
<div class="col-xs-12 col-sm-9">
{def $uri = $module.functions.unactivated.uri}
<form name="activations" method="post" action={$uri|ezurl}>

{if and( is_set( $success_activate ), is_set( $errors_activate ) )}
    {if $success_activate}
    <div class="alert alert-dismissable alert-success">
        <h2>{'The following users have been successfully activated:'|i18n( 'design/admin/user/activations' )}</h2>
        <ul>
        {foreach $success_activate as $userid}
            {def $object = fetch( content, object, hash( 'object_id', $userid ) )}
            {if $object.status|eq( 1 )}
                <li><a href={$object.main_node.url_alias|ezurl}>{$object.name|wash}</a></li>
            {else}
                <li>{$object.name|wash}</li>
            {/if}
            {undef $object}
        {/foreach}
        </ul>
    </div>
    {/if}
    {if $errors_activate}
    <div class="alert alert-dismissable alert-danger">
        <h2>{'Some users have not been activated'|i18n( 'design/admin/user/activations' )}</h2>
    </div>
    {/if}
{elseif and( is_set( $success_remove ), is_set( $errors_remove ) )}
    {if $success_remove}
    <div class="alert alert-dismissable alert-info">
        <h2>{'The following unactivated users have been successfully removed:'|i18n( 'design/admin/user/activations' )}</h2>
        <ul>
        {foreach $success_remove as $name}
            <li>{$name|wash}</li>
        {/foreach}
        </ul>
    </div>
    {/if}
    {if $errors_remove}
    <div class="alert alert-dismissable alert-danger">
        <h2>{'Some users have not been removed'|i18n( 'design/admin/user/activations' )}</h2>
    </div>
    {/if}
{/if}



<div class="context-block">
{* DESIGN: Header START *}<div class="box-header"><div class="box-ml">
<h1 class="context-title">{'Unactivated users (%users_count)'|i18n( 'design/admin/user',, hash( '%users_count', $unactivated_count ) )}</h1>
{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{* Items per page selector. *}
<div class="context-toolbar">
<div class="button-left">
<p class="table-preferences">
{switch match=$number_of_items}
{case match=25}
<a href={concat( '/user/preferences/set/', $limit_preference, '/1' )|ezurl}>10</a>
<span class="current">25</span>
<a href={concat( '/user/preferences/set/', $limit_preference, '/3' )|ezurl}>50</a>
{/case}

{case match=50}
<a href={concat( '/user/preferences/set/', $limit_preference, '/1' )|ezurl}>10</a>
<a href={concat( '/user/preferences/set/', $limit_preference, '/2' )|ezurl}>25</a>
<span class="current">50</span>
{/case}

{case}
<span class="current">10</span>
<a href={concat( '/user/preferences/set/', $limit_preference, '/2' )|ezurl}>25</a>
<a href={concat( '/user/preferences/set/', $limit_preference, '/3' )|ezurl}>50</a>
{/case}

{/switch}
</p>
</div>
<div class="float-break"></div>
</div>

{if $unactivated_count}
    <table class="list" cellspacing="0">
    <tr>
        <th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} width="16" height="16" alt="{'Toggle selection'|i18n( 'design/admin/user' )}" onclick="ezjs_toggleCheckboxes( document.activations, 'DeleteIDArray[]' ); return false;"/></th>
        <th{cond( $sort_field|eq( 'time' ), concat( ' class="sort-', $sort_order, '"' ), '' )}><a href={concat(
            $uri, '/time/', cond( and( $sort_field|eq( 'time' ), $sort_order|eq( 'asc' ) ), 'desc', 'asc' ) )|ezurl}>{'Registration date'|i18n( 'design/admin/user' )}</a></th>
        <th>{'Name'|i18n( 'design/admin/user' )}</th>
        <th{cond( $sort_field|eq( 'login' ), concat( ' class="sort-', $sort_order, '"' ), '' )}><a href={concat(
            $uri, '/login/', cond( and( $sort_field|eq( 'login' ), $sort_order|eq( 'asc' ) ), 'desc', 'asc' ) )|ezurl}>{'Login'|i18n( 'design/admin/user' )}</a></th>
        <th{cond( $sort_field|eq( 'email' ), concat( ' class="sort-', $sort_order, '"' ), '' )}><a href={concat(
            $uri, '/email/', cond( and( $sort_field|eq( 'email' ), $sort_order|eq( 'asc' ) ), 'desc', 'asc' ) )|ezurl}>{'E-mail'|i18n( 'design/admin/user' )}</a></th>
    </tr>
    {foreach $unactivated_users as $user sequence array( 'bglight', 'bgdark' ) as $style}
    <tr class="{$style}">
        <td><input type="checkbox" name="DeleteIDArray[]" id="delete-{$user.contentobject_id}" value="{$user.contentobject_id}" /></td>
        <td><label for="delete-{$user.contentobject_id}">{$user.account_key.time|l10n( 'shortdatetime' )}</label></td>
        <td><label for="delete-{$user.contentobject_id}">{$user.contentobject.name|wash()}</label></td>
        <td><label for="delete-{$user.contentobject_id}">{$user.login|wash()}</label></td>
        <td><label for="delete-{$user.contentobject_id}">{$user.email|wash()}</label></td>
    </tr>
    {/foreach}

    </table>

    <div class="context-toolbar">
    {include name=navigator
             uri='design:navigator/google.tpl'
             page_uri=concat( '/user/unactivated/', $sort_field, '/', $sort_order )
             item_count=$unactivated_count
             view_parameters=$view_parameters
             item_limit=$number_of_items}
    </div>
{else}
    <div class="block">
        <p>{'There are no unactivated users'|i18n( 'design/admin/user/activations' )}</p>
    </div>
{/if}

{* DESIGN: Content END *}</div></div></div>

{if $unactivated_count}
<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml">
<div class="block">
    <input class="btn btn-primary" type="submit" name="ActivateButton" value="{'Activate selected users'|i18n( 'design/admin/user' )}" title="{'Activate selected users.'|i18n( 'design/admin/user' )}" />
    <input class="btn btn-primary" type="submit" name="RemoveButton" value="{'Remove selected users'|i18n( 'design/admin/user' )}" title="{'Remove selected users.'|i18n( 'design/admin/user' )}" />
</div>
{* DESIGN: Control bar END *}</div></div>
</div>
{/if}

</div>
</form>
{undef $uri}
</div></div>
