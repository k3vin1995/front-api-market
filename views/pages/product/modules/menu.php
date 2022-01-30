 <!--=====================================
Navegación del Menu 
======================================-->

<?php 

if($item->reviews_product != null){

    $allReviews = json_decode($item->reviews_product,true);

}else{

    $allReviews = array();

} 

?>

<ul class="ps-tab-list">

    <li class="active"><a href="#tab-1">Description</a></li>
    <li><a href="#tab-2">Details</a></li>
    <li><a href="#tab-3">Vendor</a></li>
    <li><a href="#tab-4">Reviews (<?php echo count($allReviews) ?>)</a></li>
    <li><a href="#tab-5">Questions and Answers</a></li>

</ul>

<div class="ps-tabs">

    <!--=====================================
    Descripción
    ======================================-->

    <div class="ps-tab active" id="tab-1">

        <div class="ps-document">

         	<?php echo $item->description_product ?>

        </div>

    </div>

    <!--=====================================
    Detalles
    ======================================-->

    <div class="ps-tab" id="tab-2">

        <div class="table-responsive">

            <table class="table table-bordered ps-table ps-table--specification">

                <tbody>

                	<?php 

                		$details = json_decode($item->details_product, true); 

                	?>

                	<?php foreach ($details as $key => $value): ?>
                	
                		 <tr>
	                        <td><?php echo $value["title"] ?></td>
	                        <td><?php echo $value["value"] ?></td>
	                    </tr>
                		
                	<?php endforeach ?>

                </tbody>

            </table>

        </div>

    </div>

    <!--=====================================
    Vendedor
    ======================================-->

    <div class="ps-tab" id="tab-3">

    	<div class="media">

    	  <img src="img/stores/<?php echo $item->url_store ?>/<?php echo $item->logo_store ?>" 
    	  class="mr-5 mt-1 rounded-circle"
    	   alt="<?php echo $item->name_store ?>"
    	   width="120">

    	  <div class="media-body">

    	    <h4><?php echo $item->name_store ?></h4>
    	    
    	    <p><?php echo $item->abstract_store ?></p>

    	    <a href="<?php echo $path.$item->url_store ?>">More Products from <?php echo $item->name_store ?></a>

    	  </div>

    	</div>
  
    </div>

    <!--=====================================
    Reseñas globales
    ======================================-->

    <div class="ps-tab" id="tab-4">

        <div class="row">

            <div class="col-lg-5 col-12 ">

                <!--=====================================
                Bloque de reseña
                ======================================-->

                <div class="ps-block--average-rating">

                    <div class="ps-block__header">

                        <?php 

                            $reviews = TemplateController::averageReviews(
                                json_decode($item->reviews_product,true)
                            );


                         ?>

                        <h3><?php echo $reviews ?></h3>

                        <select class="ps-rating" data-read-only="true">

                           <?php 

                            if($reviews > 0){

                                for($i = 0; $i < 5; $i++){

                                    if($reviews < ($i+1)){

                                        echo '<option value="1">'.($i+1).'</option>';

                                    }else{

                                         echo '<option value="2">'.($i+1).'</option>';

                                    }

                                }

                            }else{

                                echo '<option value="0">0</option>';

                                for($i = 0; $i < 5; $i++){

                                    echo '<option value="1">'.($i+1).'</option>';

                                }

                            }

                            ?>

                        </select>

                        <span><?php echo count($allReviews) ?> Review's</span>

                    </div>

                    <?php if ($item->reviews_product != null): ?>
                        
                        <?php 

                            if(count($allReviews) > 0){

                                //Creamos una matriz vacía para promediar las estrellas 

                                $blockStart = array(
                                
                                    "1" => 0,
                                    "2" => 0,
                                    "3" => 0,
                                    "4" => 0,
                                    "5" => 0
                                );

                                //Separamos las estrellas repetidas
                                
                                $repStart = array();          

                                foreach ($allReviews as $key => $value){
                                
                                   array_push($repStart, $value["review"]);

                                }

                                //Unimos las estrellas repetidas con la matriz vacía de estrellas

                                foreach ($blockStart as $key => $value) {
                                    
                                    if(!empty(array_count_values($repStart)[$key])){
                                       
                                        $blockStart[$key] = array_count_values($repStart)[$key];
                                     
                                    }
                                } 

                            }

                        ?>
            
                        <!--=====================================
                        Bloque de estrellas
                        ======================================-->

                        <?php for ($i = 5; $i > 0; $i--): ?>

                        <div class="ps-block__star">

                            <span><?php echo $i ?> Star</span>

                            <div class="ps-progress" data-value="<?php echo round($blockStart[$i]*100/count($allReviews)) ?>">

                                <span></span>

                            </div>

                            <span><?php echo round($blockStart[$i]*100/count($allReviews)) ?>%</span>

                        </div>
                            
                        <?php endfor ?> 

                    <?php endif ?>   

                </div>

                <!--=====================================
                Escribir una reseña
                ======================================-->

                <hr class="my-5">

                <form class="ps-form--review">

                    <h4>Submit Your Review</h4>

                    <p>Your email address will not be published. Required fields are marked<sup>*</sup></p>

                    <div class="form-group form-group__rating">

                        <label>Your rating of this product</label>

                        <select class="ps-rating" data-read-only="false">

                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <textarea class="form-control" rows="6" placeholder="Write your review here">
                            
                        </textarea>

                    </div>
                    
                    <div class="form-group submit">

                        <button class="ps-btn">Submit Review</button>

                    </div>

                </form>

            </div>

            <?php if ($item->reviews_product != null): ?>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">

                     <!--=====================================
                    Tomar 4 reseñas aleatoriamente
                    ======================================-->

                    <?php 

                    $rand = array_rand($allReviews, 5);

                    ?>

                    <?php foreach ($rand as $key => $value): ?>
                    
                    <div class="media border p-3 mb-3">

                        <?php if (empty($allReviews[$value]["user"])): ?>

                            <img src="img/users/default/default.png" class="mr-5 mt-1 rounded-circle" width="60">

                        <?php endif ?>
                             
                        <div class="media-body">

                            <select class="ps-rating" data-read-only="true">

                                <?php 

                                if($allReviews[$value]["review"]  > 0){

                                    for($i = 0; $i < 5; $i++){

                                        if($allReviews[$value]["review"] < ($i+1)){

                                            echo '<option value="1">'.($i+1).'</option>';

                                        }else{

                                             echo '<option value="2">'.($i+1).'</option>';

                                        }

                                    }

                                }else{

                                    echo '<option value="0">0</option>';

                                    for($i = 0; $i < 5; $i++){

                                        echo '<option value="1">'.($i+1).'</option>';

                                    }

                                }

                                ?>

                            </select>

                            <?php if (empty($allReviews[$value]["user"])): ?>

                                <h4>Anonimous</h4>

                            <?php endif ?>

                            <p><?php echo $allReviews[$value]["comment"] ?></p>

                        </div>

                    </div>
                        
                    <?php endforeach ?> 

                </div>

            <?php endif ?>  

        </div>

    </div>

    <!--=====================================
    Preguntas y respuestas
    ======================================-->

    <div class="ps-tab" id="tab-5">

        <div class="ps-block--questions-answers">

            <h3>Questions and Answers</h3>

            <div class="form-group">

                <input class="form-control" type="text" placeholder="Have a question? Search for answer?">
            
            </div>

        </div>

    </div>

    <div class="ps-tab active" id="tab-6">

        <p>Sorry no more offers available</p>

    </div>

</div>