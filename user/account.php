<?php

include_once '../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'user') {

    header('location: ../index.php');
}

$profileUpdateResult = null;
$passwordUpdateResult = null;

$userId = $_SESSION['user_id'];

/**
 * Update profile
 */
if (isset($_POST['update-profile'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    /**
     * Validate email is already used or not
     */
    $usedEmail = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` != '$userId' AND `email` = '$email'"));

    /**
     * Validate phone is already used or not
     */
    $usedPhone = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` != '$userId' AND `phone` = '$phone'"));

    if ($usedEmail > 0) {

        $profileUpdateResult = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Email id already exists!</h2>';
    } else if ($usedPhone > 0) {

        $profileUpdateResult = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Mobile number is already exists!</h2>';
    } else {

        /**
         * All is well :)
         * Update user's profile data
         */
        $updated = mysqli_query($conn, "UPDATE `users` SET `name` = '$name', `phone` = '$phone', `email` = '$email', `address` = '$address' WHERE `id` = '$userId'");

        if ($updated) {

            $profileUpdateResult = '<h2 style="color: green; text-align: center; margin-bottom: 20px">Profile data has been successfully updated</h2>';
        } else {

            $profileUpdateResult = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
        }
    }
}

/**
 * Update password
 */
if (isset($_POST['update-password'])) {

    $currPassword = $_POST['curr-password'];
    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);

    /**
     * Check current password is correct or not
     */
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$userId'"));

    if (password_verify($currPassword, $user['password'])) {

        /**
         * All is well :)
         * Update user password
         */
        $updated = mysqli_query($conn, "UPDATE `users` SET `password` = '$newPassword' WHERE `id` = '$userId'");

        if ($updated) {

            $passwordUpdateResult = '<h2 style="color: green; text-align: center; margin-bottom: 20px">Password has been successfully updated</h2>';
        } else {

            $passwordUpdateResult = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
        }
    } else {

        $passwordUpdateResult = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Your current password is wrong!</h2>';
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
    <?php include_once './inc/head.php'; ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once './inc/header.php'; ?>
    <!-- header section ends -->

    <section class="services">
        <h1 class="heading-title">Update Profile</h1>

        <!-- menu section starts -->
        <?php include_once "./inc/menu.php"; ?>
        <!-- menu section ends -->

        <section class="booking">

            <h1 style="margin-top: 35px; margin-bottom: 15px; font-size: 20px">Update Profile</h1>

            <form action="account.php" method="post" class="book-form">

                <?php echo $profileUpdateResult; ?>

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
                </div>
                <input type="submit" value="submit" class="btn" name="update-profile">
            </form>
        </section>

        <section class="booking">

            <h1 style="margin-top: 35px; margin-bottom: 15px; font-size: 20px">Update Password</h1>

            <form action="account.php" method="post" class="book-form">

                <?php echo $passwordUpdateResult; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>Current Password :</span>
                        <input type="password" placeholder="Enter current password" name="curr-password" required>
                    </div>
                    <div class="inputBox">
                        <span>New Password :</span>
                        <input type="password" placeholder="Enter new password" name="new-password" required>
                    </div>
                </div>
                <input type="submit" value="submit" class="btn" name="update-password">
            </form>
        </section>
    </section>


    <!-- footer section starts -->
    <?php include_once './inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once './inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>