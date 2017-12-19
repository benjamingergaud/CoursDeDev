<?php
define("WWW" , "www/");
define('DB_NAME', 'coursdedev');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
spl_autoload_register(function ($className) {
	if (substr($className, -5) == "Model")
		require_once "application/models/$className.php";
	else if(substr($className, -10) == 'Controller')
		require_once "application/controllers/$className.php";
	else
		require_once "application/classes/$className.php";
});