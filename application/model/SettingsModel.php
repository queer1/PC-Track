<?php

/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 4/28/2015
 * Time: 19:43
 */
class SettingsModel {
    /**
     * @param $json
     */
    public function saveSettings($json) {
        $array = json_decode($json, true);
    }
}