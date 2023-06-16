<style>
    body {
        color: #444444;
    }

    a,
    a:hover {
        text-decoration: none;
        color: inherit;
    }

    .section-products {
        padding: 80px 0 54px;
    }

    .section-products .header {
        margin-bottom: 50px;
    }

    .section-products .header h3 {
        font-size: 1rem;
        color: #fe302f;
        font-weight: 500;
    }

    .section-products .header h2 {
        font-size: 2.2rem;
        font-weight: 400;
        color: #444444;
    }

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
<section class="section-products">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8 col-lg-6">
                <div class="header">
                    <h3>Featured Product</h3>
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $result = pg_query($Connect, "SELECT * FROM products");
            if (!$result) { //add this check.
                die('Invalid query: ' . pg_last_error($Connect));
            }
            while ($row = pg_fetch_assoc($result)) {
            ?>
                <div class="col-md-3 mt-2">
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
</section>