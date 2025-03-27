<?php

include_once '../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'user') {

    header('location: ../index.php');
}

/**
 * Destroy session and redirect to homepage
 */
session_unset();
session_destroy();

header('location: ../index.php');
