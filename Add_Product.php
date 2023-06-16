<?php
if (isset($_SESSION['email']) == false) {
	echo "<script>alert('You need to login')</script>";
	echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'f') {
		echo "<script>alert('You are not administrator')</script>";
		echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
	} else {
		function bind_Category_List($Connect)
		{
			$sqlstring = "SELECT id, name from categories";
			$result = pg_query($Connect, $sqlstring);
			echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
			while ($row = pg_fetch_assoc($result)) {
				echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
			}
			echo "</select>";
		}
		function bind_Supplier_List($Connect)
		{
			$sqlstring = "SELECT id, name from suppliers";
			$result = pg_query($Connect, $sqlstring);
			echo "<select name='SupplierList' class='form-control'>
					<option value='0'>Choose supplier</option>";
			while ($row = pg_fetch_assoc($result)) {
				echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
			}
			echo "</select>";
		}
		function bind_Shop_List($Connect)
		{
			$sqlstring = "SELECT id, name from shops";
			$result = pg_query($Connect, $sqlstring);
			echo "<select name='ShopList' class='form-control'>
					<option value='0'>Choose shop</option>";
			while ($row = pg_fetch_assoc($result)) {
				echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
			}
			echo "</select>";
		}
?>
		<div class="container my-3">
			<?php
			if (isset($_POST["btnAdd"])) {
				$name = $_POST["txtName"];
				$stock = $_POST["txtStock"];
				$unitPrice = $_POST["txtPrice"];
				$description = $_POST["txtDescription"];
				$category = $_POST["CategoryList"];
				$supplier = $_POST["SupplierList"];
				$shop = $_POST["ShopList"];
				$pic = $_FILES["txtImage"];

				$err = "";
				if (trim($name) == "") {
					$err .= "<li>Enter product Name, please</li>";
				}
				if ($category == "0") {
					$err .= "<li>Choose product category, please</li>";
				}
				if ($supplier == "0") {
					$err .= "<li>Choose product supplier, please</li>";
				}
				if ($shop == "0") {
					$err .= "<li>Choose product shop, please</li>";
				}
				if (!is_numeric($unitPrice)) {
					$err .= "<li>Product price must be number</li>";
				}
				if (!is_numeric($stock)) {
					$err .= "<li>Product stock must be number</li>";
				}
				if ($err != "") {
					echo "<ul>$err</ul>";
				} else {
					if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
						if ($pic["size"] > 0) {
							$sq = "SELECT * FROM products WHERE name = '$name'";
							$result = pg_query($Connect, $sq);
							if (pg_num_rows($result) == 0) {
								copy($pic['tmp_name'], "products/" . $pic['name']);
								$filePic = $pic['name'];
								$sqlstring = "INSERT INTO public.products(name, description, stock, unit_price, image, category_id, supplier_id, shop_id, created_at) VALUES ('$name', '$description', '$stock', '$unitPrice', '$filePic', '$category', '$supplier', '$shop', '" . date('Y-m-d H:i:s') . "');";
								pg_query($Connect, $sqlstring);
								echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
							} else {
								echo "<li>Duplicate category ID or Name</li>";
							}
						} else {
							echo "Size of image too big";
						}
					} else {
						echo "Image format is not correct";
					}
				}
			}
			?>
			<h2>Adding new Product</h2>
			<form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal" role="form">
				<div class="form-inputs my-3">
					<label for="txtName" class="col-sm-2 control-label">Product Name(*): </label>
					<div class="col-sm-10">
						<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name" value='' />
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="" class="col-sm-2 control-label">Product category(*): </label>
					<div class="col-sm-10">
						<?php
						bind_Category_List($Connect);
						?>
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="" class="col-sm-2 control-label">Product supplier(*): </label>
					<div class="col-sm-10">
						<?php
						bind_Supplier_List($Connect);
						?>
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="" class="col-sm-2 control-label">Product shop(*): </label>
					<div class="col-sm-10">
						<?php
						bind_Shop_List($Connect);
						?>
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="txtStock" class="col-sm-2 control-label">Stock(*): </label>
					<div class="col-sm-10">
						<input type="number" name="txtStock" id="txtStock" class="form-control" placeholder="Stock" value="" />
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="txtPrice" class="col-sm-2 control-label">Unit Price(*): </label>
					<div class="col-sm-10">
						<input type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Unit Price" value='' />
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="txtDescription" class="col-sm-2 control-label">Description(*): </label>
					<div class="col-sm-10">
						<textarea name="txtDescription" rows="4" class="form-control"></textarea>
					</div>
				</div>

				<div class="form-inputs my-3">
					<label for="txtImage" class="col-sm-2 control-label">Image(*): </label>
					<div class="col-sm-10">
						<input type="file" name="txtImage" id="txtImage" class="form-control" value="" />
					</div>
				</div>

				<div class="form-inputs my-3">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
						<input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='Product_Management.php'" />

					</div>
				</div>
			</form>
		</div>
<?php
	}
}
?>