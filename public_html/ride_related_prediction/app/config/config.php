<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
// OR 
// defined('BASE_PATH') 
// preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]);
// OR defined('/crudphalcon/')
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');


// use Phalcon\Config\Adapter\Ini;
// use Phalcon\Di;
// use Phalcon\Db\Adapter\Pdo\Factory;

// $di = new Di();
// $config = new Ini('config.ini');

// $di->set('config', $config);

// $di->set(
//     'db', 
//     function () {
//         return Factory::load($this->config->database);
//     }
// );

return $connection = new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'ride_fuel_prediction',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ]
]);
