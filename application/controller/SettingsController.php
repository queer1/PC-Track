<?php

/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 4/28/2015
 * Time: 18:33
 */
class SettingsController extends Controller {
    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index() {
        $this->View->render('settings/index');
    }

    public function set() {
        SettingsModel::saveSettings(Request::post('settings'));
    }
}