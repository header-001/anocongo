{* 
    Génération d'un menu sous forme de liste de liens
    Paramètres :
    - parent_node_id        int     noeud parent du menu. Par défaut l'accueil
    - class_filter_type     string  include|exclude. Par défaut exclude
    - class_filter_array    array   classes à inclure/exclure du menu. Par défaut vide
    - depth                 int     profondeur du menu. Par défaut 1
    - expand                string  none|active|all. Déploiement de la sous arborescence. Par défaut active.
    - show_all              bool    Si true affiché également les objets dont la case in_menu est décochée
    - css_class_func_alias  string  Alias de la fonction PHP renvoyant la classe CSS associée au noeud. La méthode sera appelée avec le noeud comme argument. Par défaut vide.
    - menu_css_class        string  Classe CSS du menu. Par défaut "menu". 
    - current_path_array    array   tableau des node_id parents de la page courante. Calculé automatiquement.
    - limit                 int     Nombre d'éléments à remonter. Par défaut false() -> sans limite. (Ne fonctionne que pour le premier niveau, à voir pour les autres...)
*}
{def
    $parent_node_id = first_set($parent_node_id, basek_root_node_id())
    $class_filter_type = first_set($class_filter_type, 'exclude')
    $class_filter_array = first_set($class_filter_array, array())
    $depth = first_set($depth, 1)
    $expand = first_set($expand, 'active' )
    $show_all = first_set($show_all, false())
    $css_class_func_alias = first_set($css_class_func_alias, '')
    $menu_css_class = first_set($menu_css_class, "menu")
    $current_path_array = first_set($current_path_array, array())
    $limit = first_set($limit, false())
    
    $parent_node = fetch('content', 'node', hash('node_id', $parent_node_id))
    
    $fetch_params = hash(
        'parent_node_id', $parent_node_id,
        'class_filter_type', $class_filter_type,
        'class_filter_array', $class_filter_array,
        'sort_by', $parent_node.sort_array,
        'limit', $limit
    )
    
    $nodes_count = false()
    $nodes = fetch( 'content', 'list', $fetch_params)
    
    $active = false()
    $node_class = ''
    $item_classes = array()
    
    $url = false()
    $external = false()
}
{* on commence par calculer le current_path_array pour pouvoir identifier les noeuds actifs *}
{if $current_path_array|count|eq(0)}
    {foreach $module_result.path as $path_item}
        {if is_set( $path_item.node_id )}
            {set $current_path_array = $current_path_array|append( $path_item.node_id )}
        {/if}
    {/foreach}
{/if}
{* on filtre les noeuds selon la valeur de leur attribut in_menu *}
{foreach $nodes as $node}
    {if or( $show_all, and( is_set( $node.data_map.in_menu ), $node.data_map.in_menu.content ) )}
        {set $nodes_count = true()}
        {break}
    {/if}
{/foreach}

{if $nodes_count}
<ul{if $menu_css_class|eq('')|not} class="{$menu_css_class}"{/if}>
    {foreach $nodes as $node}
        {set $item_classes = array()}
        {*debug-log var=$node.data_map.in_menu msg=$node.name*}
        {if or( $show_all, and( is_set( $node.data_map.in_menu ), $node.data_map.in_menu.content ) )}
            {set $active = $current_path_array|contains( $node.node_id )}
            {* S'il s'agit d'un lien on récupère l'URL cible *}
            {set $url = cond( 
                            $node.class_identifier|eq('link'),
                            cond( 
                                $node.data_map.cible.has_content,
                                $node.data_map.cible.content.main_node.url_alias,
                                $node.data_map.location.content
                            ),
                            $node.url_alias
                        )
                 $external = and( $node.class_identifier|eq('link'), $node.data_map.nouvel_onglet.content )
            }
            {if $active}
                {* Noeud actif, on ajoute la classe *}
                {set $item_classes = $item_classes|append( 'active' )}
            {/if}
            
            {* Classe spécifique s'il y en a une *}
            {set $node_class = cond( $css_class_func_alias, base_call_php_func( $css_class_func_alias, array( $node ) ), '')}
            {if $node_class|eq('')|not}
                {set $item_classes = $item_classes|append( $node_class )}
            {/if}
            
            <li{if $item_classes|count|gt(0)} class="{$item_classes|implode( ' ' )}"{/if}>
                <a href={$url|ezurl}{if $external} rel="external"{/if}>{$node.name|wash}</a>
                {if and( 
                        $depth|gt(1), 
                        or(
                            $expand|eq( 'all' ), 
                            and( 
                                $expand|eq( 'active' ),
                                $active 
                            )
                        ) 
                    )
                }
                    {* appel récursif *}
                    {include    
                        uri="design:includes/menu.tpl"
                        name="submenu"
                        
						parent_node_id=$node.node_id
						class_filter_type=$class_filter_type
						class_filter_array=$class_filter_array
						depth=$depth|dec
						expand=$expand
						show_all=$show_all
						css_class_func_alias=$css_class_func_alias
						menu_css_class="dropdown-menu"
						current_path_array=$current_path_array
                    }
                {/if}
            </li>
        {/if}
    {/foreach}
</ul>
{/if}
{undef 
    $parent_node_id 
    $class_filter_type
    $class_filter_array
    $depth
    $expand
    $show_all
    $css_class_func_alias
    $menu_css_class
    $current_path_array   
    $fetch_params
    $nodes_count
    $nodes
    $active
    $node_class
    $item_classes
}