<div class="container my-3">
	<?php
	if (isset($_POST['btnLogin'])) {
		$email = $_POST['txtEmail'];
		$password = $_POST['txtPass'];

		$err = "";
		if ($email == "") {
			$err .= "<li>Enter email, please</li>";
		}
		if ($password == "") {
			$err .= "<li>Enter Password, please</li>";
		}

		if ($err != "") {
			echo $err;
		} else {
			$sql = "SELECT * FROM users WHERE email='$email'";
			$res = pg_query($Connect, $sql) or die(pg_last_error($Connect));
			if (pg_num_rows($res) == 1) {
				$row = pg_fetch_assoc($res);
				$passwordHash = $row['password'];

				if (password_verify($password, $passwordHash)) {
					$_SESSION["email"] = $row["email"];
					$_SESSION["admin"] = $row["is_admin"];
					echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
					// echo "You loged in success";
				} else {
					echo "Password is not correct";
				}
			} else {
				echo "Email is not exist";
			}
		}
	}
	?>
	<h1>Login</h1>
	<form id="form1" name="form1" method="POST" action="">
		<div class="row">
			<div class="forms-inputs mt-3">
				<label for="txtEmail" class="col-sm-2 control-label">Email(*): </label>
				<input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Username" value="" />
			</div>

			<div class="forms-inputs mt-3">
				<label for="txtPass" class="col-sm-2 control-label">Password(*): </label>
				<input type="password" name="txtPass" id="txtPass" class="form-control" placeholder="Password" value="" />
			</div>
			<div class="forms-inputs mt-3">
				<div class="col-sm-2"></div>
				<div class="col-sm-10">
					<input type="submit" name="btnLogin" class="btn btn-primary" id="btnLogin" value="Login" />
					<input type="submit" name="btnCancel" class="btn btn-primary" id="btnCancel" value="Cancel" />
				</div>
			</div>
		</div>

	</form>
</div>