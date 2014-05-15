{*def $sidebar_left = base_persistent_var_get( 'sidebar_left' )}
{if and( is_set( $sidebar_left ), $sidebar_left.hide )|not}
    <aside id="sidebar-left" class="sidebar">
        <h1>Sidebar</h1>
    </aside>
{/if}
{undef $sidebar_left*}