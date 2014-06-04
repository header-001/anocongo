<div class="full">
<div class="col-xs-12 col-sm-9">
<form action={"/user/register/"|ezurl} method="post" name="RetryRegister">

<div class="maincontentheader">
<h1>{"Register user"|i18n("design/standard/user")}</h1>
</div>

    <div class="alert alert-dismissable alert-danger">
        <h2><!-- span class="time">[{currentdate()|l10n( shortdatetime )}]</span --> {"Your browser does not seem to support cookies, to register a new user, cookies need to be supported and enabled!"|i18n('design/standard/user')}</h2>
    </div>


    <div class="buttonblock">
        <input class="btn btn-primary" type="submit" name="RetryButton" value="{'Try again'|i18n('design/standard/user')}" />
    </div>
</form>
</div>
</div>