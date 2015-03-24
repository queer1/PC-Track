<?php
/**
 * Configuration example!
 * To create another configuration set just copy this file to config.production.php etc. You get the idea :)
 * If config.production.php doesn't work then please set it to config.development.php (auto detection will come soon)
 */
/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard / no errors in production.
 * It's a little bit dirty to put this here, but who cares. For development purposes it's totally okay.
 */
error_reporting(E_ALL);
ini_set("display_errors", 1); //Change to 0 in production servers!
/**
 * Set URL of site (autodetected by default)
 */
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])));
/**
 * Set Database Settings
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'donate');
define('DB_USER', 'root');
define('DB_PASS', 'Mattandmanda11');
define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8');
/**
 * Path information. Suggested not to change inless you know what your doing!
 */
define('PATH_CONTROLLER', realpath(dirname(__FILE__) . '/../../') . '/application/controller/');
define('PATH_VIEW', realpath(dirname(__FILE__) . '/../../') . '/application/view/');
define('PATH_AVATARS', realpath(dirname(__FILE__) . '/../../') . '/public/avatars/');
define('PATH_AVATARS_PUBLIC', 'avatars/');
define('PATH_PRODUCT_IMG', 'products/');
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');
/**
 * TODO Put this array into the DB
 */
return array(
    'FACEBOOK_LOGIN' => false,
    'CAPTCHA_WIDTH' => 359,
    'CAPTCHA_HEIGHT' => 100,
    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'USE_GRAVATAR' => false,
    'GRAVATAR_DEFAULT_IMAGESET' => 'mm',
    'GRAVATAR_RATING' => 'pg',
    'AVATAR_SIZE' => 44,
    'AVATAR_JPEG_QUALITY' => 85,
    'AVATAR_DEFAULT_IMAGE' => 'default.jpg',

    'EMAIL_USED_MAILER' => 'phpmailer',
    'EMAIL_USE_SMTP' => false,
    'EMAIL_SMTP_HOST' => 'yourhost',
    'EMAIL_SMTP_AUTH' => true,
    'EMAIL_SMTP_USERNAME' => 'yourusername',
    'EMAIL_SMTP_PASSWORD' => 'yourpassword',
    'EMAIL_SMTP_PORT' => 465,
    'EMAIL_SMTP_ENCRYPTION' => 'ssl',

    'EMAIL_PASSWORD_RESET_URL' => 'login/verifypasswordreset',
    'EMAIL_PASSWORD_RESET_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_PASSWORD_RESET_FROM_NAME' => 'My Project',
    'EMAIL_PASSWORD_RESET_SUBJECT' => 'Password reset for PROJECT XY',
    'EMAIL_PASSWORD_RESET_CONTENT' => 'Please click on this link to reset your password: ',
    'EMAIL_VERIFICATION_URL' => 'login/verify',
    'EMAIL_VERIFICATION_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_VERIFICATION_FROM_NAME' => 'My Project',
    'EMAIL_VERIFICATION_SUBJECT' => 'Account activation for PROJECT XY',
    'EMAIL_VERIFICATION_CONTENT' => 'Please click on this link to activate your account: ',
);
