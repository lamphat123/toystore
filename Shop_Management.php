<?php
if (isset($_SESSION['email']) == false) {
    echo "<script>alert('You need to login')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'f') {
        echo "<script>alert('You are not administrator')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
    } else {
?>
        <div class="container">
            <?php
            if (isset($_GET["function"]) == "del") {
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                    pg_query($Connect, "DELETE FROM shops WHERE id = '$id'");
                    echo '<meta http-equiv="refresh" content="0; URL=?page=shop_management"/>';
                }
            }
            ?>
            <h1>Shop</h1>
            <p>
                <img src="image/add.png" alt="Add new" width="16" height="16" border="0" /> <a href="?page=add_shop" class="text-decoration-none"> Add</a>
            </p>
            <table id="tableshop" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><strong>No.</strong></th>
                        <th><strong>Name</strong></th>
                        <th><strong>Phone</strong></th>
                        <th><strong>Email</strong></th>
                        <th><strong>Address</strong></th>
                        <th><strong>Edit</strong></th>
                        <th><strong>Delete</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $No = 1;
                    $result = pg_query($Connect, "SELECT * FROM shops");
                    if (pg_num_rows($result) > 0) {
                        while ($row = pg_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td class="text-center"><?php echo $No; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td style='text-align:center'>
                                    <a href="?page=update_shop&id=<?php echo $row["id"]; ?>">
                                        <img src='image/edit.png' width="16" height="16" border='0' />
                                    </a>
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=shop_management&function=del&id=<?php echo $row["id"]; ?>" onclick=" return deleteConfirm()">
                                        <img src='image/delete.png' width="16" height="16" border="0" /></a>
                                </td>
                            </tr>
                    <?php
                            $No++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <script>
                function deleteConfirm() {
                    if (confirm("Are you sure to delete")) {
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        </div>
<?php
    }
}
?>