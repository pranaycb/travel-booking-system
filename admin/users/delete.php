<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

/**
 * Get user id from url
 */
$userId = intval($_GET['user']);

$result = null;

/**
 * If user id is empty or user id is equals to admin id
 * then redirect the user to the user page
 */
if (empty($userId) && ($userId == 1)) {

    echo header('location: index.php');
}

$query = mysqli_query($conn, "DELETE FROM `users` WHERE `id`  = '$userId'");

/**
 * After successfully delete redirect to user page
 */
header('location: index.php');
