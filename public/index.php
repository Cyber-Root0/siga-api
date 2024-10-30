<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once(__DIR__.'/../vendor/autoload.php');


require_once(__DIR__.'/../app/config/config.php');
require_once(__DIR__.'/../app/functions/functions.php');
session_start();
(new \app\core\RouterCore());
