<?php

/**
 * Database config file
 */

session_start();
error_reporting(-1);

/**
 * Database credrntials as global constant
 */
define('BASE_URL', 'http://localhost/tms/'); //site base url
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tms');

/**
 * Create conn as global variable because we'll use this in other files
 */
$GLOBALS['conn'] = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/**
 * Check connection
 * If found error then stop execution
 */
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
