<?php

/**
 * Class Config
 */
class Config {
    private static $setQuery = null;
    private static $getQuery = null;

    /**
     * Get Config from Database
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        if(!Cache::has($key)) {
            if(self::$getQuery === null) {
                self::$getQuery = DatabaseFactory::getFactory()->getConnection()->prepare("SELECT `value` FROM `settings` WHERE `key` = :key LIMIT 1");
            }
            self::$getQuery->execute(array(':key' => $key));
            $fetched = json_decode(json_encode(self::$getQuery->fetch(PDO::FETCH_ASSOC)), true);
            Cache::put($key, $fetched, 60);
            $final = Cache::get($key);
            return self::setType($final['value']);
        } else {
            $final = Cache::get($key);
            return self::setType($final['value']);
        }
    }

    /**
     * Ensures that the returned results are indeed booleans | strings | int | float
     * @param $key
     * @return bool|int|float|string
     */
    public static function setType($key) {
        if($key === 'true') {
            return true;
        } elseif($key === 'false') {
            return false;
        } elseif(is_numeric($key) === true) {
            return $key + 0;
        } else {
            return $key;
        }
    }

    /**
     * Set a Config option in the Database
     * @param $key
     * @param $setting
     */
    public static function set($key, $setting) {
        if(Cache::has($key)) {
            Cache::forget($key);
        }

        if(self::$setQuery === null) {
            self::$setQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE settings SET `value` = :setting WHERE `key` = :key");
        }
        self::$setQuery->execute(array(':key' => $key, ':setting' => $setting));
    }
}
