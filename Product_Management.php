<?php
if (isset($_SESSION['email']) == false) {
    echo "<script>alert('You need to login')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {

    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'f') {
        echo "<script>alert('You are not administrator')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=From.php"/>';
    } else {
?>
        <div class="container my-3">
            <?php
            if (isset($_GET["function"]) == "del") {
                $id = $_GET["id"];
                $sq = "SELECT image FROM products WHERE id = '$id'";
                $res = pg_query($Connect, $sq);
                if (pg_num_rows($res) == 1) {
                    $row = pg_fetch_assoc($res);
                    $filePic = $row['image'];
                    unlink("products/" . $filePic);
                    pg_query($Connect, "DELETE FROM products WHERE id = '$id'");
                }
                echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
            }
            ?>
            <h1>Product Management</h1>
            <p>
                <a href="?page=add_product" class="text-decoration-none">
                    <img src="image/add.png" alt="" width="16" height="16" border="0" /> Add new
                </a>
            </p>
            <table id="tableproduct" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><strong>No.</strong></th>
                        <th><strong>Name</strong></th>
                        <th><strong>Stock</strong></th>
                        <th><strong>Unit Price</strong></th>
                        <th><strong>Category</strong></th>
                        <th><strong>Supplier</strong></th>
                        <th><strong>Shop</strong></th>
                        <th><strong>Image</strong></th>
                        <th><strong>Edit</strong></th>
                        <th><strong>Delete</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $No = 1;
                    $sql = "SELECT p.*, c.name as cate_name, s.name as sup_name, sh.name as shop_name
                            FROM products p
                            JOIN categories c ON p.category_id = c.id
                            JOIN suppliers s ON p.supplier_id = s.id
                            JOIN shops sh ON p.shop_id = sh.id
                            ORDER BY p.created_at DESC";
                    $result = pg_query($Connect, $sql);
                    if (pg_num_rows($result) == 1) {
                        while ($row = pg_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $No; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["stock"]; ?></td>
                                <td><?php echo $row["unit_price"]; ?></td>
                                <td><?php echo $row["cate_name"]; ?></td>
                                <td><?php echo $row["sup_name"]; ?></td>
                                <td><?php echo $row["shop_name"]; ?></td>
                                <td>
                                    <img src="products/<?php echo $row['image'] ?>" width="50" alt="<?php echo $row['name'] ?>">
                                </td>
                                <td align='center' class='columnfunction'>
                                    <a href="?page=update_product&id=<?php echo $row['id'] ?>">
                                        <img src="image/edit.png" width="16" height="16" border='0' />
                                    </a>
                                </td>
                                <td align='center'>
                                    <a href="?page=product_management&function=del&id=<?php echo $row["id"]; ?>" onclick="return deleteConfirm()">
                                        <img src="image/delete.png" border='0' width="16" height="16" />
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $No++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="10" align="center">There is no data</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
            <script>
                function deleteConfirm() {
                    if (confirm("Are you sure to delete!")) {
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