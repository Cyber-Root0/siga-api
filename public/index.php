<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

require_once('../vendor/autoload.php');
require_once('../app/config/config.php');
require_once('../app/functions/functions.php');
session_start();
(new \app\core\RouterCore());
