<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Define URL
 */
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])));
/**
 * Define Controller and Views paths along with avatar paths
 */
define('PATH_CONTROLLER', realpath(dirname(__FILE__) . '/../../') . '/application/controller/');
define('PATH_VIEW', realpath(dirname(__FILE__) . '/../../') . '/application/view/');
define('PATH_AVATARS', realpath(dirname(__FILE__) . '/../../') . '/public/avatars/');
define('PATH_AVATARS_PUBLIC', 'avatars/');
/**
 * Define Controller info
 */
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');
/**
 * Define DB Information (Currently only supports MySQL)
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'pctrack');
define('DB_USER', 'pctrack');
define('DB_PASS', 'password');
define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8');