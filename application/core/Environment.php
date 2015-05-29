<?php

/**
 * Class Environment
 *
 * Extremely simple way to get the environment, everywhere inside your application.
 * Extend this the way you want.
 */
class Environment {
    /**
     * Get Environment based on Apache configs
     * @return string
     */
    public static function getApache() {
        return (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : "development");
    }

    /**
     * Gets Environment based on users IP address.
     * @return string
     */
    public static function get() {
        if($_SERVER['REMOTE_ADDR'] == "::1" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
            return "development";
        } elseif($_SERVER['HTTP_X_FORWARDED_FOR'] == "::1" || $_SERVER['HTTP_X_FORWARDED_FOR'] == "127.0.0.1") {
            return "development";
        } else {
            return "production";
        }
    }
}
