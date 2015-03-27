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
    </head>
    <body>
    <header>
        <nav>
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo"><?php echo Config::get('SITE_NAME'); ?></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                <?php if(Session::get('user_logged_in')) { ?>
                <ul class="right hide-on-med-and-down">
                    <li><a href="sass.html">Sass</a></li>
                    <li><a href="components.html">Components</a></li>
                    <li><a href="javascript.html">Javascript</a></li>
                    <li><a href="mobile.html">Mobile</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="sass.html">Sass</a></li>
                    <li><a href="components.html">Components</a></li>
                    <li><a href="javascript.html">Javascript</a></li>
                    <li><a href="mobile.html">Mobile</a></li>
                </ul>
                <?php } else { ?>
                <ul class="right hide-on-med-and-down">
                    <li><a href="login">Login</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li class="logo">
                        <a href="!#"><?php echo Config::get('SITE_NAME'); ?></a>
                    </li>
                    <li><a href="login">Login</a></li>
                </ul>
                <?php } ?>
            </div>
        </nav>
    </header>