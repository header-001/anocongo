{def
    $footer      = fetch( 'content', 'object', hash( 'remote_id', 'FOOTER' ) )
}
<footer id="footer">
	<div class="container">
	    <div class="footer_haut ezxmltext">
		    {attribute_view_gui attribute=$footer.data_map.description}
		</div>
		<div class="footer_bas">
		    {attribute_view_gui attribute=$footer.data_map.accroche}
		    
		    <span class="itech">
		    	<a href="#"><img src={'images/itech.png'|ezdesign} alt="itech" id="itech" /></a>
		    </span>
    	</div>

		{*include uri="design:includes/sharebar.tpl"*}
	</div>
</footer>
