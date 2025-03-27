<?php

include_once '../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'user') {

    header('location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head starts -->
    <?php include_once './inc/head.php'; ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once './inc/header.php'; ?>
    <!-- header section ends -->

    <section class="services">
        <h1 class="heading-title">Dashboard</h1>

        <!-- menu section starts -->
        <?php include_once "./inc/menu.php"; ?>
        <!-- menu section ends -->

    </section>



    <!-- footer section starts -->
    <?php include_once './inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once './inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>