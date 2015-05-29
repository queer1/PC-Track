<?php

class LockModel {

    /**
     * lock()
     * locks users session and stores refer page in database
     */
    public static function lock() {
        $server_refer = $_SERVER['HTTP_REFERER'];

        $db = DatabaseFactory::getFactory()->fluentPDO();
        $values = array(
            'user_id' => Session::get('user_id'),
            'user_name' => Session::get('user_name'),
        );
        $query = $db->from('user_lock')->where($values);
        $query->execute();

        if(strpos($server_refer, 'lock') !== false) {
            $refer = 'dashboard';
        } else {
            $string = $server_refer;
            $search = URL;
            $refer = str_replace($string, '', $search);
        }

        $values = null;
        $values = array(
            'user_id' => Session::get('user_id'),
            'user_name' => Session::get('user_name'),
            'refer_page' => $refer,
            'session_locked' => 1
        );
        $query = $db->insertInto('user_lock', $values);
        $query->execute();
        Session::set('locked', true);
    }

    public static function unlock() {
        $db = DatabaseFactory::getFactory()->fluentPDO();
        $values = array(
            'user_id' => Session::get('user_id'),
            'user_name' => Session::get('user_name'),
        );
        $query = $db->from('user_lock')->where($values);
        $query->execute();
        $result = $query->fetch();
        Session::set('locked', false);
        // dirty manner to turn stdclass to array
        $refer = json_decode(json_encode($result), true);
        $db->deleteFrom('user_lock', Session::get('user_id'));

        // needs to be fixed. currently it can make it end up at: http://HOST.COM/inventory/http://HOST.COM/inventory/login/showProfile
        Redirect::to($refer['refer_page']);
    }

    public static function lockStatus() {
        return Session::get('locked');
    }

}