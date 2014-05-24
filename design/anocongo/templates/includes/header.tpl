<header id="header">
	<div class="container">
	    <a href={$front_page.url_alias|ezurl} class="logo">
	    	<img src={'images/logo.png'|ezdesign} alt="logo" id="logo" />
	    </a>
	    <div class="nav navbar-right top-nav">
		    <ul>
		    	<li><a href="#">Lieux</a></li>
		    	<li><a href="#">Blogs</a></li>
			    {if $current_user.is_logged_in}
				    <li id="myprofile"><a href={"/user/edit/"|ezurl} title="{'My profile'|i18n('design/ezdemo/pagelayout')}">{'My profile'|i18n('design/ezdemo/pagelayout')}</a></li>
				    <li id="logout"><a href={"/user/logout"|ezurl} title="{'Logout'|i18n('design/ezdemo/pagelayout')}">{'Logout'|i18n('design/ezdemo/pagelayout')} ( {$current_user.contentobject.name|wash} )</a></li>
				{else}
				    <li id="login" class="transition-showed">
				        <a href="#login" title="show login form" class="show-login-form">{'Login'|i18n('design/ezdemo/pagelayout')}</a>
				       	<a href="#" title="hide login form" class="hide-login-form">{'Login'|i18n('design/ezdemo/pagelayout')}</a>
				        <form class="login-form span3" action="{'/user/login'|ezurl( 'no' )}" method="post">
				            <fieldset>
				                <label>
				                    <span>{'Username'|i18n('design/ezdemo/pagelayout')}</span>
				                    <input type="text" name="Login" id="login-username" placeholder="Username">
				                </label>
				                <label>
				                    <span>{'Password'|i18n('design/ezdemo/pagelayout')}</span>
				                    <input type="password" name="Password" id="login-password" placeholder="Password">
				                </label>
				                <div class="clearfix">
				                    <a href="{'/user/forgotpassword'|ezurl( 'no' )}" class="forgot-password">{'Forgot your password?'|i18n('design/ezdemo/pagelayout')}</a>
				                    <button class="btn btn-warning pull-right" type="submit">
				                        {'Login'|i18n('design/ezdemo/pagelayout')}
				                    </button>
				                </div>
				            </fieldset>
				            <input type="hidden" name="RedirectURI" value="" />
				        </form>
				    </li>
	        	{/if}
	        </ul>
	       <span> |</span>
			{include uri="design:includes/langswitch.tpl"}
		</div>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
        	<div class="navbar-header">
	          	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
	          	</button>
	          	<a class="navbar-brand" href={$front_page.url_alias|ezurl}>Accueil</a>
			</div>
			<div class="navbar-collapse collapse">
	    		{include uri="design:includes/menu.tpl"
						menu_css_class="nav navbar-nav"}
			</div>
	    </div>
	</nav>
</header>
<div id="tabs" class="container">
	<ul>
		<li><a href="#tabs-1">{"Association"|i18n("ano")}</a></li>
		<li><a href="#tabs-2">{"Acting civil society"|i18n("ano")}</a></li>
		<li><a href="#tabs-3">{"Reverse"|i18n("ano")}</a></li>
	</ul>
	<div id="tabs-1">
		<form class="searchbox" method="get" action={'content/search'|ezurl}>
			<div class="input-field">
				<label>{"What, Who?"|i18n("ano")}</label>
	    		<input
			    	type="search"
			    	name="SearchWho"
			    	id="{$id}"
			    	placeholder="{"ex: plombier"|i18n("ano")}"
			    	value="{$searchText|wash}"
			   	/>
			</div>
			<div class="input-field">
				<label>{"Where?"|i18n("ano")}</label>
	    		<input
			    	type="search"
			    	name="SearchWhere"
			    	id="{$id}"
			    	placeholder="{"ex: kinshasa"|i18n("ano")}"
			    	value="{$searchText|wash}"
			   	/>
			</div>
			<div class="go">
		    	<input type="submit" value="{'search'|i18n('ano')}" />
			</div>
		</form>
	</div>
	<div id="tabs-2">
		<form class="searchbox" method="get" action={'content/search'|ezurl}>
			<div class="input-field">
				<label>{"Who?"|i18n("ano")}</label>
	    		<input
			    	type="search"
			    	name="SearchWho"
			    	id="{$id}"
			    	placeholder="{"ex: plombier"|i18n("ano")}"
			    	value="{$searchText|wash}"
			   	/>
			</div>
			<div class="input-field">
				<label>{"Where?"|i18n("ano")}</label>
	    		<input
			    	type="search"
			    	name="SearchWhere"
			    	id="{$id}"
			    	placeholder="{"ex: kinshasa"|i18n("ano")}"
			    	value="{$searchText|wash}"
			   	/>
			</div>
			<div class="go">
		    	<input type="submit" value="{'search'|i18n('ano')}" />
			</div>
		</form>
	</div>
	<div id="tabs-3">
		
	</div>
</div>