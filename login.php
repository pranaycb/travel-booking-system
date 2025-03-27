<?php

include_once "configs/database.php";

$result = null;

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    /**
     * Select user based on email
     */
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'");

    $user = mysqli_fetch_assoc($query);

    /**
     * If email id is invalid
     */
    if (empty($user)) {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Invalid email id given</h2>';
    } else {

        /**
         * Check if password is valid or not
         */
        if (!password_verify($password, $user['password'])) {

            $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Invalid password given</h2>';
        } else {

            /**
             * Check if the user account is active or not
             */
            if ($user['status'] != 'active') {

                $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Your account is deactivated by the admin</h2>';
            } else {

                /**
                 * All is well :)
                 * Do user login
                 */
                $_SESSION['is_authenticated'] = true;
                $_SESSION['authenticated_as'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];

                /**
                 * Check role if it is admin or not
                 * If admion then redirect to the admin dashboard
                 * Else redirect to the homepage
                 */
                if ($user['role'] == 'admin') {

                    header('location: admin/');
                } else {

                    header('location: user/');
                }
            }
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
        <h1>Login</h1>
    </div>

    <!-- booking section starts -->

    <section class="booking">
        <h1 class="heading-title">Login</h1>

        <form action="login.php" method="post" class="book-form">

            <?php echo $result; ?>

            <div class="flex" style="display: block">
                <div class="inputBox" style="margin-bottom: 20px;">
                    <span>Email</span>
                    <input type="email" placeholder="Enter your email" name="email" required>
                </div>

                <div class="inputBox">
                    <span>Password</span>
                    <input type="password" placeholder="Enter your password" name="password" required>
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