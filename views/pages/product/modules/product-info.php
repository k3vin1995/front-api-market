<div class="ps-product__info">

    <h1> <?php echo $item->name_product ?></h1>

    <div class="ps-product__meta">

        <!--=====================================
        Las reseñas del producto
        ======================================-->  

        <div class="ps-product__rating">

            <?php 

                $reviews = TemplateController::averageReviews(                                        
                    json_decode($item->reviews_product,true)
                );
              
            ?>

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

            <span>(<?php 

                if($item->reviews_product != null){

                     echo count(json_decode($item->reviews_product,true));

                }else{

                    echo 0;
                }

            ?>)</span>

        </div>

    </div>

    <!--=====================================
    El precio en oferta del producto
    ======================================-->   
    
    <?php if ($item->offer_product != null): ?>

        <h4 class="ps-product__price sale">
        
            <?php 
                echo "$".TemplateController::offerPrice(

                    $item->price_product, 
                    json_decode($item->offer_product,true)[1], 
                    json_decode($item->offer_product,true)[0] 

                );

            ?>

            <del> $<?php echo $item->price_product ?></del>

        </h4>

    <?php else: ?>

        <h4 class="ps-product__price"><?php echo "$".$item->price_product ?></h4>

     <?php endif ?>

    <div class="ps-product__desc">

        <p> 

            <!--=====================================
            Nombre de la tienda
            ======================================-->   

        	Sold By:<a class="mr-20" href="<?php echo $path.$item->url_store ?>"><strong> <?php echo $item->name_store ?></strong></a> 

            <!--=====================================
            Preguntar si el producto tiene Stock
            ======================================-->   

            <?php if ($item->stock_product == 0): ?>

                Status:<strong class="ps-tag--out-stock"> Out of stock</strong>

            <?php else: ?>

                Status:<a href=""><strong class="ps-tag--in-stock"> In stock</strong></a>
                
            <?php endif ?>

        </p>

        <!--=====================================
        Resumen del producto
        ======================================-->   

        <ul class="ps-list--dot">

            <?php 

            $summary = json_decode($item->summary_product,true);        

            ?>

            <?php foreach ($summary as $key => $value): ?>

                 <li> <?php echo $value ?></li>
                
            <?php endforeach ?>

        </ul>

        <!--=====================================
        Video del producto
        ======================================-->   

        <?php if ($item->video_product != null): ?>

            <?php 

            $video = json_decode($item->video_product,true); 

            ?>

            <?php if ( $video[0] == "youtube"): ?>

                <iframe 
                class="mb-3"
                src="https://www.youtube.com/embed/<?php echo $video[1] ?>?rel=0&autoplay=0"
                height="360" 
                frameborder="0"
                allowfullscreen></iframe>

            <?php else: ?>

                <iframe 
                class="mb-3"
                src="https://player.vimeo.com/video/<?php echo $video[1] ?>"
                height="360" 
                frameborder="0"
                allowfullscreen></iframe>
                
            <?php endif ?>
            
        <?php endif ?>

    </div>

    <div class="ps-product__variations">

        <!--=====================================
        Especificaciones del producto
        ======================================--> 

        <?php 

            $spec = json_decode($item->specifications_product, true);

        ?>

        <?php foreach ($spec as $key => $value): ?>
      
            <?php if (!empty(array_keys($value)[0])): ?>
 
                <figure>

                    <figcaption><?php echo array_keys($value)[0] ?> <strong> Choose an option</strong></figcaption>

                </figure>

            <?php endif ?>

            <?php foreach ($value as $key => $i): ?>
                
                <?php foreach ($i as $key => $v): ?>
  
                    <?php if (array_keys($value)[0] == "Color"): ?>

                        <div class="ps-variant round-circle mr-3"
                             style="background-color: <?php echo $v ?>; 
                                    width:30px; 
                                    height:30px; 
                                    cursor:pointer; 
                                    border:1px solid #bbb">
                            <span class="ps-variant__tooltip"><?php echo $v ?></span>             
                        </div>

                    <?php else: ?>

                        <div class="ps-variant ps-variant--size">
                            <span class="ps-variant__tooltip"><?php echo $v ?></span>
                            <span class="ps-variant__size"><?php echo substr($v,0,3) ?></span>
                        </div>
                                
                    <?php endif ?>
                    
                <?php endforeach ?>

            <?php endforeach ?>
       
        <?php endforeach ?>

    </div>

    <!--=====================================
    Validar ofertas del producto
    ======================================--> 

    <?php 

    $today = date("Y-m-d");

    if ($item->offer_product != null && $item->stock_product != 0 && $today < date(json_decode($item->offer_product, true)[2])): ?>
        
    <div class="ps-product__countdown">

        <figure>

            <figcaption> Don't Miss Out! This promotion will expires in</figcaption>

            <ul class="ps-countdown" data-time="<?php echo json_decode($item->offer_product, true)[2] ?>">

                <li><span class="days"></span>
                    <p>Days</p>
                </li>

                <li><span class="hours"></span>
                    <p>Hours</p>
                </li>

                <li><span class="minutes"></span>
                    <p>Minutes</p>
                </li>

                <li><span class="seconds"></span>
                    <p>Seconds</p>
                </li>

            </ul>

        </figure>

        <figure>

            <figcaption>Sold Items</figcaption>

            <div class="ps-product__progress-bar ps-progress" data-value="<?php echo $item->stock_product ?>">

                <div class="ps-progress__value"><span></span></div>

                <p><b><?php echo $item->stock_product ?>/100</b> Sold</p>

            </div>

        </figure>

    </div>

    <?php endif ?>

    <div class="ps-product__shopping">

        <!--=====================================
        Controles para modificar la cantidad de compra del producto
        ======================================--> 

        <figure>

            <figcaption>Quantity</figcaption>

            <div class="form-group--number quantity">

                <button class="up" onclick="changeQuantity($('.quantity input').val(), 'up', <?php echo $item->stock_product ?>)">
                	<i class="fa fa-plus"></i>
                </button>

                <button class="down" onclick="changeQuantity($('.quantity input').val(),  'down', <?php echo $item->stock_product ?>)">
                	<i class="fa fa-minus"></i>
                </button>

                <input class="form-control" type="text" value="1" readonly>

            </div>

        </figure>

        <a class="ps-btn ps-btn--black" href="#">Add to cart</a>

        <a class="ps-btn" href="#">Buy Now</a>

        <div class="ps-product__actions">

        	<a href="#">
        		<i class="icon-heart"></i>
        	</a>

        </div>

    </div>

    <div class="ps-product__specification">

    	<a class="report" href="#">Report Abuse</a>

        <p><strong>SKU:</strong> SF1133569600-1</p>

        <p class="categories">

        	<strong> Categories:</strong>

        	<a href="<?php echo $path.$item->url_category ?>"><?php echo $item->name_category ?></a>,
            <a href="<?php echo $path.$item->url_subcategory ?>"><?php echo $item->name_subcategory ?></a>,
            <a href="<?php echo $path.$item->title_list_product ?>"><?php echo $item->title_list_product ?></a>

        </p>

        <p class="tags"><strong> Tags</strong>

         <?php 

            $tags = json_decode($item->tags_product, true);

            ?>

            <?php foreach ($tags as $key => $value): ?>

        	<a href="<?php echo $path.$value ?>"><?php echo $value ?></a>

            <?php endforeach ?> 
        </p>

    </div>

    <div class="ps-product__sharing">

    	<a class="facebook" href="#">
    		<i class="fab fa-facebook"></i>
    	</a>

    	<a class="twitter" href="#">
    		<i class="fab fa-twitter"></i>
    	</a>


    	<a class="linkedin" href="#">
    		<i class="fab fa-linkedin"></i>
    	</a>

    	<a class="instagram" href="#">
    		<i class="fab fa-instagram"></i>
    	</a>

    </div>

</div> <!-- End Product Info -->