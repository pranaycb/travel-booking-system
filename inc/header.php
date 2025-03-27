<section class="header">
    <a href="home.php" class="logo">Travel.</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="package.php">Packages</a>
        <a href="contact.php">Contact</a>

        <?php if (isset($_SESSION['is_authenticated'])) { ?>

            <a href="<?php echo $_SESSION['authenticated_as']; ?>/">Dashboard</a>

        <?php } else { ?>

            <a href="register.php">Register</a>

            <a href="login.php">Login</a>

        <?php } ?>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>