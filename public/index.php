<?php
require_once('../vendor/autoload.php');
require_once('../app/config/config.php');
require_once('../app/functions/functions.php');
session_start();
(new \app\core\RouterCore());
