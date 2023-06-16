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
        <div class="container my-3">
            <?php
            if (isset($_POST["btnAdd"])) {
                $name = $_POST["txtName"];
                $phone = $_POST["txtPhone"];
                $email = $_POST["txtEmail"];
                $address = $_POST["txtAddress"];

                $err = "";
                if ($name == "") {
                    $err .= "<li>Enter dupplier name, please</li>";
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
                    $sq = "SELECT * FROM shops s where s.name = '$name'";
                    $result = pg_query($Connect, $sq);
                    if (pg_num_rows($result) == 0) {
                        pg_query($Connect, "INSERT INTO public.shops(name, phone, email, address) VALUES ('$name', '$phone', '$email', '$address');");
                        echo '<meta http-equiv="refresh" content = "0; URL=?page=shop_management"/>';
                    } else {
                        echo "<li>Duplicate shop Name</li>";
                    }
                }
            }
            ?>
            <h2>Adding Shop</h2>
            <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
                <div class="forms-inputs mt-3">
                    <label for="txtName" class="col-sm-2 control-label">Shop Name(*): </label>
                    <div class="col-sm-10">
                        <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Catepgy Name" value='<?php echo isset($_POST["txtName"]) ? ($_POST["txtName"]) : ""; ?>'>
                    </div>
                </div>

                <div class="forms-inputs mt-3">
                    <label for="txtPhone" class="col-sm-2 control-label">Shop Phone(*): </label>
                    <div class="col-sm-10">
                        <input type="text" name="txtPhone" id="txtPhone" class="form-control" placeholder="Phone" value='<?php echo isset($_POST["txtPhone"]) ? ($_POST["txtPhone"]) : ""; ?>'>
                    </div>
                </div>

                <div class="forms-inputs mt-3">
                    <label for="txtEmail" class="col-sm-2 control-label">Email(*): </label>
                    <div class="col-sm-10">
                        <input type="text" name="txtEmail" id="txtEmail" class="form-control" placeholder="Email" value='<?php echo isset($_POST["txtEmail"]) ? ($_POST["txtEmail"]) : ""; ?>'>
                    </div>
                </div>

                <div class="forms-inputs mt-3">
                    <label for="txtAddress" class="col-sm-2 control-label">Address(*): </label>
                    <div class="col-sm-10">
                        <input type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Address" value='<?php echo isset($_POST["txtAddress"]) ? ($_POST["txtAddress"]) : ""; ?>'>
                    </div>
                </div>

                <div class="forms-inputs mt-3">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
                        <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=shop_management.php'" />

                    </div>
                </div>
            </form>
        </div>
<?php
    }
}
?>