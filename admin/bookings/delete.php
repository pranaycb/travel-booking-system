<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

/**
 * Get booking id from url
 */
$bookingId = intval($_GET['booking']);

$result = null;

/**
 * If booking id is empty then redirect the user to the booking page
 */
if (empty($bookingId)) {

    echo header('location: index.php');
}

$query = mysqli_query($conn, "DELETE FROM `bookings` WHERE `id`  = '$bookingId'");

/**
 * After successfully delete redirect to user page
 */
header('location: index.php');
