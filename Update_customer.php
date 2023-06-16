<?php
//Get custmer information
$query = "SELECT CustName, Address, email, telephone
           from customer
		   where Username = '" . $_SESSION["us"] . "'";
$result = pg_query($Connect, $query) or die("");
$row = pg_fetch_array($result, MYSQLI_ASSOC);

$us = $_SESSION["us"];
$email = $row["email"];
$fullname = $row["CustName"];
$address = $row["Address"];
$telephone = $row["telephone"];


//Update information when the user presses the "Update" button
if (isset($_POST['btnUpdate'])) {
	$fullname = $_POST['txtFullname'];
	$address = $_POST['txtAddress'];
	$tel = $_POST['txtTel'];

	$test = check();
	if ($test == "") {
		//customer changes password
		if ($_POST['txtPass1'] != "") {
			$pass = md5(($_POST['txtPass1']));

			$sq = "UPATE customer
			 SET CustNmae='$fullname', Address='$address',
			 telephone='$telephone', Password='$pass'
			 where Username = '" . $_SESSION['us'] . "'";

			pg_query($Connect, $sq) or die("");
		}
		//customer does not change password
		else {
			$sq = "UPATE customer
			 SET CustNmae='$fullname', Address='$address',
			 telephone='$telephone' where Username = '" . $_SESSION['us'] . "'";
			pg_query($Connect, $sq) or die("");
		}
		echo '<meta http-equiv="refresh" content="0;URL=From.php"/>';
	} else {
		echo $test;
	}
}


//Write check() function to check information
function check()
{
	if ($_POST['txtFullname'] == "" || $_POST['txtAddress'] == "") {
		return "<li>Password is greater than 5 characters</li>";
	} elseif (strlen($_POST['txtPass1']) > 0 && strlen($_POST['txtPass1']) <= 5) {
		return "<li>Password is greater than 5 characters</li>";
	} elseif ($_POST['txtPass1'] != $_POST['txtPass2']) {
		return "<li>Password is Confirm Pass do not match than</li>";
	} else {
		return "";
	}
}

?>
<div class="container">

	<h2>Update Profile</h2>

	<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
		<div class="form-group">

			<label for="lblTenDangNhap" class="col-sm-2 control-label">Username(*): </label>
			<div class="col-sm-10">
				<label class="form-control" style="font-weight:400"><?php echo $us ?></label>
			</div>
		</div>

		<div class="form-group">
			<label for="lblEmail" class="col-sm-2 control-label">Email(*): </label>
			<div class="col-sm-10">
				<label class="form-control" style="font-weight:400"><?php echo $email ?></label>
			</div>
		</div>

		<div class="form-group">
			<label for="lblMatKhau1" class="col-sm-2 control-label">Password(*): </label>
			<div class="col-sm-10">
				<input type="password" name="txtPass1" id="txtPass1" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label for="lblMatKhau2" class="col-sm-2 control-label">Confirm Password(*): </label>
			<div class="col-sm-10">
				<input type="password" name="txtPass2" id="txtPass2" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label for="lblHoten" class="col-sm-2 control-label">Full name(*): </label>
			<div class="col-sm-10">
				<input type="text" name="txtFullname" id="txtFullname" value="<?php echo $fullname ?>" class="form-control" placeholder="Enter Fullname, please" />
			</div>
		</div>

		<div class="form-group">
			<label for="lblDiaChi" class="col-sm-2 control-label">Address(*): </label>
			<div class="col-sm-10">
				<input type="text" name="txtAddress" id="txtAddress" value="<?php echo $address ?>" class="form-control" placeholder="Enter Address, please" />
			</div>
		</div>

		<div class="form-group">
			<label for="lblDienThoai" class="col-sm-2 control-label">Telephone(*): </label>
			<div class="col-sm-10">
				<input type="text" name="txtTel" id="txtTel" value="<?php echo $telephone ?>" class="form-control" placeholder="Enter Telephone, please" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />

			</div>
		</div>
	</form>
</div>