<?php

/*
|--------------------------------------------------------------------------
| Register system folders
|--------------------------------------------------------------------------
*/
// phpcs:disable
define('FCPATH', __DIR__ . '/../../');
define('APPPATH', FCPATH . 'app/');
define('DATABASEPATH', FCPATH . 'database/');
define('SYSTEMPATH', FCPATH . 'system/');
define('PUBLICPATH', FCPATH . 'public/');
define('STORAGEPATH', FCPATH . 'storage/');
// phpcs:enable

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require_once FCPATH . 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load System Helpers
|--------------------------------------------------------------------------
*/
require_once SYSTEMPATH . 'helpers/DateHelper.php';
require_once SYSTEMPATH . 'helpers/EnvHelper.php';
require_once SYSTEMPATH . 'helpers/RequestHelper.php';
require_once SYSTEMPATH . 'helpers/ResponseHelper.php';
require_once SYSTEMPATH . 'helpers/UrlHelper.php';
require_once SYSTEMPATH . 'helpers/PathHelper.php';

/*
|--------------------------------------------------------------------------
| Load System and Config Libraries
|--------------------------------------------------------------------------
*/
$loader = new \System\Bootstrap\Loader;
$loader::env_file();
$loader::config();

/*
|--------------------------------------------------------------------------
| Classes Alias
|--------------------------------------------------------------------------
*/
class_alias('System\Libraries\Request', 'Request');
class_alias('System\Libraries\Session', 'Session');
class_alias('System\Libraries\Database', 'Database');
class_alias('System\Libraries\Response', 'Response');

/*
|--------------------------------------------------------------------------
| Set default timezone
|--------------------------------------------------------------------------
*/
date_default_timezone_set(config('app.timezone', 'UTC'));
