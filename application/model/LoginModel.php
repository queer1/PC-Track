<?php

/**
 * LoginModel
 *
 * The login part of the model: Handles the login / logout stuff
 */
class LoginModel {
    public static $addFailedLoginQuery = null;
    public static $resetFailedLoginQuery = null;
    public static $saveTimeOfLoginQuery = null;
    public static $setRememberMeTokenQuery = null;

    /**
     * Login process (for DEFAULT user accounts).
     *
     * @param $user_name string The user's name
     * @param $user_password string The user's password
     * @param $set_remember_me_cookie mixed Marker for usage of remember-me cookie feature
     *
     * @return bool success state
     */
    public static function login($user_name, $user_password, $set_remember_me_cookie = null) {
        // we do negative-first checks here, for simplicity empty username and empty password in one line
        if(empty($user_name) or empty($user_password)) {
            Session::add('feedback_negative', Language::getText('login-empty-field'));
            return false;
        }

        // checks if user exists, if login is not blocked (due to failed logins) and if password fits the hash
        $result = self::validateAndGetUser($user_name, $user_password);

        if(!$result) {
            return false;
        }

        // reset the failed login counter for that user (if necessary)
        if($result->user_last_failed_login > 0) {
            self::resetFailedLoginCounterOfUser($result->user_name);
        }

        // save timestamp of this login in the database line of that user
        self::saveTimestampOfLoginOfUser($result->user_name);

        // if user has checked the "remember me" checkbox, then write token into database and into cookie
        if($set_remember_me_cookie) {
            self::setRememberMeInDatabaseAndCookie($result->user_id);
        }

        // successfully logged in, so we write all necessary data into the session and set "user_logged_in" to true
        self::setSuccessfulLoginIntoSession($result->user_id, $result->user_name, $result->user_email, $result->user_account_type);

        if(Config::get('CASTLE_ENABLED')) {
            Castle::setApiKey(Config::get('CASTLE_SECRET'));
            Castle::track(array(
                    'name' => '$login.succeeded',
                    'user_id' => $result->user_id
                )
            );
        }
        // return true to make clear the login was successful
        // maybe do this in dependence of setSuccessfulLoginIntoSession ?
        return true;
    }

    /**
     * Validates the inputs of the users, checks if password is correct etc.
     * If successful, user is returned
     *
     * @param $user_name
     * @param $user_password
     *
     * @return bool|mixed
     */
    private static function validateAndGetUser($user_name, $user_password) {
        // get all data of that user (to later check if password and password_hash fit)
        $result = UserModel::getUserDataByUsername($user_name);

        // Check if that user exists. We don't give back a cause in the feedback to avoid giving an attacker details.
        if(!$result) {
            Session::add('feedback_negative', Language::getText('login-failed'));
            return false;
        }

        // block login attempt if somebody has already failed 3 times and the last login attempt is less than 30sec ago
        if(($result->user_failed_logins >= 3) && ($result->user_last_failed_login > (time() - 30))) {
            Session::add('feedback_negative', Language::getText('login-wrong-3'));
            return false;
        }

        // if hash of provided password does NOT match the hash in the database: +1 failed-login counter
        if(!password_verify($user_password, $result->user_password_hash)) {
            self::incrementFailedLoginCounterOfUser($result->user_name);
            Session::add('feedback_negative', Language::getText('login-failed'));
            if(Config::get('CASTLE_ENABLED')) {
                Castle::setApiKey(Config::get('CASTLE_SECRET'));
                Castle::track(array(
                    'name' => '$login.failed',
                    'details' => array(
                        '$login' => $result->user_email,
                        '$reason' => 'Password Incorrect'
                    )
                ));
            }
            return false;
        }

        // if user is not active (= has not verified account by verification mail)
        if($result->user_active != 1) {
            Session::add('feedback_negative', Language::getText('login-verification'));
            if(Config::get('CASTLE_ENABLED')) {
                Castle::setApiKey(Config::get('CASTLE_SECRET'));
                Castle::track(array(
                    'name' => '$login.failed',
                    'details' => array(
                        '$login' => $result->user_email,
                        '$reason' => 'Account not Activated'
                    )
                ));
            }
            return false;
        }
        if(Config::get('CASTLE_ENABLED')) {
            Castle::setApiKey(Config::get('CASTLE_SECRET'));
            Castle::login(
                $result->user_id,
                array(
                    'username' => $result->user_name,
                    'email' => $result->user_email
                )
            );
        }
        return $result;
    }

    /**
     * Increments the failed-login counter of a user
     *
     * @param $user_name
     */
    public static function incrementFailedLoginCounterOfUser($user_name) {
        if(self::$addFailedLoginQuery === null) {
            self::$addFailedLoginQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users
                   SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login
                 WHERE user_name = :user_name OR user_email = :user_name
                 LIMIT 1");
        }
        self::$addFailedLoginQuery->execute(array(':user_name' => $user_name, ':user_last_failed_login' => time()));
    }

    /**
     * Resets the failed-login counter of a user back to 0
     *
     * @param $user_name
     */
    public static function resetFailedLoginCounterOfUser($user_name) {
        if(self::$resetFailedLoginQuery === null) {
            self::$resetFailedLoginQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users
                   SET user_failed_logins = 0, user_last_failed_login = NULL
                 WHERE user_name = :user_name AND user_failed_logins != 0
                 LIMIT 1");
        }
        self::$resetFailedLoginQuery->execute(array(':user_name' => $user_name));
    }

    /**
     * Write timestamp of this login into database (we only write a "real" login via login form into the database,
     * not the session-login on every page request
     *
     * @param $user_name
     */
    public static function saveTimestampOfLoginOfUser($user_name) {
        if(self::$saveTimeOfLoginQuery === null) {
            self::$saveTimeOfLoginQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users SET user_last_login_timestamp = :user_last_login_timestamp
                WHERE user_name = :user_name LIMIT 1");
        }
        self::$saveTimeOfLoginQuery->execute(array(':user_name' => $user_name, ':user_last_login_timestamp' => time()));
    }

    /**
     * Write remember-me token into database and into cookie
     * Maybe splitting this into database and cookie part ?
     *
     * @param $user_id
     */
    public static function setRememberMeInDatabaseAndCookie($user_id) {
        if(self::$setRememberMeTokenQuery === null) {
            self::$setRememberMeTokenQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users SET user_remember_me_token = :user_remember_me_token WHERE user_id = :user_id LIMIT 1");
        }

        // generate 64 char random string
        $random_token_string = hash('sha256', mt_rand());

        // write that token into database
        self::$setRememberMeTokenQuery->execute(array(':user_remember_me_token' => $random_token_string, ':user_id' => $user_id));

        // generate cookie string that consists of user id, random string and combined hash of both
        $cookie_string_first_part = $user_id.':'.$random_token_string;
        $cookie_string_hash = hash('sha256', $cookie_string_first_part);
        $cookie_string = $cookie_string_first_part.':'.$cookie_string_hash;

        // set cookie
        setcookie('remember_me', $cookie_string, time() + Config::get('COOKIE_RUNTIME'), Config::get('COOKIE_PATH'));
    }

    /**
     * The real login process: The user's data is written into the session.
     * Cheesy name, maybe rename. Also maybe refactoring this, using an array.
     *
     * @param $user_id
     * @param $user_name
     * @param $user_email
     * @param $user_account_type
     */
    public static function setSuccessfulLoginIntoSession($user_id, $user_name, $user_email, $user_account_type) {
        Session::init();
        Session::set('user_id', $user_id);
        Session::set('user_name', $user_name);
        Session::set('user_email', $user_email);
        Session::set('user_account_type', $user_account_type);
        Session::set('user_provider_type', 'DEFAULT');

        // get and set avatars
        Session::set('user_avatar_file', AvatarModel::getPublicUserAvatarFilePathByUserId($user_id));
        Session::set('user_gravatar_image_url', AvatarModel::getGravatarLinkByEmail($user_email));

        // finally, set user as logged-in
        Session::set('user_logged_in', true);
        Session::set('locked', 0);
    }

    /**
     * performs the login via cookie (for DEFAULT user account, FACEBOOK-accounts are handled differently)
     * TODO add throttling here ?
     *
     * @param $cookie string The cookie "remember_me"
     *
     * @return bool success state
     */
    public static function loginWithCookie($cookie) {
        if(!$cookie) {
            Session::add('feedback_negative', Language::getText('login-cookie-invalid'));
            return false;
        }

        // check cookie's contents, check if cookie contents belong together or token is empty
        list ($user_id, $token, $hash) = explode(':', $cookie);
        if($hash !== hash('sha256', $user_id.':'.$token) or empty($token)) {
            Session::add('feedback_negative', Language::getText('login-cookie-invalid'));
            return false;
        }

        // get data of user that has this id and this token
        $result = UserModel::getUserDataByUserIdAndToken($user_id, $token);
        if($result) {
            // successfully logged in, so we write all necessary data into the session and set "user_logged_in" to true
            self::setSuccessfulLoginIntoSession($result->user_id, $result->user_name, $result->user_email, $result->user_account_type);
            // save timestamp of this login in the database line of that user
            self::saveTimestampOfLoginOfUser($result->user_name);

            Session::add('feedback_positive', Language::getText('login-cookie-success'));
            return true;
        } else {
            Session::add('feedback_negative', Language::getText('login-cookie-invalid'));
            return false;
        }
    }

    /**
     * Log out process: delete cookie, delete session
     */
    public static function logout() {
        if(Config::get('CASTLE_ENABLED')) {
            Castle::setApiKey(Config::get('CASTLE_SECRET'));
            Castle::logout();
            Castle::track(array(
                'name' => '$logout.succeeded',
                'user_id' => Session::get('user_id')
            ));
        }
        self::deleteCookie();
        Session::destroy();
    }

    /**
     * Deletes the cookie
     * It's necessary to split deleteCookie() and logout() as cookies are deleted without logging out too!
     * Sets the remember-me-cookie to ten years ago (3600sec * 24 hours * 365 days * 10).
     * that's obviously the best practice to kill a cookie @see http://stackoverflow.com/a/686166/1114320
     */
    public static function deleteCookie() {
        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'));
    }

    /**
     * Returns the current state of the user's login
     *
     * @return bool user's login status
     */
    public static function isUserLoggedIn() {
        return Session::userIsLoggedIn();
    }

}
