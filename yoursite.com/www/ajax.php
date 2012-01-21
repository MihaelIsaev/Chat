<?

defined('DEBUG', 0);

require_once 'config.php';

$MODULE = "";	// Папка с названием модуля: Organization, Ware, ...
$ACTION = "";	// Действие в модуле: list, edit, create, delete, ...

$SCRIPT_PATH = "";

// Переменная MODULE не обязательна.
// Если нужно обратиться к одиночному действию, которое лежим в корне /modules
// то нужно просто передать ACTION

// Если действие не задано, выходим
if (!isset($_POST['action']) || !strlen(trim($_POST['action']))) {
	exit();
}

$ACTION = trim($_POST['action']);

$SCRIPT_PATH = $ACTION.'.php';

// Проверяем, указано ли название модуля
if (isset($_POST['module']) && strlen(trim($_POST['module']))) {
	$MODULE = trim($_POST['module']);
	$SCRIPT_PATH = $MODULE.'/'.$SCRIPT_PATH;
}

// Если скрипт не найден, выходим
if (!file_exists(AJAX_PATH.$SCRIPT_PATH))
	exit();

// Подключаем скрипт, в котором вся бизнес-логика
require_once AJAX_PATH.$SCRIPT_PATH;


// Если к данному действию есть шаблон, подключаем шаблон
if (file_exists(TMPL_PATH.$SCRIPT_PATH))
	require_once TMPL_PATH.$SCRIPT_PATH;

exit();