<?php
/**
 * Class AjaxController
 */
class AjaxController {
    public function __construct() {
        parent::__construct();
        // this entire controller should only be visible/usable by logged in users, so we put authentication-check here
        Auth::checkAuthentication();
    }
    public function index() {

    }
}