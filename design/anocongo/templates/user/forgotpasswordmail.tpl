<div class="full">
<div class="col-xs-12 col-sm-9">
{let site_url=ezini("SiteSettings","SiteURL")}
{set-block scope=root variable=subject}{"%siteurl new password"|i18n("design/standard/user/forgotpassword",,hash('%siteurl',$site_url))}{/set-block}
{"Your account information"|i18n('design/standard/user/forgotpassword')}
{"Email"|i18n('design/standard/user/forgotpassword')}: {$user.email}

{if $link}
{"Click here to get new password"|i18n('design/standard/user/forgotpassword')}:
{concat("user/forgotpassword/", $hash_key, '/')|ezurl(no,'full')}
{else}


{if $password}
{"New password"|i18n('design/standard/user/forgotpassword')}: {$password}
{/if}

{/if}

{/let}
</div>
</div>
