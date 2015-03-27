
<div class="container">
    <form action="<?php Config::get('URL'); ?>login/login" method="post">
        <div class="row">
            <div class="col s12">
                <h4>Login to <?php echo Config::get('SITE_NAME'); ?></h4>
                <div class="row">
                    <div class="input-field col s6">
                        <input id="email" type="email" name="user_name" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input pattern=".{6,}" id="password" type="password" name="user_password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <input id="rememberme" type="checkbox" name="set_remember_me_cookie">
                        <label for="rememberme">Remember Me</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <button type="submit" class="btn waves-effect waves-light">Log In</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>