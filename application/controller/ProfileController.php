<?php

/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 4/26/2015
 * Time: 20:43
 */
class ProfileController extends Controller {
    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index() {
        $this->View->render('profile/index');
    }

    public function settings() {
        $this->View->render('profile/settings');
    }
}