<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

/**
 * Get package id from url
 */
$packageId = intval($_GET['package']);

$result = null;

/**
 * If package id is empty then redirect the user to the package page
 */
if (empty($packageId)) {

    echo header('location: index.php');
}

/**
 * Update profile
 */
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $location = $_POST['location'];
    $min_guest = $_POST['min_guest'];
    $max_guest = $_POST['max_guest'];
    $price = $_POST['price'];
    $details = htmlspecialchars($_POST['details']);
    $status = $_POST['status'];

    /**
     * Update package
     */
    $updated = mysqli_query($conn, "UPDATE `packages` SET `package_name` = '$name', `location` = '$location', `min_guest` = '$min_guest', `max_guest` = '$max_guest', `price` = '$price', `details` = '$details', `status` = '$status' WHERE `id` = '$packageId'");

    if ($updated) {

        $result = '<h2 style="color: green; text-align: center; margin-bottom: 20px">Package data has been updated successfully</h2>';
    } else {

        $result = '<h2 style="color: red; text-align: center; margin-bottom: 20px">Something went wrong! Please try again</h2>';
    }
}

/**
 * Show profile details
 */
$query = mysqli_query($conn, "SELECT * FROM `packages` WHERE `id` = '$packageId'");
$package = mysqli_fetch_assoc($query);

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

            <form action="update.php?package=<?php echo $packageId; ?>" method="post" class="book-form">

                <?php echo $result; ?>

                <div class="flex">
                    <div class="inputBox">
                        <span>Package Name :</span>
                        <input type="text" placeholder="Enter name" name="name" value="<?php echo $package['package_name']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Location :</span>
                        <input type="text" placeholder="Enter location" name="location" value="<?php echo $package['location']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Minimim Guest :</span>
                        <input type="number" placeholder="Enter min guest" name="min_guest" value="<?php echo $package['min_guest']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Maximum Guest :</span>
                        <input type="number" placeholder="Enter max guest" name="max_guest" value="<?php echo $package['max_guest']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Price :</span>
                        <input type="number" placeholder="Enter price" name="price" value="<?php echo $package['price']; ?>" required>
                    </div>

                    <div class="inputBox">
                        <span>Details :</span>
                        <textarea placeholder="Enter details" name="details" required><?php echo $package['details']; ?></textarea>
                    </div>

                    <div class="inputBox">
                        <span>Package Status :</span>

                        <select type="number" name="status" required>

                            <option value="">--Select--</option>

                            <option value="1" <?php if ($package['status'] == 1) echo 'selected'; ?>>Active</option>

                            <option value="0" <?php if ($package['status'] == 0) echo 'selected'; ?>>Inactive</option>
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