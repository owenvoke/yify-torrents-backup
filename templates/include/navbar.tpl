<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand yify-green" href="/">
                <span class="fa fa-fw fa-ticket"></span>
                <span>{$_config::APP_NAME}</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="nav navbar-nav navbar-right">
                {if $_user->__get('id') > 0}
                    <li>
                        <p class="navbar-text">
                            <span class="fa fa-fw fa-user"></span>
                            {$_user->__get('username')}
                        </p>
                    </li>
                    <li>
                        <a href="//id.pxgamer.xyz/logout">
                            <span class="fa fa-fw fa-sign-out"></span>
                            Logout
                        </a>
                    </li>
                {else}
                    <li><a href="//id.pxgamer.xyz/register">Sign Up</a></li>
                    <li><a href="//id.pxgamer.xyz/login">Log In</a></li>
                {/if}
            </ul>
        </div>
    </div>
</nav>