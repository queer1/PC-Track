<html itemscope itemtype="http://scheme.org/Article" lang="en">
    <head>
        <title><?php echo Config::get('SITE_NAME'); ?></title>
        <meta charset="UTF-8">
        <meta name="description" content="<?php echo Config::get('SITE_DESCRIPTION'); ?>">

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@<?php echo Config::get('TWITTER'); ?>">
        <meta name="twitter:title" content="<?php echo Config::get('SITE_NAME'); ?>">
        <meta name="twitter:description" content="<?php echo Config::get('SITE_DESCRIPTION'); ?>">

        <!-- CSS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
        <?php if(Config::get('CASTLE_ENABLED')) { ?>
            <script type="text/javascript">
                (function (e, t, n, r) {
                    function i(e, n) {
                        e = t.createElement("script");
                        e.async = 1;
                        e.src = r;
                        n = t.getElementsByTagName("script")[0];
                        n.parentNode.insertBefore(e, n)
                    }

                    e[n] = e[n] || function () {
                        (e[n].q = e[n].q || []).push(arguments)
                    };
                    e.attachEvent ? e.attachEvent("onload", i) : e.addEventListener("load", i, false)
                })(window, document, "_castle", "//d2t77mnxyo7adj.cloudfront.net/v1/c.js")
                _castle('setAccount', '<?php echo Config::get('CASTLE_ID'); ?>');
                <?php if(Session::get('user_logged_in')) { ?>
                _castle('setUser', {
                    id: <?php echo Session::get('user_id'); ?>, // required
                    name: '<?php echo Session::get('user_name'); ?>', // optional
                    email: '<?php echo Session::get('user_email')?>', // optional
                });
                <?php } ?>
                _castle('trackPageview');
            </script>
        <?php } ?>
    </head>
    <body>
    <header>
        <ul id="profile-dropdown" class="dropdown-content">
            <li><a href="<?php echo URL ?>profile">Profile</a></li>
            <li><a href="<?php echo URL ?>profile/settings">Settings</a></li>
            <li><a href="<?php echo URL ?>login/logout">Sign Out</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper">
                <a href="<?php echo URL ?>" class="brand-logo"><?php echo Config::get('SITE_NAME'); ?></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                <?php if(Session::get('user_logged_in')) { ?>
                <ul class="right hide-on-med-and-down">
                    <li><a href="<?php echo URL ?>dashboard">Dashboard</a></li>
                    <li><a href="<?php echo URL ?>dashboard/newpc">Add PC</a></li>
                    <li><a href="<?php echo URL ?>dashboard/checkout">Checkout</a></li>
                    <li>
                        <a href="#!" class="dropdown-button" data-activates="profile-dropdown">Welcome: <?php echo Session::get('user_name'); ?></a>
                    </li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="<?php echo URL ?>dashboard">Dashboard</a></li>
                    <li><a href="<?php echo URL ?>dashboard/newpc">Add PC</a></li>
                    <li><a href="<?php echo URL ?>dashboard/checkout">Checkout</a></li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Account<i class="mdi-navigation-arrow-drop-down"></i></a>

                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="<?php echo URL ?>profile">Profile</a></li>
                                        <li><a href="<?php echo URL ?>profile/settings">Settings</a></li>
                                        <li><a href="<?php echo URL ?>login/logout">Log Out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php } else { ?>
                <ul class="right hide-on-med-and-down">
                    <li><a href="login">Login</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="login">Login</a></li>
                </ul>
                <?php } ?>
            </div>
        </nav>
    </header>