<?php

include_once "configs/database.php";

/**
 * Fetch all packages from database which is active
 */
$query = mysqli_query($conn, "SELECT * FROM `packages` WHERE `status` = '1'");

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

    <div class="heading" style="background:url(images/header-bg-2.jpeg) no-repeat">
        <h1>packages</h1>

    </div>

    <!-- packages section starts -->
    <section class="packages">
        <h1 class="heading-title">top destinations</h1>

        <div class="box-container">

            <?php

            /**
             * Check if data is empty or not
             * If not then show the data using while loop
             */
            if (mysqli_num_rows($query) > 0) {

                while ($package = mysqli_fetch_assoc($query)) { ?>

                    <div class="box">
                        <div class="image">
                            <img src="images/pack-1.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>
                                <?php echo $package['package_name']; ?>
                            </h3>
                            <p style="padding-bottom: 0px; margin-bottom: 0px">
                                Pricing: <span style="color: blue; font-weight: bold">
                                    <?php echo number_format($package['price']); ?>৳</span>
                            </p>
                            <p style="padding-bottom: 0px; margin-bottom: 0px">
                                Travel Location: <span style="color: blue; font-weight: bold">
                                    <?php echo $package['location']; ?></span>
                            </p>
                            <p style="padding-bottom: 0px; margin-bottom: 0px">
                                Guest: <span style="color: blue; font-weight: bold">
                                    <?php echo $package['min_guest'] . ' - ' . $package['max_guest']; ?></span>
                            </p>
                            <p><?php echo $package['details']; ?></p>
                            <a href="book.php?package=<?php echo $package['id']; ?>" class="btn">Book Now</a>
                        </div>
                    </div>

            <?php }
            } else {

                echo '<h1 style="color: red; text-align: center">No packages found</h1>';
            }
            ?>
        </div>
    </section>
    <!-- packages section ends -->


    <!-- footer section starts -->
    <?php include_once 'inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once 'inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>