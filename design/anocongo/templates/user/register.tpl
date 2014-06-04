<div class="full">
	
<div class="col-xs-12 col-sm-9">	
<div class="well bs-component">
<form enctype="multipart/form-data"  action={"/user/register/"|ezurl} method="post" name="Register"  class="form-horizontal" >

<div class="maincontentheader">
<h1>{"Register user"|i18n("design/standard/user")}</h1>
</div>

{if and( and( is_set( $checkErrNodeId ), $checkErrNodeId ), eq( $checkErrNodeId, true ) )}
    <div class="message-error">
        <h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {$errMsg}</h2>
    </div>
{/if}

{section show=$validation.processed}

    {section name=UnvalidatedAttributes loop=$validation.attributes show=$validation.attributes}
       <div class="alert alert-dismissable alert-danger">
	   <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{"Input did not validate"|i18n("design/standard/user")}</strong>

			{$UnvalidatedAttributes:item.name}: {$UnvalidatedAttributes:item.description}

        </div>
    {section-else}
<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <h2>{"Input was stored successfully"|i18n("design/standard/user")}</h2>
        </div>
    {/section}

{/section}

{section show=count($content_attributes)|gt(0)}
    {*section name=ContentObjectAttribute loop=$content_attributes}
    <input type="hidden" name="ContentObjectAttribute_id[]" value="{$ContentObjectAttribute:item.id}" />
    <div class="form-group">
       <label  class="col-sm-2 control-label">{$ContentObjectAttribute:item.contentclass_attribute.name}</label>
	   <div class="col-sm-10">
        {attribute_edit_gui attribute=$ContentObjectAttribute:item}
		</div>
	</div>
    {/section*}

    <input type="hidden" name="ContentObjectAttribute_id[]" value="2660">
    <div class="form-group">
       <label class="col-sm-2 control-label">{"First name"|i18n("design/standard/user")}:</label>
	   <div class="col-sm-10">
			<input type="text" class="form-control"  name="ContentObjectAttribute_ezstring_data_text_2660" value="" required="required">
		</div>
	</div>
	
    <input type="hidden" name="ContentObjectAttribute_id[]" value="2661">
    <div class="form-group">
       <label class="col-sm-2 control-label">{"Last name"|i18n("design/standard/user")}:</label>
	   <div class="col-sm-10">
			<input type="text" class="form-control"  name="ContentObjectAttribute_ezstring_data_text_2661" value="" required="required">
		</div>
	</div>
    
	<input type="hidden" name="ContentObjectAttribute_id[]" value="2662">
    <div class="form-group">       
	    <label class="col-sm-2 control-label">Identifiant:</label>
		 <div class="col-sm-10">
			<input class="form-control"  type="text" name="ContentObjectAttribute_data_user_login_2662" size="16" value="" required="required">
		</div>
	</div>	
	
	<div class="form-group">	
        <label class="col-sm-2 control-label">Courriel:</label>
		<div class="col-sm-10">
			<input class="form-control"  type="email" name="ContentObjectAttribute_data_user_email_2662" size="28" value="" required="required">
		</div>
	</div>	
	
	<div class="form-group">
	    <label class="col-sm-2 control-label">Mot de passe:</label>
		<div class="col-sm-10">
			<input class="form-control"  type="password" name="ContentObjectAttribute_data_user_password_2662" size="16" value="" required="required">
		</div>
	</div>
	
	<div class="form-group">
	    <label class="col-sm-2 control-label">Confirmer le mot de passe:</label>
		<div class="col-sm-10">
	    <input class="form-control"  type="password" name="ContentObjectAttribute_data_user_password_confirm_2662" size="16" value="" required="required">
		</div>
	</div>
	
	
    <input type="hidden" name="ContentObjectAttribute_id[]" value="2664">
    <div class="form-group">
       <label class="col-sm-2 control-label">Image</label>
	   <div class="col-sm-10">
			<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
			<input  name="ContentObjectAttribute_data_imagename_2664" type="file">
		</div>
	</div>	
	
	<div class="form-group">
	    <label class="col-sm-2 control-label">Texte alternatif de l'image:</label>
		 <div class="col-sm-10">
			<input class="form-control" name="ContentObjectAttribute_data_imagealttext_2664" type="text" value="">
		</div>
	</div>
	
    <div class="form-group">
	<div class="col-sm-10">
        <p>{"Please note that your browser must use and support cookies to register a new user."|i18n("design/standard/user")}</p>
    </div></div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    {if and( is_set( $checkErrNodeId ), $checkErrNodeId )|not()}
        <input class=" btn btn-primary" type="submit" id="PublishButton" name="PublishButton" value="{'Register'|i18n('design/standard/user')}" onclick="window.setTimeout( disableButtons, 1 ); return true;" />
    {else}
        <input class=" btn btn-primary" type="submit" id="PublishButton" name="PublishButton" disabled="disabled" value="{'Register'|i18n('design/standard/user')}" onclick="window.setTimeout( disableButtons, 1 ); return true;" />
    {/if}
        <input class=" btn btn-primary" type="submit" id="CancelButton" name="CancelButton" value="{'Discard'|i18n('design/standard/user')}" onclick="window.setTimeout( disableButtons, 1 ); return true;" />
    </div>
	</div>
{section-else}
    <div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <h2>{"Unable to register new user"|i18n("design/standard/user")}</h2>
    </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input class=" btn btn-primary" type="submit" id="CancelButton" name="CancelButton" value="{'Back'|i18n('design/standard/user')}" onclick="window.setTimeout( disableButtons, 1 ); return true;" />
    </div>
  </div>
{/section}
</form>

{literal}
<script type="text/javascript">
    function disableButtons()
    {
        document.getElementById( 'PublishButton' ).disabled = true;
        document.getElementById( 'CancelButton' ).disabled = true;
    }
</script>
{/literal}
</div>
</div>
</div>