<?php
include_once("Connection.php");
function bind_Category_List($Connect, $selectValue)
{
	$sqlstring = "SELECT id, name from categories";
	$result = pg_query($Connect, $sqlstring);
	echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
	while ($row = pg_fetch_assoc($result)) {
		if ($row['id'] == $selectValue) {
			echo "<option value='" . $row['id'] . "' selected>" . $row['name'] . "</option>";
		} else {
			echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
		}
	}
	echo "</select>";
}
function bind_Supplier_List($Connect, $selectValue)
{
	$sqlstring = "SELECT id, name from suppliers";
	$result = pg_query($Connect, $sqlstring);
	echo "<select name='SupplierList' class='form-control'>
					<option value='0'>Choose supplier</option>";
	while ($row = pg_fetch_assoc($result)) {
		if ($row['id'] == $selectValue) {
			echo "<option value='" . $row['id'] . "' selected>" . $row['name'] . "</option>";
		} else {
			echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
		}
	}
	echo "</select>";
}
function bind_Shop_List($Connect, $selectValue)
{
	$sqlstring = "SELECT id, name from shops";
	$result = pg_query($Connect, $sqlstring);
	echo "<select name='ShopList' class='form-control'>
					<option value='0'>Choose shop</option>";
	while ($row = pg_fetch_assoc($result)) {
		if ($row['id'] == $selectValue) {
			echo "<option value='" . $row['id'] . "' selected>" . $row['name'] . "</option>";
		} else {
			echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
		}
	}
	echo "</select>";
}
if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$sqlstring = "SELECT * FROM products WHERE id = '$id'";
	$result = pg_query($Connect, $sqlstring);
	$row = pg_fetch_assoc($result);

	$id = $row["id"];
	$name = $row["name"];
	$description = $row["description"];
	$price = $row["unit_price"];
	$stock = $row["stock"];
	$pic = $row["image"];
	$category = $row["category_id"];
	$supplier = $row["supplier_id"];
	$shop = $row["shop_id"];
?>
	<div class="container my-3">
		<?php
		if (isset($_POST["btnUpdate"])) {
			$id = $_POST["txtID"];
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
				if ($pic['name'] != "") {
					if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
						if ($pic["size"] < 614400) {
							$sql = "SELECT * FROM products p WHERE p.name = '$name' AND p.id != '$id'";
							$result = pg_query($Connect, $sql);
							if (pg_num_rows($result) == 0) {
								// Unlink old image
								$oldPic = $_POST["txtOldPic"];
								unlink("products/" . $oldPic);

								copy($pic['tmp_name'], "products/" . $pic['name']);
								$filePic = $pic['name'];
								$sqlstring = "UPDATE public.products
												SET name='$name', description='$description', stock='$stock', unit_price='$unitPrice', image='$filePic', category_id='$category', supplier_id='$supplier', shop_id='$shop'
												WHERE id='$id';";
								pg_query($Connect, $sqlstring);
								echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
							} else {
								echo "<li>Duplicate product ID or Name</li>";
							}
						} else {
							echo "Size of image too big";
						}
					} else {
						echo "Image format is not correct";
					}
				} else {
					$sql = "SELECT * FROM products p WHERE p.name = '$name' AND p.id != '$id'";
					$result = pg_query($Connect, $sql);
					if (pg_num_rows($result) == 0) {
						$sqlstring = "UPDATE public.products
										SET name='$name', description='$description', stock='$stock', unit_price='$unitPrice', category_id='$category', supplier_id='$supplier', shop_id='$shop'
										WHERE id='$id';";
						pg_query($Connect, $sqlstring);
						echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
					} else {
						echo "<li>Duplicate product ID or Name</li>";
					}
				}
			}
		}
		?>
		<h2>Updating Product</h2>
		<form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal" role="form">
			<input type="hidden" name="txtID" value="<?php echo $id; ?>">
			<div class="form-inputs mt-3">
				<label for="txtName" class="col-sm-2 control-label">Product Name(*): </label>
				<div class="col-sm-10">
					<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name" value='<?php echo $name; ?>' />
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="" class="col-sm-2 control-label">Product category(*): </label>
				<div class="col-sm-10">
					<?php
					bind_Category_List($Connect, $category);
					?>
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="" class="col-sm-2 control-label">Product supplier(*): </label>
				<div class="col-sm-10">
					<?php
					bind_Supplier_List($Connect, $supplier);
					?>
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="" class="col-sm-2 control-label">Product shop(*): </label>
				<div class="col-sm-10">
					<?php
					bind_Shop_List($Connect, $shop);
					?>
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="txtStock" class="col-sm-2 control-label">Stock(*): </label>
				<div class="col-sm-10">
					<input type="number" name="txtStock" id="txtStock" class="form-control" placeholder="Stock" value="<?php echo $stock; ?>" />
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="txtPrice" class="col-sm-2 control-label">Unit Price(*): </label>
				<div class="col-sm-10">
					<input type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Unit Price" value='<?php echo $price; ?>' />
				</div>
			</div>

			<div class="form-inputs mt-3">
				<label for="txtDescription" class="col-sm-2 control-label">Description(*): </label>
				<div class="col-sm-10">
					<textarea name="txtDescription" rows="4" class="form-control"><?php echo $description; ?></textarea>
				</div>
			</div>

			<div class="form-group mt-3">
				<label for="sphinhanh" class="col-sm-2 control-label">Image(*): </label>
				<div class="col-sm-10">
					<img src='products/<?php echo $pic; ?>' border='0' width="50" />
					<input type="hidden" name="txtOldPic" value="<?php echo $pic; ?>">
					<input type="file" name="txtImage" id="txtImage" class="form-control mt-3" value="" />
				</div>
			</div>

			<div class="form-group mt-3">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
					<input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=product_management'" />

				</div>
			</div>
		</form>
	</div>

<?php
} else {
	echo '<meta http-equiv="refresh" content = "0; URL=?page=product_management"/>';
}
?>