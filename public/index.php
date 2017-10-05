<?php 
// display errors set to false in production
if (!ini_get('display_errors')) {
    ini_set('display_errors', true);
}

session_start();

require_once '../app/init.php';

$app = new App;
