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
 * Update profile
 */
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    /**
     * Validate email is already used or not
     */
    $usedEmail = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` != '$userId' AND `email` = '$email'"));

    /**
     * Validate phone is already used or not
     */
    $usedPhone = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` != '$userId' AND `phone` = '$phone'"));

    if ($usedEmail > 0) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Email id already exists!</h2>';
    } else if ($usedPhone > 0) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Mobile number is already exists!</h2>';
    } else {

        /**
         * All is well :)
         * Update user's profile data
         */
        $updated = mysqli_query($conn, "UPDATE `users` SET `name` = '$name', `phone` = '$phone', `email` = '$email', `address` = '$address', `status` = '$status' WHERE `id` = '$userId'");

        if ($updated) {

            $result = '<h2 style="color: green; text-align: center; margin-bottom: 20px">User data has been updated successfully</h2>';
        } else {

            $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
        }
    }
}

/**
 * Show profile details
 */
$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$userId'");
$user = mysqli_fetch_assoc($query);

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

            <form action="update.php?user=<?php echo $userId; ?>" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>Name :</span>
                        <input type="text" placeholder="Enter your name" name="name" value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Phone Number :</span>
                        <input type="number" placeholder="Enter your phone number" name="phone" value="<?php echo $user['phone']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Email Id :</span>
                        <input type="email" placeholder="Enter your email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Address :</span>
                        <input type="text" placeholder="Enter your address" name="address" value="<?php echo $user['address']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Account Status :</span>

                        <select type="number" name="status" required>

                            <option value="">--Select--</option>

                            <option value="active" <?php if ($user['status'] == 'active') echo 'selected'; ?>>Active</option>

                            <option value="inactive" <?php if ($user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
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