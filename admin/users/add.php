<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

$result = null;

/**
 * Insert data
 */
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = $_POST['status'];

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

        /**
         * All is well :)
         * Add user data
         */
        $inserted = mysqli_query($conn, "INSERT INTO `users` (`name`, `phone`, `address`, `email`, `password`, `role`, `status`) VALUES ('$name', '$phone', '$address', '$email', '$password', 'user', '$status')");

        if ($inserted) {

            $result = '<h2 style="color: green; text-align: center; margin-bottom: 20px">New user added successfully</h2>';
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
    <?php include_once '../inc/head.php'; ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once '../inc/header.php'; ?>
    <!-- header section ends -->

    <section class="services">
        <h1 class="heading-title">Add User</h1>

        <!-- menu section starts -->
        <?php include_once "../inc/menu.php"; ?>
        <!-- menu section ends -->

        <section class="booking">

            <form action="add.php" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>Name :</span>
                        <input type="text" placeholder="Enter name" name="name" required>
                    </div>

                    <div class="inputBox">
                        <span>Phone Number :</span>
                        <input type="number" placeholder="Enter phone number" name="phone" required>
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
                        <span>Account Status :</span>

                        <select type="number" name="status" required>

                            <option value="">--Select--</option>

                            <option value="active">Active</option>

                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <input type="submit" value="submit" class="btn" name="submit">
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