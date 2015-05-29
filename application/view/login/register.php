<div class="container">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages();

    $register_allow = true;

    if($register_allow) {
    ?>

    <!-- login box on left side -->
    <div class="login-box" style="width: 100%; display: block;">
        <h2>Register a new account</h2>

        <!-- register form -->
        <form method="post" action="<?php echo URL; ?>login/register_action">
            <!-- the user name input field uses a HTML5 pattern check -->
            <br>

            <p>username:</p>
            <br><input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name"
                       placeholder="Username (letters/numbers, 2-64 chars)" required/>
            <br>

            <p>email:</p>
            <br><input type="text" name="user_email" placeholder="email address (a real address)" required/>
            <br>

            <p>wachtwoord:</p>
            <br><input type="password" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)"
                       required autocomplete="off"/>
            <br>

            <p>Wachtwoord: (nogmaals)</p>
            <br><input type="password" name="user_password_repeat" pattern=".{6,}" required
                       placeholder="Repeat your password" autocomplete="off"/>

            <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
            <br>

            <p>capthca:</p>
            <?php if (Config::get('RECAPTCHA_ENABLED')) { ?>
                <div class="g-recaptcha" data-sitekey="<?php echo Config::get('RECAPTCHA_SITEKEY'); ?>"></div>
                <script src="https://www.google.com/recaptcha/api.js"></script>
            <?php } else { ?>
            <br><img id="captcha" src="<?php echo URL; ?>login/showCaptcha"/>
            <br><input type="text" name="captcha" placeholder="Please enter above characters" required/>

            <!-- quick & dirty captcha reloader -->
            <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
               onclick="document.getElementById('captcha').src = '<?php echo URL; ?>login/showCaptcha?' + Math.random(); return false">Reload
                Captcha</a>
            <?php } ?>

            <input type="submit" value="Register"/>
        </form>
    </div>
</div>
<?php } else { ?>
    <div>
        <h2>Registering is disabled!</h2>
    </div>

<?php } ?>