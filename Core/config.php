<?php

define('URL_PUBLIC_FOLDER', 'public'); // public
define('URL_PROTOCOL', '//'); // //
define('URL_DOMAIN', $_SERVER['HTTP_HOST']); // localhost
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));// Raiz do aplicativo - /appfolder
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);// /localhost/appfolder/
define('APP_TITTLE', 'Acesso Fácil');
define('DEFAULT_CONTROLLER', 'clientes');
define('DEBUG', true);

define('DB_TYPE', 'mysql'); // mysql or pgsql
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc');
define('DB_USER', 'root');
define('DB_PASS', '1507');
define('DB_PORT', '3306');// 3306 or 5432
define('DB_CHARSET', 'utf8mb4');

define('API_VHSYS_URL', 'https://api.vhsys.com/');
define('API_VHSYS_VERSION', 'v2/');
define('API_VHSYS_TOKEN', ''); /* coloque suas credencias */
define('API_VHSYS_ACCESS', '');  /* coloque suas credencias */

if(DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
  error_reporting(0);
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);
  ini_set('error_log', ROOT . DS .'tmp' . DS . 'logs' . DS . 'errors.log');
}


