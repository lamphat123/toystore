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
				$des = $_POST["txtDes"];

				$err = "";
				if ($name == "") {
					$err .= "<li>Enter Category Name, please</li>";
				}
				if ($err != "") {
					echo "<ul>$err</ul>";
				} else {
					$sq = "SELECT * FROM categories c where c.name = '$name'";
					$result = pg_query($Connect, $sq);
					if (pg_num_rows($result) == 0) {
						pg_query($Connect, "INSERT INTO public.categories(name, description) VALUES ('$name', '$des');");
						echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
					} else {
						echo "<li>Duplicate category Name</li>";
					}
				}
			}
			?>
			<h2>Adding Category</h2>
			<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
				<div class="forms-inputs mt-3">
					<label for="txtTen" class="col-sm-2 control-label">Category Name(*): </label>
					<div class="col-sm-10">
						<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Catepgy Name" value='<?php echo isset($_POST["txtName"]) ? ($_POST["txtName"]) : ""; ?>'>
					</div>
				</div>

				<div class="forms-inputs mt-3">
					<label for="txtMoTa" class="col-sm-2 control-label">Description(*): </label>
					<div class="col-sm-10">
						<input type="text" name="txtDes" id="txtDes" class="form-control" placeholder="Description" value='<?php echo isset($_POST["txtDes"]) ? ($_POST["txtDes"]) : ""; ?>'>
					</div>
				</div>

				<div class="forms-inputs mt-3">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
						<input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='Category_Management.php'" />

					</div>
				</div>
			</form>
		</div>
<?php
	}
}
?>