<?php
if (isset($_SESSION['email']) == false) {
    echo "<script>alert('You need to login')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'f') {
        echo "<script>alert('You are not administrator')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
    } else {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $result = pg_query($Connect, "SELECT * FROM suppliers WHERE id='$id'");
            $row = pg_fetch_assoc($result);
            $sup_id = $row['id'];
            $sup_name = $row['name'];
            $sup_email = $row['email'];
            $sup_address = $row['address'];
?>
            <div class="container my-2">
                <?php
                if (isset($_POST["btnUpdate"])) {
                    $id = $_POST["txtID"];
                    $name = $_POST["txtName"];
                    $email = $_POST["txtEmail"];
                    $address = $_POST["txtAddress"];

                    $err = "";
                    if ($name == "") {
                        $err .= "<li>Enter Supplier Name, pleease</li>";
                    }
                    if ($email == "") {
                        $err .= "<li>Enter email, please</li>";
                    }
                    if ($address == "") {
                        $err .= "<li>Enter address, please</li>";
                    }
                    if ($err != "") {
                        echo "<ul>$err</ul>";
                    } else {
                        $sq = "SELECT * FROM suppliers c where c.name='$name' AND c.id != '$id'";
                        $result = pg_query($Connect, $sq);
                        if (pg_num_rows($result) == 0) {
                            pg_query($Connect, "UPDATE suppliers SET name = '$name', email='$email', address='$address' WHERE id='$id'");
                            echo '<meta http-equiv="refresh" content="0; URL=?page=supplier_management"/>';
                        } else {
                            echo "<li>DUplicate supplier Name</li>";
                        }
                    }
                }
                ?>
                <h2>Updating Product Supplier</h2>
                <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
                    <input type="hidden" name="txtID" value="<?php echo $sup_id; ?>">
                    <div class="forms-inputs mt-3">
                        <label for="txtTen" class="col-sm-2 control-label">Supplier Name(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Supplier Name" value='<?php echo $sup_name; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <label for="txtMoTa" class="col-sm-2 control-label">Email(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtEmail" id="txtEmail" class="form-control" placeholder="Email" value='<?php echo $sup_email; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <label for="txtMoTa" class="col-sm-2 control-label">Address(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Address" value='<?php echo $sup_address; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
                            <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_supplier&id=<?php echo $sup_id; ?>'" />
                        </div>
                    </div>
                </form>
            </div>
<?php
        } else {
            echo '<meta http-equiv="refresh" content="0; URL=?page=supplier_management"/>';
        }
    }
}
?>