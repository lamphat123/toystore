<?php
session_start();
include_once("Connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Micheal Tran</title>

  <!-- Boostrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">

  <!-- Css -->
  <link rel="stylesheet" type="text/css" href="css/salomon.css" />
  <link rel="stylesheet" href="css/responsive.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    * {
      font-family: "Quicksand", sans-serif;
    }
  </style>
</head>

<body>
  <header class="d-flex flex-wrap justify-content-between py-4" style="background-color: #E0E0E0;">
    <div class="col-12 col-md-3">
      <div class="d-flex justify-content-center">
        <a class="navbar-brand mt-2" href="index.php">
          <h5>Micheal Tran</h5>
        </a>
      </div>
    </div>
    <div class="col-12 col-md-auto">
      <ul class="nav justify-content-center align-items-center mt-2 mt-lg-0 mt-md-0">
        <li><a href="index.php" class="nav-link px-2 link-dark text-uppercase fw-bold">Home</a></li>
        <li><a href="?page=shop" class="nav-link px-lg-4 px-sm-3 link-dark text-uppercase fw-bold">Shop</a></li>
      </ul>
    </div>
    <div class="col-12 col-md-3">
      <?php
      if (isset($_SESSION['email'])) {
      ?>
        <div class="nav navbar navbar-expand-md d-flex justify-content-center ps-lg-5 ps-xl-5">
          <!-- Avatar -->
          <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-reset" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle" style="color: black;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="">Hi, <?php echo $_SESSION['email'] ?></a>
              </li>
              <?php
              if ($_SESSION['admin']) {
              ?>
                <li>
                  <a class="dropdown-item" href="?page=category_management">Category Management</a>
                </li>
                <li>
                  <a class="dropdown-item" href="?page=supplier_management">Supplier Management</a>
                </li>
                <li>
                  <a class="dropdown-item" href="?page=shop_management">Shop Management</a>
                </li>
                <li>
                  <a class="dropdown-item" href="?page=product_management">Product Management</a>
                </li>
              <?php
              }
              ?>
              <div class="dropdown-divider"></div>
              <li>
                <a class="dropdown-item" href="?page=logout" onclick="return confirm('Are you sure to logout?')">Log out</a>
              </li>
            </ul>
          </div>

        </div>
      <?php
      } else {
      ?>
        <div class="mt-2 mt-lg-0 mt-md-0">
          <div class="d-flex justify-content-center">
            <a href="?page=login" class="btn btn-outline-primary me-2" class="btn btn-outline-primary" role="button">
              Login
            </a>
            <a href="?page=register" class="btn btn-primary" class="btn btn-outline-primary" role="button">
              Sign-up
            </a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </header>
  <?php
  if (isset(($_GET['page']))) {
    $page = $_GET['page'];
    if ($page == "register") {
      include_once("Register.php");
    } elseif ($page == "login") {
      include_once("Login.php");
    } elseif ($page == "category_management") {
      include_once("Category_Management.php");
    } elseif ($page == "product_management") {
      include_once("Product_Management.php");
    } elseif ($page == "add_category") {
      include_once("Add_Category.php");
    } elseif ($page == "update_category") {
      include_once("Update_Category.php");
    } elseif ($page == "logout") {
      include_once("Logout.php");
    } elseif ($page == "add_product") {
      include_once("Add_Product.php");
    } elseif ($page == "update_product") {
      include_once("Update_Product.php");
    } elseif ($page == "update_customer") {
      include_once("Update_customer.php");
    } elseif ($page == "supplier_management") {
      include_once("Supplier_Management.php");
    } elseif ($page == "add_supplier") {
      include_once("Add_Supplier.php");
    } elseif ($page == "update_supplier") {
      include_once("Update_Supplier.php");
    } elseif ($page == "shop_management") {
      include_once("Shop_Management.php");
    } elseif ($page == "add_shop") {
      include_once("Add_Shop.php");
    } elseif ($page == "update_shop") {
      include_once("Update_Shop.php");
    } elseif ($page == "shop") {
      include_once("Shop.php");
    }
  } else {
    include("Content.php");
  }
  ?>
  <footer class="text-center text-white" style="background-color: #f1f1f1;">
    <!-- Grid container -->
    <div class="container pt-4">
      <!-- Section: Social media -->
      <section class="mb-4">
        <!-- Facebook -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-facebook"></i></a>

        <!-- Twitter -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-twitter"></i></a>

        <!-- Google -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-google"></i></a>

        <!-- Instagram -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-instagram"></i></a>

        <!-- Linkedin -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-linkedin"></i></a>
        <!-- Github -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="bi bi-github"></i></a>
      </section>
      <!-- Section: Social media -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright:
      <a class="text-dark" href="https://mdbootstrap.com/">MichealTran.com</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- <script src="bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>