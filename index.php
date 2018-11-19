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