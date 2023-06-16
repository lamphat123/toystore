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
                    pg_query($Connect, "DELETE FROM categories WHERE id = '$id'");
                    echo '<meta http-equiv="refresh" content="0; URL=?page=category_management"/>';
                }
            }
            ?>
            <h1>Category</h1>
            <p>
                <img src="image/add.png" alt="Add new" width="16" height="16" border="0" /> <a href="?page=add_category" class="text-decoration-none"> Add</a>
            </p>
            <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><strong>No.</strong></th>
                        <th><strong>Category Name</strong></th>
                        <th><strong>Desscriptin</strong></th>
                        <th><strong>Edit</strong></th>
                        <th><strong>Delete</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $No = 1;
                    $result = pg_query($Connect, "SELECT * FROM categories");
                    if (pg_num_rows($result) == 1) {
                        while ($row = pg_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td class="text-center"><?php echo $No; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["description"]; ?></td>
                                <td style='text-align:center'>
                                    <a href="?page=update_category&id=<?php echo $row["id"]; ?>">
                                        <img src='image/edit.png' width="16" height="16" border='0' />
                                    </a>
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=category_management&function=del&id=<?php echo $row["id"]; ?>" onclick=" return deleteConfirm()">
                                        <img src='image/delete.png' width="16" height="16" border="0" /></a>
                                </td>
                            </tr>
                    <?php
                            $No++;
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No data</td></tr>";
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