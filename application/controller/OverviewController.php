<?php

/**
 * Class Overview
 * This controller is going to show 1 big page
 */
class OverviewController extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();
    }

    /**
     * Show the main overview page
     */
    public function index() {
        $this->View->render('overview/index');
    }
}
