<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

/**
 * Get package id from url
 */
$packageId = intval($_GET['package']);

$result = null;

/**
 * If package id is empty then redirect the user to the package page
 */
if (empty($packageId)) {

    echo header('location: index.php');
}

$query = mysqli_query($conn, "DELETE FROM `packages` WHERE `id`  = '$packageId'");

/**
 * After successfully delete redirect to user page
 */
header('location: index.php');
