<?php

class Config {
    // this is public to allow better Unit Testing
    public static $config;

    public static function get($key) {
        if (self::$config === null) {
            self::$config = DatabaseFactory::getFactory()->getConnection()->prepare("SELECT `value` FROM `settings` WHERE `setting` = :key LIMIT 1");
        }
        self::$config->execute(array(':key' => $key));
        $fetched = json_decode(json_encode(self::$config->fetch(PDO::FETCH_ASSOC)), true);
        return $fetched['value'];
    }
}
