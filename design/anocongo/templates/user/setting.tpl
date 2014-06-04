<div class="full">
<div class="col-xs-12 col-sm-9">
<form action={concat($module.functions.setting.uri,"/",$userID)|ezurl} method="post" name="Setting">

<div class="maincontentheader">
<h1>{"User setting"|i18n("design/standard/user")}</h1>
</div>

<h2>{$user.contentobject.name|wash}</h2>

<div class="block">
<label>{"Maximum login"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
<input type="text" name="max_login" size="11" value="{$userSetting.max_login}" />
</div>

<div class="block">
<input type="checkbox" name="is_enabled" {if $userSetting.is_enabled}checked{/if} >&nbsp;<label class="check">{"Is enabled"|i18n("design/standard/user")}</label><div class="labelbreak"></div>
</div>

<div class="buttonblock">
<input class="btn btn-primary" type="submit" name="UpdateSettingButton" value="{'Update'|i18n('design/standard/user')}" />
<input class="btn btn-primary" type="submit" name="CancelSettingButton" value="{'Cancel'|i18n('design/standard/user')}" />
</div>

</form>
</div></div>
