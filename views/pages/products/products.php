<?php 

/*=============================================
Validar si hay parámetros de paginación
=============================================*/
if(isset($urlParams[1])){

  if(is_numeric($urlParams[1])){


    $startAt = ($urlParams[1]*6) - 6;

  }else{

    echo '<script>

      window.location = "'.$path.$urlParams[0].'";

        </script>';

  }

}else{

  $startAt = 0;
}

/*=============================================
Validar si hay parámetros de orden
=============================================*/

if(isset($urlParams[2])){

  if(is_string($urlParams[2])){

    if($urlParams[2] == "new"){

      $orderBy = "id_product";
      $orderMode = "DESC";

    }

    else if($urlParams[2] == "latest"){

      $orderBy = "id_product";
      $orderMode = "ASC";

    }

    else if($urlParams[2] == "low"){

      $orderBy = "price_product";
      $orderMode = "ASC";

    }

    else if($urlParams[2] == "high"){

      $orderBy = "price_product";
      $orderMode = "DESC";

    }else{

      echo '<script>

          window.location = "'.$path.$urlParams[0].'";

          </script>'; 

    }

  }else{

      echo '<script>

        window.location = "'.$path.$urlParams[0].'";

        </script>';

  }

}else{

  $orderBy = "id_product";
  $orderMode = "DESC";
}


/*=============================================
Traemos los productos recién agregados a la categoría
 =============================================*/

$url = CurlController::api()."relations?rel=products,categories,stores&type=product,category,store&linkTo=url_category&equalTo=".$urlParams[0]."&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=6";
$method = "GET";
$fields = array();
$header = array();

$showcaseProducts = CurlController::request($url, $method, $fields, $header)->results;

if($showcaseProducts == "NOT FOUND"){

  /*=============================================
  Traemos los productos recién agregados a la subcategoría
  =============================================*/

  $url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=url_subcategory&equalTo=".$urlParams[0]."&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=6";
  $method = "GET";
  $fields = array();
  $header = array();

  $showcaseProducts = CurlController::request($url, $method, $fields, $header)->results;

  /*=============================================
    Traer el total de productos de subcategorías
    =============================================*/

    $url = CurlController::api()."relations?rel=products,subcategories,stores&type=product,subcategory,store&linkTo=url_subcategory&equalTo=".$urlParams[0];
  $method = "GET";
  $fields = array();
  $header = array();

  $totalProducts = CurlController::request($url, $method, $fields, $header)->total;

  /*=============================================
    Actualizar las vistas de subcategorías
    =============================================*/

    $view = $showcaseProducts[0]->views_subcategory+1;
    $id_subcat = $showcaseProducts[0]->id_subcategory_product;

  $url = CurlController::api()."subcategories?id=".$id_subcat."&nameId=id_subcategory";
  $method = "PUT";
  $fields =  "views_subcategory=".$view;
  $header = array();

  $updateViewsSubCategory = CurlController::request($url, $method, $fields, $header);

}else{

  /*=============================================
    Traer el total de productos de categorías
    =============================================*/

    $url = CurlController::api()."relations?rel=products,categories,stores&type=product,category,store&linkTo=url_category&equalTo=".$urlParams[0];
  $method = "GET";
  $fields = array();
  $header = array();

  $totalProducts = CurlController::request($url, $method, $fields, $header)->total;

  /*=============================================
    Actualizar las vistas de categorías
    =============================================*/

    $view = $showcaseProducts[0]->views_category+1;
    $id_cat = $showcaseProducts[0]->id_category_product;

  $url = CurlController::api()."categories?id=".$id_cat."&nameId=id_category";
  $method = "PUT";
  $fields =  "views_category=".$view;
  $header = array();

  $updateViewsCategory = CurlController::request($url, $method, $fields, $header);

}

/*=============================================
Traemos los productos más vendidos de esta categoría
 =============================================*/

$url = CurlController::api()."relations?rel=products,categories,stores&type=product,category,store&linkTo=url_category&equalTo=".$urlParams[0]."&orderBy=sales_product&orderMode=DESC&startAt=".$startAt."&endAt=6";
$method = "GET";
$fields = array();
$header = array();

$bestSalesItems = CurlController::request($url, $method, $fields, $header)->results;

if($bestSalesItems == "NOT FOUND"){

  /*=============================================
  Traemos los productos más vendidos de esta subcategoría
   =============================================*/

  $url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=url_subcategory&equalTo=".$urlParams[0]."&orderBy=sales_product&orderMode=DESC&startAt=".$startAt."&endAt=6";
  $method = "GET";
  $fields = array();
  $header = array();

  $bestSalesItems = CurlController::request($url, $method, $fields, $header)->results;

}

/*=============================================
Traemos los productos más vistos de esta categoría
 =============================================*/

$url = CurlController::api()."relations?rel=products,categories,stores&type=product,category,store&linkTo=url_category&equalTo=".$urlParams[0]."&orderBy=views_product&orderMode=DESC&startAt=".$startAt."&endAt=6";
$method = "GET";
$fields = array();
$header = array();

$recommendedItems = CurlController::request($url, $method, $fields, $header)->results;

if($recommendedItems == "NOT FOUND"){

  /*=============================================
  Traemos los productos más vistos de esta subcategoría
   =============================================*/

  $url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=url_subcategory&equalTo=".$urlParams[0]."&orderBy=views_product&orderMode=DESC&startAt=".$startAt."&endAt=6";
  $method = "GET";
  $fields = array();
  $header = array();

  $recommendedItems = CurlController::request($url, $method, $fields, $header)->results;

}


?>


<!--=====================================
Breadcrumb
======================================-->  

<?php include "modules/breadcrumb.php" ?>

<!--=====================================
Categories Content
======================================--> 

<div class="container-fuid bg-white my-4">

    <div class="container">

      <!--=====================================
    Layout Categories
    ======================================--> 

      <div class="ps-layout--shop">
        
          <section>

            <!--=====================================
        Best Sale Items
        ======================================--> 

                <?php include "modules/best-sales-items.php" ?>

                <!--=====================================
        Recommended Items
        ======================================--> 

                <?php include "modules/recommended-items.php" ?>

                <!--=====================================
        Products found
        ======================================--> 
        
        <?php include "modules/showcase.php" ?>

            </section>

        </div><!-- End Layout Categories -->

  </div><!-- End Container -->

</div><!-- End Container Fluid -->