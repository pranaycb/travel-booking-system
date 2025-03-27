<?php

include_once "configs/database.php";

/**
 * Fetch recent 6 packages from database
 */
$query = mysqli_query($conn, "SELECT * FROM `packages` WHERE `status` = '1' ORDER BY `id` DESC LIMIT 6");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head starts -->
    <?php include_once('inc/head.php'); ?>
    <!-- head ends -->
</head>

<body>

    <!-- header section starts -->
    <?php include_once 'inc/header.php'; ?>
    <!-- header section ends -->

    <!-- home section starts -->
    <section class="home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide" style="background:url(images/home-slide-1.jpeg) no-repeat">
                    <div class="content">
                        <span>explore, discover, travel</span>
                        <h3>travel around the world</h3>
                        <a href="package.php" class="btn">discover more</a>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background:url(images/home-slide-2.jpeg) no-repeat">
                    <div class="content">
                        <span>explore, discover, travel</span>
                        <h3>discover the new places</h3>
                        <a href="package.php" class="btn">discover more</a>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background:url(images/home-slide-3.jpeg) no-repeat">
                    <div class="content">
                        <span>explore, discover, travel</span>
                        <h3>make your tour worthwhile</h3>
                        <a href="package.php" class="btn">discover more</a>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    <!-- home section ends -->

    <!-- services section starts -->
    <section class="services">
        <h1 class="heading-title"> our services</h1>
        <div class="box-container">
            <div class="box">
                <img src="images/icon-1.jpg" alt="">
                <h3>adventure</h3>
            </div>

            <div class="box">
                <img src="images/icon-2.jpg" alt="">
                <h3>tour guide</h3>
            </div>
            <div class="box">
                <img src="images/icon-3.jpg" alt="">
                <h3>trekking</h3>
            </div>
            <div class="box">
                <img src="images/icon-4.jpg" alt="">
                <h3>camp fire</h3>
            </div>
            <div class="box">
                <img src="images/icon-5.jpg" alt="">
                <h3>off road</h3>
            </div>
            <div class="box">
                <img src="images/icon-6.jpg" alt="">
                <h3>camping</h3>
            </div>
        </div>
    </section>
    <!-- services section ends -->


    <!-- home about section starts -->
    <section class="home-about">
        <div class="image">
            <img src="images/about-img.png" alt="">
        </div>

        <div class="content">
            <h3>about us</h3>
            <p>Our company was founded on the principles of providing high-quality, personalized service to each and every one of our customers. We believe that travel is not just about visiting new places, but also about creating unforgettable memories and enriching experiences that last a lifetime.</p>
            <a href="about.php" class="btn">read more</a>

        </div>
    </section>
    <!-- home about section ends -->

    <!-- home package section starts -->
    <section class="home-packages">
        <h1 class="heading-title"> our packages </h1>

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

        <?php
        /**
         * If package is more than 6 then show the button
         */

        if (mysqli_num_rows($query) > 6) { ?>

            <div class="load-more">
                <a href="package.php" class="btn">View All Packages</a>
            </div>

        <?php } ?>
    </section>
    <!-- home package section ends -->


    <!-- home offer section starts -->
    <section class="home-offer">
        <div class="content">
            <h3>upto 50% off</h3>
            <p>Experience the world for less with our exclusive offer of up to 50% off on travel and tour packages. Save big with up to 50% off on all our travel and tour packages. Book now!</p>
            <a href="book.php" class="btn"> book now</a>
        </div>
    </section>
    <!-- home offer section ends -->

    <!-- footer section starts -->
    <?php include_once 'inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once 'inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>