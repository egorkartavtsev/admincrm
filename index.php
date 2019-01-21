<<<<<<< Upstream, based on origin/master
<?php
//exit("Извините. Сайт временно недоступен. Ведутся технические работы. Спасибо за понимание.");
//Timezone
    date_default_timezone_set('Asia/Yekaterinburg');
// Version
define('VERSION', '3.0.18');
// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('admin');
=======
<<<<<<< HEAD
<?php
//exit("Извините. Сайт временно недоступен. Ведутся технические работы. Спасибо за понимание.");
//Timezone
    date_default_timezone_set('Asia/Yekaterinburg');
// Version
define('VERSION', '3.0.18');
// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

=======
<?php
//exit("Извините. Сайт временно недоступен. Ведутся технические работы. Спасибо за понимание.");
//Timezone
    date_default_timezone_set('Asia/Yekaterinburg');
// Version
define('VERSION', '3.0.18');
// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

>>>>>>> origin/master
start('admin');
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
