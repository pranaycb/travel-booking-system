<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

$query = mysqli_query($conn, "SELECT 
                        users.name as username, 
                        packages.package_name, 
                        packages.location, 
                        packages.price, 
                        bookings.id as bookingId, 
                        bookings.guests, 
                        bookings.arrivals, 
                        bookings.leaving, 
                        bookings.status 
                    FROM 
                        bookings 
                    LEFT JOIN 
                        packages ON packages.id = bookings.package_id 
                    INNER JOIN  
                        users ON users.id = bookings.user_id
                    ORDER BY
                        bookings.id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head starts -->
    <?php include_once '../inc/head.php'; ?>
    <!-- head ends -->

    <style>
        div.table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #ccc;
            text-align: left;
            padding: 8px 15px;
            font-size: 14px;
            text-wrap: nowrap;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <!-- header section starts -->
    <?php include_once '../inc/header.php'; ?>
    <!-- header section ends -->

    <section class="services">
        <h1 class="heading-title">Bookings</h1>

        <!-- menu section starts -->
        <?php include_once "../inc/menu.php"; ?>
        <!-- menu section ends -->

        <h1 style="margin-top: 35px; margin-bottom: 15px">Booking List</h1>

        <div class="table-responsive">
            <table width="100%" border="none">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Booking Id</th>
                        <th>User</th>
                        <th>Package</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Guest</th>
                        <th>Arrival</th>
                        <th>Leaving</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0) {

                        $count = 1;

                        while ($result = mysqli_fetch_assoc($query)) { ?>

                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo 'B-' . $result['bookingId']; ?></td>
                                <td><?php echo $result['username']; ?></td>
                                <td><?php echo $result['package_name']; ?></td>
                                <td><?php echo $result['location']; ?></td>
                                <td><?php echo number_format($result['price']); ?>৳</td>
                                <td><?php echo $result['guests']; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($result['arrivals'])); ?></td>
                                <td><?php echo date('d.m.Y', strtotime($result['leaving'])); ?></td>
                                <td>
                                    <?php if ($result['status'] == 'confirmed') {

                                        echo '<span style="color: green; font-weight: bold">Confirmed</span>';
                                    } else if ($result['status'] == 'pending') {

                                        echo '<span style="color: orange; font-weight: bold">Pending</span>';
                                    } else {

                                        echo '<span style="color: red; font-weight: bold">Rejected</span>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="update.php?booking=<?php echo $result['bookingId']; ?>"><i class="fa fa-edit"></i></a>
                                    &nbsp; | &nbsp;
                                    <a href="delete.php?booking=<?php echo $result['bookingId']; ?>" style="color: red"><i class="fa fa-trash-can"></i></a>
                                </td>
                            </tr>

                        <?php $count++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="11" style="text-align: center; color: red; font-weight: bold">No booking data found!</td>
                        </tr>
                    <?php } ?>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </section>



    <!-- footer section starts -->
    <?php include_once '../inc/footer.php'; ?>
    <!-- footer section ends -->

    <!-- javascript -->
    <?php include_once '../inc/js.php'; ?>
    <!-- javascript -->
</body>

</html>