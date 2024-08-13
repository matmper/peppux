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
require_once SYSTEMPATH . 'helpers/Autoload/DateHelper.php';
require_once SYSTEMPATH . 'helpers/Autoload/EnvHelper.php';
require_once SYSTEMPATH . 'helpers/Autoload/RequestHelper.php';
require_once SYSTEMPATH . 'helpers/Autoload/ResponseHelper.php';
require_once SYSTEMPATH . 'helpers/Autoload/UrlHelper.php';
require_once SYSTEMPATH . 'helpers/Autoload/PathHelper.php';

/*
|--------------------------------------------------------------------------
| Load Config support libraries
|--------------------------------------------------------------------------
*/
new \System\Bootstrap\Support\Loader();
