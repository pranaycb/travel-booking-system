<?php

include_once "configs/database.php";
include_once "configs/smsq.php";

$result = null;

/**
 * Insert data
 */
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['conform-password'];

    if ($password != $confirmPassword) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Passwords does not matched!</h2>';
    }

    /**
     * Validate email is already used or not
     */
    $usedEmail = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'"));

    /**
     * Validate phone is already used or not
     */
    $usedPhone = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `users` WHERE `phone` = '$phone'"));

    if ($usedEmail > 0) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Email id already exists!</h2>';
    } else if ($usedPhone > 0) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Mobile number is already exists!</h2>';
    } else {

        $password = password_hash($password, PASSWORD_DEFAULT);

        /**
         * All is well :)
         * Add user data
         */
        $inserted = mysqli_query($conn, "INSERT INTO `users` (`name`, `phone`, `address`, `email`, `password`) VALUES ('$name', '$phone', '$address', '$email', '$password')");

        if ($inserted) {

            /**
             * Send sms message
             */

            $message = "Congratulations $name!\nYour registration is successful. Login credrntials for your account\nEmail: $email\nPass: $confirmPassword\n\nRegardsTBS By Kamrun";

            sendSms($phone, $message);

            $_SESSION['is_authenticated'] = true;
            $_SESSION['authenticated_as'] = 'user';
            $_SESSION['user_id'] = mysqli_insert_id($conn);

            header('location: user/');
        } else {

            $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
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
        <h1>Register</h1>
    </div>

    <!-- booking section starts -->

    <section class="booking">

        <form action="register.php" method="post" class="book-form">

            <?php echo $result; ?>

            <div class="flex">
                <div class="inputBox">
                    <span>Name :</span>
                    <input type="text" placeholder="Enter name" name="name" required>
                </div>

                <div class="inputBox">
                    <span>Phone Number :</span>
                    <input placeholder="Enter phone number" name="phone" required>
                </div>

                <div class="inputBox">
                    <span>Email Id :</span>
                    <input type="email" placeholder="Enter email" name="email" required>
                </div>

                <div class="inputBox">
                    <span>Address :</span>
                    <input type="text" placeholder="Enter address" name="address" required>
                </div>

                <div class="inputBox">
                    <span>Password :</span>
                    <input type="password" placeholder="Enter password" name="password" required>
                </div>

                <div class="inputBox">
                    <span>Confirm Password :</span>
                    <input type="password" placeholder="Confirm password" name="conform-password" required>
                </div>
            </div>
            <input type="submit" value="submit" class="btn" name="submit">
        </form>
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