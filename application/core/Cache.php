<?php

/**
 * Class Cache
 * Using PHPFastCache to cache data
 */
class Cache {
    /**
     * Add value to Cache if does not already exist
     * @param $key
     * @param $value
     * @param int $minutes
     * @return bool
     */
    public static function add($key, $value, $minutes = 1) {
        if(self::has($key)) {
            return false;
        } else {
            self::put($key, $value, $minutes);
            return true;
        }
    }

    /**
     * Check if value is in Cache
     * @param $key
     * @return mixed
     */
    public static function has($key) {
        $cache = phpFastCache();
        return $cache->isExisting($key);
    }

    /**
     * put a data in to cache with a key, and time in minuets
     * @param $key
     * @param $value
     * @param int $minuets
     * @return mixed
     */
    public static function put($key, $value, $minuets = 1) {
        $cache = phpFastCache();
        return $cache->set($key, $value, $minuets * 60);
    }

    /**
     * Add a Key to the cache forever(25years)
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function forever($key, $value) {
        return self::put($key, $value, 1 * 60 * 60 * 24 * 365 * 25);
    }

    /**
     * Get a value from cache and then remove from cache.
     * @param $key
     * @return bool
     */
    public static function pull($key) {
        $value = self::get($key);
        self::forget($key);
        return $value;
    }

    /**
     * get value out of cache, ability to specify default if key is not in the cache
     * @param $key
     * @param bool $default
     * @return bool
     */
    public static function get($key, $default = false) {
        $cache = phpFastCache();
        if($default !== false && self::has($key) === false) {
            return $default;
        } else {
            return $cache->get("$key");
        }
    }

    /**
     * remove key from cache
     * @param $key
     */
    public static function forget($key) {
        $cache = phpFastCache();
        $cache->delete($key);
    }

    /**
     * get information on key, such as time left in cache.
     * @param $key
     * @return mixed
     */
    public static function cacheInfo($key) {
        $cache = phpFastCache();
        return $cache->getInfo($key);
    }

    /**
     * remove everything from the cache
     */
    public static function clearCache() {
        $cache = phpFastCache();
        $cache->clean();
    }
}
