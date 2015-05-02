<?php

/**
 * Class Config
 */
class Config {
    public static $setQuery = null;
    public static $getQuery = null;

    /**
     * Get Config from Database
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        if(self::$getQuery === null) {
            self::$getQuery = DatabaseFactory::getFactory()->getConnection()->prepare("SELECT `value` FROM `settings` WHERE `key` = :key LIMIT 1");
        }
        self::$getQuery->execute(array(':key' => $key));
        $fetched = json_decode(json_encode(self::$getQuery->fetch(PDO::FETCH_ASSOC)), true);
        return $fetched['value'];
    }

    /**
     * Set a Config option in the Database
     * @param $key
     * @param $setting
     */
    public static function set($key, $setting) {
        if(self::$setQuery === null) {
            self::$setQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE settings SET `value` = :setting WHERE `key` = :key");
        }
        self::$setQuery->execute(array(':key' => $key, ':setting' => $setting));
    }
}
