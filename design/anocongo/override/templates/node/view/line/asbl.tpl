<li  itemscope itemtype="http://schema.org/NGO" class="lineOng" >
	<span class="number">{$range}</span>
	<div class="carteListContent cl">
		<h2 itemprop="name" class="titleCarte">
			<a href={$node.url_alias|ezurl}>
				<span>{$node.name} - <span class="color_sigle" >{$node.data_map.sigle.data_text}</span></span>
			</a>
		</h2>
		
		<div class="visualOng">
			<!--
			<a href="" class="" >
			<img src="http://static2.pagesjaunes.fr/nsapi/pmicro/AAABBEMMVOFL/10003/x.gif" alt="" height="60" width="80" alt="" >
			</a>
			<meta itemprop="image" content="http://static2.pagesjaunes.fr/nsapi/pmicro/AAABBEMMVOFL/10003/x.gif">
			-->
		</div>
		<div class="dataOng cl">
			<div class="minidetails">
				<p class="addr" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
				<span itemprop="streetAddress">{$node.data_map.adresse.data_text}</span><br>
				<span class="nowrap"> 
				{if and( $node.data_map.code_postal,  $node.data_map.code_postal.has_content )}
					<span itemprop="postalCode">{attribute_view_gui attribute=$node.data_map.code_postal}</span>
				{/if}
				<span itemprop="addressLocality">{attribute_view_gui attribute=$node.data_map.province}</span>
				</span><br>
				<span itemprop="addressLocality" class="localisation" >
				<span class="com">{attribute_view_gui attribute=$node.data_map.commune}</span> - 
				<span class="dist">{attribute_view_gui attribute=$node.data_map.district}</span> -  
				<span class="prov">{attribute_view_gui attribute=$node.data_map.province}</span>
				</span><br>
				<meta itemprop="latitude" content="48.8644">
				<meta itemprop="longitude" content="2.3466">
				</p>	
			</div>
		</div>
	</div>
	<div class="bottom_ong">							
		<div class="secteur">
			Secteurs d'activités :
			<ul>
				<li class=""><a href="">Paix et Démocration</a></li>
				<li class=""><a href="">Bonne gouvernance</a></li>
			</ul>
		</div>
		<div class="bottom-container cl">
			<div class="bot bot-links">
				{if and( $node.data_map.site_web,  $node.data_map.site_web.has_content )}
				<p class="siteWeb">
					Site internet&nbsp;:&nbsp;
					{attribute_view_gui attribute=$node.data_map.site_web}
				</p>
				{/if}
				<p class="contactEmail">
					Email&nbsp;:&nbsp;<a itemprop="email" class="" data-toggle="modal" data-target="#myModal" >Contacter par email</a>
				</p>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Modal title</h4>
							</div>
							<div class="modal-body">
								<form class="form-horizontal">
									<fieldset>
										<legend>Legend</legend>
										<div class="form-group">
										<label for="inputEmail" class="col-lg-2 control-label">Email</label>
										<div class="col-lg-10">
										<input type="text" class="form-control" id="inputEmail" placeholder="Email">
										</div>
										</div>
										<div class="form-group">
										<label for="inputPassword" class="col-lg-2 control-label">Password</label>
										<div class="col-lg-10">
										<input type="password" class="form-control" id="inputPassword" placeholder="Password">
										<div class="checkbox">
										<label>
										<input type="checkbox"> Checkbox
										</label>
										</div>
										</div>
										</div>
										<div class="form-group">
										<label for="textArea" class="col-lg-2 control-label">Textarea</label>
										<div class="col-lg-10">
										<textarea class="form-control" rows="3" id="textArea"></textarea>
										<span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
										</div>
										</div>
										<div class="form-group">
										<label class="col-lg-2 control-label">Radios</label>
										<div class="col-lg-10">
										<div class="radio">
										<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
										Option one is this
										</label>
										</div>
										<div class="radio">
										<label>
										<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
										Option two can be something else
										</label>
										</div>
										</div>
										</div>
										<div class="form-group">
										<label for="select" class="col-lg-2 control-label">Selects</label>
										<div class="col-lg-10">
										<select class="form-control" id="select">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										</select>
										<br>
										<select multiple="" class="form-control">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										</select>
										</div>
										</div>
										<div class="form-group">
										<div class="col-lg-10 col-lg-offset-2">
										<button class="btn btn-default">Cancel</button>
										<button type="submit" class="btn btn-primary">Submit</button>
										</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" >Annuler</button>
								<button type="button" class="btn btn-primary">Envoyer</button>
							</div>
						</div>
					</div>
				</div>
				<p class="" >Téls&nbsp;:&nbsp; 
				{if and( $node.data_map.telephone1,  $node.data_map.telephone1.has_content )}
					<span class="telephone" itemprop="telephone" >{attribute_view_gui attribute=$node.data_map.telephone1}</span>
				{/if}
				{if and( $node.data_map.telephone2,  $node.data_map.telephone2.has_content )}
					 | <span class="telephone" itemprop="telephone" >{attribute_view_gui attribute=$node.data_map.telephone2}</span>
				{/if}
				{if and( $node.data_map.telephone3,  $node.data_map.telephone3.has_content )}
					 | <span class="telephone" itemprop="telephone" >{attribute_view_gui attribute=$node.data_map.telephone3}</span>
				{/if}
				</p>
			</div>
			{*
			<div class="responsables">
				<p id="" class="">Responsable(s) :</p>
				<ul id="">
					<li style="display: list-item;" ><a href=""><strong><span>Jérôme Bonso</span></strong></a></li>          
					<li style="display: list-item;" ><a href=""><strong><span>Grace LULA</span></strong></a></li>
					<li style=" display: list-item;" ><a href=""><strong><span>Gérard BISAMBU</span></strong></a></li>
				</ul>
			</div>
			*}
		</div>
	</div>
</li>


