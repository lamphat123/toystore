<style>
  .mt-50 {

    margin-top: 50px;
  }

  .mb-50 {

    margin-bottom: 50px;
  }

  .card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: .1875rem;
  }

  .card-img-actions {
    position: relative;
  }

  .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
    text-align: center;
  }

  .card-img {

    width: 350px;
  }

  .star {
    color: red;
  }

  .bg-cart {
    background-color: orange;
    color: #fff;
  }

  .bg-cart:hover {
    color: #fff;
    background-color: orange;
  }

  .bg-buy {
    background-color: green;
    color: #fff;
    padding-right: 29px;
  }

  .bg-buy:hover {
    color: #fff;
  }

  a {
    text-decoration: none !important;
  }
</style>
<div class="slider-area">
  <div class="container block-slider block-slider4">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="image/1.jpg" class="d-block w-100" alt="..." width="300">
        </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</div>

<div class="container mt-50 mb-50">

  <div class="row">
    <?php
    $result = pg_query($Connect, "SELECT * FROM products LIMIT 3");
    if (!$result) { //add this check.
      die('Invalid query: ' . pg_last_error($Connect));
    }
    while ($row = pg_fetch_assoc($result)) {
    ?>
      <div class="col-md-4 mt-2">
        <div class="card">
          <div class="card-body">
            <div class="card-img-actions">
              <img src="products/<?php echo $row['image'] ?>" class="card-img img-fluid" width="200" height="200" alt="">
            </div>
          </div>
          <div class="card-body bg-light text-center">
            <div class="mb-2">
              <h6 class="font-weight-semibold mb-2">
                <a href="#" class="text-default mb-2" data-abc="true"><?php echo  $row['name'] ?></a>
              </h6>
              <p class="text-muted" data-abc="true"><?php echo  $row['description'] ?></p>
            </div>
            <h3 class="mb-0 font-weight-semibold">$<?php echo  $row['unit_price'] ?></h3>
            <button type="button" class="btn bg-cart mt-3"><i class="fa fa-cart-plus"></i> Add to cart</button>
          </div>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>