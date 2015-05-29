<?php

/**
 * A super-simple user-authentication solution, embedded into a small framework.
 *
 * HUGE
 *
 * @link https://github.com/panique/huge
 * @license http://opensource.org/licenses/MIT MIT License
 */

// auto-loading the classes (currently only from application/libs) via Composer's PSR-4 auto-loader
// later it might be useful to use a namespace here, but for now let's keep it as simple as possible
if(!file_exists('../vendor/autoload.php')) {
    echo 'It seems that you forgot to run composer update!';
} else {
    require '../vendor/autoload.php';
    require '../application/config/config.'.Environment::get().'.php';
}

use Tracy\Debugger;

Debugger::enable();

header('Expires: '.gmdate('D, d M Y H:i:s', time() + 30).'GMT');
// start our application\
new Application();
