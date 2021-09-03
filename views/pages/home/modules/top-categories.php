  <?php 
  $url = CurlController::api()."categories?orderBy=views_category&orderMode=DESC&startAt=0&and=6";
  $method ="GET";
  $fields = array();
  $header = array();

  $topCategories = CurlController::request($url, $method, $fields, $header)->results;
  

   ?>

  <div class="ps-top-categories">

            <div class="container">

                <h3>Top categories of the month</h3>

                <div class="row">

                    <?php foreach ($topCategories as $key => $value): ?>

                        <div class="col-xl-2 col-lg-3 col-sm-4 col-6 ">
                            <div class="ps-block--category">
                                <a class="ps-block__overlay" href="<?php echo $path.$value->url_category ?>"></a>
                                <img src="img/categories/<?php echo $value->image_category ?>" alt="<?php echo $value->name_category ?>">
                                <p><?php echo $value->name_category ?></p>
                            </div>
                        </div>


                    <?php endforeach ?>

                </div>
            </div>

        </div><!-- End Top Categories -->