<div class="full">
<div class="col-xs-12 col-sm-9">
<form action={concat($module.functions.password.uri,"/",$userID)|ezurl} method="post" name="Password">

<div class="maincontentheader">
<h1>{"Change password for user"|i18n("design/standard/user")} {$userAccount.login}</h1>
</div>

{if $message}
{if or($oldPasswordNotValid,$newPasswordNotMatch,$newPasswordTooShort)}
    {if $oldPasswordNotValid}
        <div class="alert alert-dismissable alert-info">
            <h2>{'Please retype your old password.'|i18n('design/standard/user')}</h2>
        </div>
    {/if}
    {if $newPasswordNotMatch}
        <div class="alert alert-dismissable alert-info">
            <h2>{"Password did not match. Please retype your new password."|i18n('design/standard/user')}</h2>
        </div>
    {/if}
    {if $newPasswordTooShort}
        <div class="alert alert-dismissable alert-info">
            <h2>{"The new password must be at least %1 characters long. Please retype your new password."|i18n( 'design/standard/user','',array( ezini('UserSettings','MinPasswordLength') ) )}</h2>
        </div>
    {/if}

{else}
    <div class="alert alert-dismissable alert-success">
        <h2>{'Password successfully updated.'|i18n('design/standard/user')}</h2>
    </div>
{/if}

{/if}

<div class="block">
{if $oldPasswordNotValid}*{/if}
<label>{"Old password"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
<input class="halfbox" type="password" name="oldPassword" size="11" value="{$oldPassword|wash}" />
</div>

<div class="block">
<div class="element">
{if $newPasswordNotMatch}*{/if}
<label>{"New password"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
<input class="halfbox" type="password" name="newPassword" size="11" value="{$newPassword|wash}" />
</div>
<div class="element">
{if $newPasswordNotMatch}*{/if}
<label>{"Retype password"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
<input class="halfbox" type="password" name="confirmPassword" size="11" value="{$confirmPassword|wash}" />
</div>
<div class="break"></div>
</div>

<div class="buttonblock">
<input class="btn btn-primary" type="submit" name="OKButton" value="{'OK'|i18n('design/standard/user')}" />
<input class="btn btn-primary" type="submit" name="CancelButton" value="{'Cancel'|i18n('design/standard/user')}" />
</div>

</form>
</div>
</div>