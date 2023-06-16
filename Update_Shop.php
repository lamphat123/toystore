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
            $result = pg_query($Connect, "SELECT * FROM shops WHERE id='$id'");
            $row = pg_fetch_assoc($result);
            $shop_id = $row['id'];
            $shop_name = $row['name'];
            $shop_phone = $row['phone'];
            $shop_email = $row['email'];
            $shop_address = $row['address'];
?>
            <div class="container my-2">
                <?php
                if (isset($_POST["btnUpdate"])) {
                    $id = $_POST["txtID"];
                    $name = $_POST["txtName"];
                    $phone = $_POST["txtPhone"];
                    $email = $_POST["txtEmail"];
                    $address = $_POST["txtAddress"];

                    $err = "";
                    if ($name == "") {
                        $err .= "<li>Enter Shop Name, pleease</li>";
                    }
                    if ($phone == "") {
                        $err .= "<li>Enter phone, please</li>";
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
                        $sq = "SELECT * FROM shops c where c.name='$name' AND c.id != '$id'";
                        $result = pg_query($Connect, $sq);
                        if (pg_num_rows($result) == 0) {
                            pg_query($Connect, "UPDATE shops SET name = '$name', phone='$phone', email='$email', address='$address' WHERE id='$id'");
                            echo '<meta http-equiv="refresh" content="0; URL=?page=shop_management"/>';
                        } else {
                            echo "<li>DUplicate shop Name</li>";
                        }
                    }
                }
                ?>
                <h2>Updating Product Shop</h2>
                <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
                    <input type="hidden" name="txtID" value="<?php echo $shop_id; ?>">
                    <div class="forms-inputs mt-3">
                        <label for="txtTen" class="col-sm-2 control-label">Shop Name(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Catepgy Name" value='<?php echo $shop_name; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <label for="txtPhone" class="col-sm-2 control-label">Shop Phone(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtPhone" id="txtPhone" class="form-control" placeholder="Phone" value='<?php echo $shop_phone; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <label for="txtMoTa" class="col-sm-2 control-label">Email(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtEmail" id="txtEmail" class="form-control" placeholder="Email" value='<?php echo $shop_email; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <label for="txtMoTa" class="col-sm-2 control-label">Address(*): </label>
                        <div class="col-sm-10">
                            <input type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Address" value='<?php echo $shop_address; ?>'>
                        </div>
                    </div>

                    <div class="forms-inputs mt-3">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
                            <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_shop&id=<?php echo $shop_id; ?>'" />
                        </div>
                    </div>
                </form>
            </div>
<?php
        } else {
            echo '<meta http-equiv="refresh" content="0; URL=?page=shop_management"/>';
        }
    }
}
?>