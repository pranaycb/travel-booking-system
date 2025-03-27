<?php

include_once "configs/database.php";

/**
 * Get package id from url
 */
$packageId = intval($_GET['package']);

$result = null;

/**
 * If package id is empty then redirect the user to the package page
 */
if (empty($packageId)) {

    echo header('location: package.php');
}

/**
 * Handle booking form submission
 */
if (isset($_POST['submit'])) {

    $userId = $_SESSION['user_id'];
    $guests = (int) $_POST['guests'];
    $arrivals = date("Y-m-d", strtotime($_POST['arrivals']));
    $leaving = date("Y-m-d", strtotime($_POST['leaving']));

    /**
     * Validate guest number
     */
    $package = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `packages` WHERE `id` = '$packageId'"));

    if ($guests < $package['min_guest']) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Minimum guest number for your selected package is ' . $package['min_guest'] . '</h2>';

    } else if ($guests > $package['max_guest']) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Maximum guest number for your selected package is ' . $package['max_guest'] . '</h2>';
    } else {

        $result = mysqli_query($conn, "INSERT INTO `bookings` (`package_id`, `user_id`, `guests`, `arrivals`, `leaving`) VALUES ('$packageId', '$userId', '$guests', '$arrivals', '$leaving')");

        if ($result) {

            header('location: user/bookings.php');
        } else {

            $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again!</h2>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head starts -->
    <?php include_once 'inc/head.php'; ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once 'inc/header.php'; ?>
    <!-- header section ends -->

    <div class="heading" style="background:url(images/header-bg-3.jpeg) no-repeat">
        <h1>book now</h1>
    </div>

    <!-- booking section starts -->

    <section class="booking">
        <h1 class="heading-title">book your trip!</h1>

        <?php

        /**
         * Only authenticated users can book a trip
         */
        if (isset($_SESSION['is_authenticated']) && $_SESSION['authenticated_as'] == 'user') { ?>

            <form action="book.php?package=<?php echo $packageId; ?>" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>how many :</span>
                        <input type="number" placeholder="number of guests" name="guests" required>
                    </div>
                    <div class="inputBox">
                        <span>arrivals :</span>
                        <input type="date" name="arrivals" required>
                    </div>
                    <div class="inputBox">
                        <span>leaving :</span>
                        <input type="date" name="leaving" required>
                    </div>
                </div>
                <input type="submit" value="submit" class="btn" name="submit">
            </form>

        <?php } else { ?>

            <h2 style="color: red; text-align: center;">
                Opps! You need to be logged in to book a trip. Log In or Register an account to continue
            </h2>

        <?php } ?>
    </section>
    <!-- booking section ends -->


    <!-- footer section starts -->
    <?php include_once 'inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once 'inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>