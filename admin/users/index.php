<?php

include_once '../../configs/database.php';

/**
 * Redirect to homepage if user is not authorised
 */
if (!isset($_SESSION['is_authenticated']) || $_SESSION['authenticated_as'] != 'admin') {

    header('location: ../index.php');
}

$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` != '1' ORDER BY `id` DESC");
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
        <h1 class="heading-title">Users</h1>

        <!-- menu section starts -->
        <?php include_once "../inc/menu.php"; ?>
        <!-- menu section ends -->

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 35px; margin-bottom: 15px">
            <h1>User List</h1>
            <a href="add.php" class="btn">Add User</a>
        </div>

        <div class="table-responsive">
            <table width="100%" border="none">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
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
                                <td><?php echo $result['name']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['phone']; ?></td>
                                <td><?php echo $result['address']; ?></td>
                                <td>
                                    <?php if ($result['status'] == 'active') {

                                        echo '<span style="color: green; font-weight: bold">Active</span>';
                                    } else {

                                        echo '<span style="color: red; font-weight: bold">Inactive</span>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="update.php?user=<?php echo $result['id']; ?>"><i class="fa fa-edit"></i></a>
                                    &nbsp; | &nbsp;
                                    <a href="delete.php?user=<?php echo $result['id']; ?>" style="color: red"><i class="fa fa-trash-can"></i></a>
                                </td>
                            </tr>

                        <?php $count++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: red; font-weight: bold">No users data found!</td>
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