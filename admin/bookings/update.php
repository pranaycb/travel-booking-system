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

/**
 * Update profile
 */
if (isset($_POST['update'])) {

    $user_id = (int) $_POST['user'];
    $package_id = (int) $_POST['package'];
    $guests = (int) $_POST['guests'];
    $arrivals = date("Y-m-d", strtotime($_POST['arrivals']));
    $leaving = date("Y-m-d", strtotime($_POST['leaving']));
    $status = $_POST['status'];

    /**
     * Validate guest number
     */
    $package = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `packages` WHERE `id` = '$package_id'"));

    if ($guests < $package['min_guest']) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Minimum guest number for selected package is ' . $package['min_guest'] . '</h2>';
    } else if ($guests > $package['max_guest']) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Maximum guest number for selected package is ' . $package['max_guest'] . '</h2>';
    } else {

        /**
         * Update booking
         */
        $updated = mysqli_query($conn, "UPDATE `bookings` SET `user_id` = '$user_id', `package_id` = '$package_id', `guests` = '$guests', `arrivals` = '$arrivals', `leaving` = '$leaving', `status` = '$status' WHERE `id` = '$bookingId'");

        if ($updated) {

            $result = '<h2 style="color: green; text-align: center; margin-bottom: 20px">Booking data has been updated successfully</h2>';
        } else {

            $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
        }
    }
}

/**
 * Show profile details
 */
$query = mysqli_query($conn, "SELECT * FROM `bookings` WHERE `id` = '$bookingId'");
$booking = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head starts -->
    <?php include_once '../inc/head.php'; ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once '../inc/header.php'; ?>
    <!-- header section ends -->

    <section class="services">
        <h1 class="heading-title">Update User</h1>

        <!-- menu section starts -->
        <?php include_once "../inc/menu.php"; ?>
        <!-- menu section ends -->

        <section class="booking">

            <form action="update.php?booking=<?php echo $bookingId; ?>" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">

                    <div class="inputBox">
                        <span>User :</span>

                        <select name="user" required>

                            <?php

                            $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `role` != 'admin'");

                            if (mysqli_num_rows($query) > 0) {

                                echo '<option value="">--Select--</option>';

                                while ($user = mysqli_fetch_assoc($query)) {

                                    $isSelected = ($user['id'] == $booking['user_id']) ? 'selected' : null;

                                    echo '<option value="' . $user['id'] . '" ' . $isSelected . '>' . $user['name'] . '</option>';
                                }
                            } else {

                                echo '<option value="">No user found</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="inputBox">
                        <span>Package :</span>

                        <select name="package" required>

                            <?php

                            $query = mysqli_query($conn, "SELECT * FROM `packages` WHERE `status` = '1'");

                            if (mysqli_num_rows($query) > 0) {

                                echo '<option value="">--Select--</option>';

                                while ($package = mysqli_fetch_assoc($query)) {

                                    $isSelected = ($package['id'] == $booking['package_id']) ? 'selected' : null;

                                    echo '<option value="' . $package['id'] . '" ' . $isSelected . '>' . $package['package_name'] . '</option>';
                                }
                            } else {

                                echo '<option value="">No package found</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="inputBox">
                        <span>how many :</span>
                        <input type="number" placeholder="number of guests" name="guests" value="<?php echo $booking['guests']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>arrivals :</span>
                        <input type="date" name="arrivals" value="<?php echo $booking['arrivals']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>leaving :</span>
                        <input type="date" name="leaving" value="<?php echo $booking['leaving']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Status :</span>

                        <select type="number" name="status" required>

                            <option value="">--Select--</option>

                            <option value="confirmed" <?php if ($booking['status'] == 'confirmed') echo 'selected'; ?>>Confirmed</option>

                            <option value="pending" <?php if ($booking['status'] == 'pending') echo 'selected'; ?>>Pending</option>

                            <option value="rejected" <?php if ($booking['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                    </div>
                </div>

                <input type="submit" value="submit" class="btn" name="update">

            </form>
        </section>
    </section>


    <!-- footer section starts -->
    <?php include_once '../inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once '../inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>