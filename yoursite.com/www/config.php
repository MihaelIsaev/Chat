<?

ini_set('session.gc_maxlifetime', 86400);
session_start();

error_reporting(E_NONE);
ini_set('display_errors', 0);

define('SITE_PATH', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

define('AJAX_PATH', SITE_PATH.DS.'../ajax/');
define('SOCKETS_PATH', SITE_PATH.DS.'../sockets/');
define('TMPL_PATH', SITE_PATH.DS.'templates/');
define('CLASS_PATH', SITE_PATH.DS.'../classes/');

function __autoload($class_name)
{
    $class_file = CLASS_PATH.DS.$class_name.'.php';
    if (file_exists($class_file)) {
        require_once($class_file);
    }
}

header('Content-Type: text/html; charset=UTF-8');