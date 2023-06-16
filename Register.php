<div class="container my-3">
    <?php
    if (isset($_POST['btnRegister'])) {
        $fullname = $_POST['txtFullname'];
        $email = $_POST['txtEmail'];
        $password = $_POST['txtPassword'];
        $confirm = $_POST['txtConfirm'];
        $phone = $_POST['txtPhone'];
        $address = $_POST['txtAddress'];

        $err = "";
        if (
            $password == "" || $confirm == "" || $fullname == ""
            || $email == "" || $address == "" || $phone == ""
        ) {
            $err .= "<li>Enter fields with mark (*), please</li>";
        }
        if (strlen($password) <= 5) {
            $err .= "<li>Password must be greater than 5 chars</li>";
        }
        if ($password != $confirm) {
            $err .= "<li>Password and confirm password are the same</li>";
        }
        if ($err != "") {
            echo $err;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sq = "SELECT * FROM users WHERE email='$email'";
            $res = pg_query($Connect, $sq);
            if (pg_num_rows($res) == 0) {
                $sql = "INSERT INTO public.users(full_name, email, password, phone, address, is_admin) VALUES ('$fullname', '$email', '$hashedPassword', '$phone', '$address', false)";
                pg_query($Connect, $sql) or die(pg_last_error($Connect));
                echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
            } else {
                echo "Username or email already exists";
            }
        }
    }
    ?>
    <h2>Member Registration</h2>
    <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
        <div class="forms-inputs mt-3">
            <label for="txtFullname" class="col-sm-2 control-label">Full name(*): </label>
            <input type="text" name="txtFullname" id="txtFullname" value="" class="form-control" placeholder="Enter Fullname" />
        </div>

        <div class="forms-inputs mt-3">
            <label for="txtEmail" class="col-sm-2 control-label">Email(*): </label>
            <input type="text" name="txtEmail" id="txtEmail" value="" class="form-control" placeholder="Email" />
        </div>

        <div class="forms-inputs mt-3">
            <label for="txtPassword" class="col-sm-2 control-label">Password(*): </label>
            <input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Password" />
        </div>

        <div class="forms-inputs mt-3">
            <label for="txtConfirm" class="col-sm-2 control-label">Confirm Password(*): </label>
            <input type="password" name="txtConfirm" id="txtConfirm" class="form-control" placeholder="Confirm your Password" />
        </div>

        <div class="forms-inputs mt-3">
            <label for="txtPhone" class="col-sm-2 control-label">Telephone(*): </label>
            <input type="text" name="txtPhone" id="txtPhone" value="" class="form-control" placeholder="Telephone" />
        </div>

        <div class="forms-inputs mt-3">
            <label for="txtAddress" class="col-sm-2 control-label">Address(*): </label>
            <input type="text" name="txtAddress" id="txtAddress" value="" class="form-control" placeholder="Address" />
        </div>

        <div class="forms-inputs mt-3">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-primary" name="btnRegister" id="btnRegister" value="Register" />

            </div>
        </div>
    </form>
</div>