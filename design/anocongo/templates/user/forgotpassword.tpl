<div class="full">
<div class="col-xs-12 col-sm-9">
{if $link}
<p>
{"A mail has been sent to the following email address: %1. This email contains a link you need to click so that we can confirm that the correct user is getting the new password."|i18n('design/standard/user/forgotpassword',,array($email))}
</p>
{else}
   {if $wrong_email}
   <div class="warning">
   <h2>{"There is no registered user with that email address."|i18n('design/standard/user/forgotpassword')}</h2>
   </div>
   {/if}
   {if $generated}
   <p>
   {"Password was successfully generated and sent to: %1"|i18n('design/standard/user/forgotpassword',,array($email))}
   </p>
   {else}
      {if $wrong_key}
      <div class="warning">
      <h2>{"The key is invalid or has been used. "|i18n('design/standard/user/forgotpassword')}</h2>
      </div>
      {else}
      <form method="post" name="forgotpassword" action={"/user/forgotpassword/"|ezurl}>
      <div class="maincontentheader">
      <h1>{"Have you forgotten your password?"|i18n('design/standard/user/forgotpassword')}</h1>
      </div>

      <p>
      {"If you have forgotten your password we can generate a new one for you. All you need to do is to enter your email address and we will create a new password for you."|i18n('design/standard/user/forgotpassword')}
      </p>
    
      <div class="block">
      <label for="email">{"Email"|i18n('design/standard/user/forgotpassword')}:</label>
      <div class="labelbreak"></div>
      <input class="halfbox" type="text" name="UserEmail" size="40" value="{$wrong_email|wash}" />
      </div>

      <div class="buttonblock">
      <input class="button" type="submit" name="GenerateButton" value="{'Generate new password'|i18n('design/standard/user/forgotpassword')}" />
      </div>
      </form>
      {/if}
   {/if}
{/if}
</div>
</div>
