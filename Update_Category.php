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
			$result = pg_query($Connect, "SELECT * FROM categories WHERE id='$id'");
			$row = pg_fetch_assoc($result);
			$cat_id = $row['id'];
			$cat_name = $row['name'];
			$cat_des = $row['description'];
?>
			<div class="container my-2">
				<?php
				if (isset($_POST["btnUpdate"])) {
					$id = $_POST["txtID"];
					$name = $_POST["txtName"];
					$des = $_POST["txtDes"];
					$err = "";
					if ($name == "") {
						$err .= "<li>Enter Category Name, pleease</li>";
					}
					if ($err != "") {
						echo "<ul>$err</ul>";
					} else {
						$sq = "SELECT * FROM categories c where c.name='$name' AND c.id != '$id'";
						$result = pg_query($Connect, $sq);
						if (pg_num_rows($result) == 0) {
							pg_query($Connect, "UPDATE categories SET name = '$name', description='$des' WHERE id='$id'");
							echo '<meta http-equiv="refresh" content="0; URL=?page=category_management"/>';
						} else {
							echo "<li>DUplicate category Name</li>";
						}
					}
				}
				?>
				<h2>Updating Product Category</h2>
				<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
					<input type="hidden" name="txtID" value="<?php echo $cat_id; ?>">
					<div class="forms-inputs mt-3">
						<label for="txtTen" class="col-sm-2 control-label">Category Name(*): </label>
						<div class="col-sm-10">
							<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Catepgy Name" value='<?php echo $cat_name; ?>'>
						</div>
					</div>

					<div class="forms-inputs mt-3">
						<label for="txtMoTa" class="col-sm-2 control-label">Description(*): </label>
						<div class="col-sm-10">
							<input type="text" name="txtDes" id="txtDes" class="form-control" placeholder="Description" value='<?php echo $cat_des; ?>'>
						</div>
					</div>

					<div class="forms-inputs mt-3">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
							<input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_category&id=<?php echo $cat_id; ?>'" />
						</div>
					</div>
				</form>
			</div>
<?php
		} else {
			echo '<meta http-equiv="refresh" content="0; URL=?page=category_management"/>';
		}
	}
}
?>