<div class="full">
	
<div class="col-xs-12 col-sm-9">	
<div class="well bs-component">
<form method="post" action={"/user/login/"|ezurl} class="form-horizontal" >

<div class="maincontentheader">
<h1>{"Login"|i18n("design/standard/user")}</h1>
</div>

{if $User:warning.bad_login}


<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">×</button>
<strong>{"Could not login"|i18n("design/standard/user")}</strong>
{"A valid username and password is required to login."|i18n("design/standard/user")}
</div>

{else}

{if $site_access.allowed|not}

<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert">×</button>
{"You are not allowed to access %1."|i18n("design/standard/user",,array($site_access.name))}

</div>
{/if}

{/if}

<div class="form-group">
<label for="inputEmail3" class="col-sm-2 control-label">{"Username"|i18n("design/standard/user",'User name')}</label>
<div class="col-sm-10">
<input  type="text" size="10" name="Login"  value="{$User:login|wash}" tabindex="1" class="form-control" id="inputEmail3" placeholder="Username" />
</div>
</div>
<div class="form-group">
<label for="inputPassword3" class="col-sm-2 control-label">{"Password"|i18n("design/standard/user")}</label>
<div class="col-sm-10">
<input  type="password" size="10" name="Password"  value="" tabindex="1" class="form-control" id="inputPassword3" placeholder="Password" />
</div>
</div>
{if and( ezini_hasvariable( 'Session', 'RememberMeTimeout' ), ezini( 'Session', 'RememberMeTimeout' ) )}
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
        <input type="checkbox" tabindex="1" name="Cookie" id="id3" />{"Remember me"|i18n("design/admin/user/login")}
	</label>
    </div>
    </div>
    </div>
{/if}

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
<input class=" btn btn-primary" type="submit" name="LoginButton" value="{'Login'|i18n('design/standard/user','Button')}" tabindex="1" />
<input class="btn btn-primary" type="submit" name="RegisterButton" value="{'Sign Up'|i18n('design/standard/user','Button')}" tabindex="1" />
</div>
</div>

{if ezini( 'SiteSettings', 'LoginPage' )|eq( 'custom' )}
    <p><a href={'/user/forgotpassword'|ezurl}>{'Forgot your password?'|i18n( 'design/standard/user' )}</a></p>
{/if}

<input type="hidden" name="RedirectURI" value="{$User:redirect_uri|wash}" />

{section show=and( is_set( $User:post_data ), is_array( $User:post_data ) )}
  {section name=postData loop=$User:post_data }
     <input name="Last_{$postData:key|wash}" value="{$postData:item|wash}" type="hidden" /><br/>
  {/section}
{/section}
</form>
</div>
</div>
</div>
