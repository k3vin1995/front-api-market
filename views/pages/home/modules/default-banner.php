        <!--=====================================
        Home Promotions
        ======================================-->  

        <?php 
        /*=============================================
        =         traer 2 productos aletoreos       =
        =============================================*/
      

        $productsDefaultBanner = array_slice($productsHSlider, 0, 2);


         ?>

        <div class="ps-promotions">

            <div class="container">

                <div class="row">

                    <?php foreach ($productsDefaultBanner as $key => $value): ?>

                    <div class="col-md-6 col-12 ">
                        <a class="ps-collection" href="<?php echo $path.$value->url_product ?>">
                            <img src="img/products/<?php echo $value->url_category ?>/default/<?php echo $value->default_banner_product ?>" alt="<?php echo $value->name_product ?>">
                        </a>
                    </div>

                <?php endforeach; ?>

                </div>

            </div>

        </div><!-- End Home Promotions-->