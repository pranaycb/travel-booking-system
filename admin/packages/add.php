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
    $location = $_POST['location'];
    $min_guest = $_POST['min_guest'];
    $max_guest = $_POST['max_guest'];
    $price = $_POST['price'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    /**
     * Add package data
     */
    $inserted = mysqli_query($conn, "INSERT INTO `packages` (`package_name`, `location`, `min_guest`, `max_guest`, `price`, `details`, `status`) VALUES ('$name', '$location', '$min_guest', '$max_guest', '$price', '$details', '$status')");

    if ($inserted) {

        $result = '<h2 style="color: green; text-align: center; margin-bottom: 20px">New package added successfully</h2>';
    } else {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
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
        <h1 class="heading-title">Add Package</h1>

        <!-- menu section starts -->
        <?php include_once "../inc/menu.php"; ?>
        <!-- menu section ends -->

        <section class="booking">

            <form action="add.php" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>Package Name :</span>
                        <input type="text" placeholder="Enter name" name="name" required>
                    </div>

                    <div class="inputBox">
                        <span>Location :</span>
                        <input type="text" placeholder="Enter location" name="location" required>
                    </div>

                    <div class="inputBox">
                        <span>Minimim Guest :</span>
                        <input type="number" placeholder="Enter min guest" name="min_guest" required>
                    </div>

                    <div class="inputBox">
                        <span>Maximum Guest :</span>
                        <input type="number" placeholder="Enter max guest" name="max_guest" required>
                    </div>

                    <div class="inputBox">
                        <span>Price :</span>
                        <input type="number" placeholder="Enter price" name="price" required>
                    </div>

                    <div class="inputBox">
                        <span>Details :</span>
                        <textarea placeholder="Enter details" name="details" required></textarea>
                    </div>

                    <div class="inputBox">
                        <span>Package Status :</span>

                        <select name="status" required>

                            <option value="">--Select--</option>

                            <option value="1">Active</option>

                            <option value="0">Inactive</option>
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