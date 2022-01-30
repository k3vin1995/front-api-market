<?php 

/*=============================================
Traer toda la información del producto
=============================================*/

$url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=url_product&equalTo=".$urlParams[0];
$method = "GET";
$fields = array();
$header = array();

$item = CurlController::request($url, $method, $fields, $header)->results[0];

/*=============================================
Actualizar las vistas de producto
=============================================*/

$view = $item->views_product+1;

$url = CurlController::api()."products?id=1&nameId=id_product";
$method = "PUT";
$fields =  "views_product=".$view;
$header = array();

$updateViewsProduct = CurlController::request($url, $method, $fields, $header);


?>


<!--=====================================
Call to Action
======================================-->

<?php include "modules/call-to-action.php" ?>

<!--=====================================
Breadcrumb
======================================-->  

<?php include "modules/breadcrumb.php" ?>

<!--=====================================
Product Content
======================================--> 

<div class="ps-page--product">

    <div class="ps-container">

      <!--=====================================
    Product Container
    ======================================--> 

        <div class="ps-page__container">

        <!--=====================================
      Left Column
      ======================================--> 

            <div class="ps-page__left">

                <div class="ps-product--detail ps-product--fullwidth">

                  <!--=====================================
          Product Header
          ======================================--> 

                    <div class="ps-product__header">

                      <!--=====================================
            Gallery
            ======================================--> 

                        <?php Include "modules/gallery.php" ?>

                        <!--=====================================
            Product Info
            ======================================--> 

                        <?php include "modules/product-info.php" ?>

                    </div> <!-- End Product header -->

                  <!--=====================================
          Product Content
          ======================================--> 
          
          <div class="ps-product__content ps-tab-root">

            <!--=====================================
            Bought Together
            ======================================--> 

              <?php include "modules/bought-together.php" ?>

              <!--=====================================
            Menu
            ======================================--> 
            
            <?php include "modules/menu.php" ?>        

          </div><!--  End product content -->
                
                </div>

            </div><!-- End Left Column -->

            <!--=====================================
          Right Column
          ======================================--> 

          <?php include "modules/right-column.php" ?>

            </div><!--  End Product Container -->

        <!--=====================================
        Customers who bought
        ======================================--> 

        <?php //include "modules/customers-bought.php" ?>

            <!--=====================================
        Related products
        ======================================--> 

          <?php include "modules/related-product.php" ?>
        </div>

</div><!-- End Product Content -->