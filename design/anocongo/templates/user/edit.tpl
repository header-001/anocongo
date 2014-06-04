<div class="full">
<div class="col-xs-12 col-sm-9">
<form action={concat($module.functions.edit.uri,"/",$userID)|ezurl} method="post" name="Edit">

<div class="maincontentheader">
  <h1>{"User profile"|i18n("design/standard/user")}</h1>
</div>

<div class="block">
  <label>{"Username"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.login|wash}</p>
</div>

<div class="block">
  <label>{"Email"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.email|wash(email)}</p>
</div>

<div class="block">
  <label>{"Name"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.contentobject.name|wash}</p>
</div>

<div class="buttonblock">
<input class="text" type="hidden" name="ContentObjectLanguageCode" value="{$userAccount.contentobject.initial_language_code}" />
<input class="button" type="submit" name="EditButton" value="{'Edit profile'|i18n('design/standard/user')}" />
<input class="button" type="submit" name="ChangePasswordButton" value="{'Change password'|i18n('design/standard/user')}" />
<input class="button" type="submit" name="ChangeSettingButton" value="{'Change setting'|i18n('design/standard/user')}" />
</div>

</form>
</div>
</div>
