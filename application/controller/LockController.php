<?php

/**
 * Class Lock
 * Locks a session.
 */
class LockController extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();
    }

    /**
     * moving here makes it lock the session.
     */
    public function index() {
        LockModel::lock();
        $this->View->renderWithoutHeaderAndFooter('lock/index');
    }

    public function unlock() {
        LoginModel::login(Request::post('user_name'), Request::post('user_password'));
        LockModel::unlock();
    }
}
