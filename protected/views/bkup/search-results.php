<?php 
$search_address=$_GET['s'];
if (isset($_GET['st'])){
	$search_address=$_GET['st'];
}
$this->renderPartial('/front/search-header',array(
   'search_address'=>$search_address,
   'total'=>$data['total']
));?>

<?php 
$this->renderPartial('/front/order-progress-bar',array(
   'step'=>2,
   'show_bar'=>true
));
?>

<div class="sections section-search-results">
  <div class="container">

   <div class="row">
   
     <div class="col-md-3 border search-left-content">
        <a href="javascript:;" class="search-view-map green-button block center upper rounded">
        <?php echo t("View by map")?>
        </a>
        
        <div class="filter-wrap rounded2">
           <p class="bold"><?php echo t("Filters")?></p>
           
           <!--FILTER DELIVERY FEE-->
           <div class="filter-box">
	           <a href="javascript:;">	             
	             <span>
	             <i class="ion-ios-arrow-thin-right"></i>
	             <?php echo t("Delivery Fee")?>
	             </span>   
	             <b></b>
	           </a>
	           <ul>
	              <li>
	              <?php 
		          echo CHtml::checkBox('filter_by[]',false,array(
		          'value'=>'free-delivery',
		          'class'=>"filter_by filter_promo icheck"
		          ));
		          ?>
	              <?php echo t("Free Delivery")?>
	              </li>
	           </ul>
           </div> <!--filter-box-->
           <!--END FILTER DELIVERY FEE-->
           
           <!--FILTER DELIVERY -->
           <?php if ( $services=Yii::app()->functions->Services() ):?>
           <div class="filter-box">
	           <a href="javascript:;">	             
	             <span>
	             <i class="ion-ios-arrow-thin-right"></i>
	             <?php echo t("By Delivery")?>
	             </span>   
	             <b></b>
	           </a>
	           <ul>
	             <?php foreach ($services as $key=> $val):?>
	              <li>	           	              
	              <?php 
		           echo CHtml::checkBox('filter_delivery_type[]',false,array(
		          'value'=>$key,
		          'class'=>"filter_by filter_delivery_type icheck"
		          ));
		          ?>
		          <?php echo $val;?>   
	              </li>
	             <?php endforeach;?> 
	           </ul>
           </div> <!--filter-box-->
           <?php endif;?>
           <!--END FILTER DELIVERY -->
           
           <!--FILTER CUISINE-->
           <?php if ( $cuisine=Yii::app()->functions->Cuisine(false)):?>
           <div class="filter-box">
	           <a href="javascript:;">	             
	             <span>
	             <i class="ion-ios-arrow-thin-right"></i>
	             <?php echo t("By Cuisines")?>
	             </span>   
	             <b></b>
	           </a>
	           <ul>
	             <?php foreach ($cuisine as $val): ?>
	              <li>
		           <?php 
		          echo CHtml::checkBox('filter_cuisine[]',false,array(
		          'value'=>$val['cuisine_id'],
		          'class'=>"filter_by icheck filter_cuisine"
		          ));
		          ?>
	              <?php echo $val['cuisine_name']?>
	              </li>
	             <?php endforeach;?> 
	           </ul>
           </div> <!--filter-box-->
           <?php endif;?>
           <!--END FILTER CUISINE-->
           
           
           <!--MINIUM DELIVERY FEE-->
           <?php if ( $minimum_list=FunctionsV3::minimumDeliveryFee()):?>
           <div class="filter-box">
	           <a href="javascript:;">	             
	             <span>
	             <i class="ion-ios-arrow-thin-right"></i>
	             <?php echo t("Minimum Delivery")?>
	             </span>   
	             <b></b>
	           </a>
	           <ul>
	             <?php foreach ($minimum_list as $key=>$val):?>
	              <li>
		           <?php 
		          echo CHtml::radioButton('filter_minimum[]',false,array(
		          'value'=>$key,
		          'class'=>"filter_by_radio filter_minimum icheck"
		          ));
		          ?>
	              <?php echo $val;?>
	              </li>
	             <?php endforeach;?> 
	           </ul>
           </div> <!--filter-box-->
           <?php endif;?>
           <!--END MINIUM DELIVERY FEE-->
           
        </div> <!--filter-wrap-->
        
     </div> <!--col search-left-content-->
     
     <div class="col-md-9 border search-right-content">
     
     <?php echo CHtml::hiddenField('sort_filter','')?>
     <?php echo CHtml::hiddenField('display_type','gridview')?>
     
         <div class="sort-wrap">
           <div class="row">           
              <div class="col-md-6 ">
	           <select id="sort-results" class="sort-results selectpicker" title="<?php echo t("Sort By")?>" >
	              <option value="restaurant_name"><?php echo t("Name")?></option>
	              <option value="ratings"><?php echo t("Rating")?></option>
	              <option value="minimum_order"><?php echo t("Minimum")?></option>
	              <option value="distance"><?php echo t("Distance")?></option>
	           </select>
              </div> <!--col-->
              <div class="col-md-6 ">                
               
                <a href="javascript:;" class="display-type orange-button block center rounded inactive" 
		          data-type="listview">
                <i class="fa fa-th-list"></i>
                </a>
                
                <a href="javascript:;" class="display-type orange-button block center rounded mr10px" 
		          data-type="gridview">
                <i class="fa fa-th-large"></i>
                </a>                
                
              </div>
           </div> <!--row-->
         </div>  <!--sort-wrap-->  
         
         
         <!--MERCHANT LIST -->
                  
         <div class="result-merchant">
             <div class="row infinite-container">
             
             <?php foreach ($data['list'] as $val):?>
             <?php 
             $merchant_id=$val['merchant_id'];             
             $ratings=Yii::app()->functions->getRatings($merchant_id);   
             
             /*get the distance from client address to merchant Address*/             
             $distance_type=FunctionsV3::getMerchantDistanceType($merchant_id); 
                        
             $distance=FunctionsV3::getDistanceBetweenPlot(
                $data['client']['lat'],$data['client']['long'],
                $val['latitude'],$val['lontitude'],$distance_type
             );             
             
             $distance_type=$distance_type=="M"?t("miles"):t("kilometers");
             
             $merchant_delivery_distance=getOption($merchant_id,'merchant_delivery_miles');             
             
             $delivery_fee=FunctionsV3::getMerchantDeliveryFee(
                          $merchant_id,
                          $val['delivery_charges'],
                          $distance,
                          $distance_type);
             ?>
                 <div class="col-md-6 border infinite-item">
                    <div class="inner">
                    
                        <?php if ( $val['is_sponsored']==2):?>
                        <div class="ribbon"><span>Sponsored</span></div>
                        <?php endif;?>
                        
                        <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
                        <div class="ribbon-offer"><span><?php echo $offer;?></span></div>
                        <?php endif;?>
                                                                        
                        <img class="logo-medium"src="<?php echo assetsURL()."/images/default-image-merchant.png"?>">
                        
                        <h2><?php echo $val['restaurant_name']?></h2>
                        <p class="merchant-address concat-text"><?php echo $val['merchant_address']?></p>
                        
                        <div class="mytable">
                          <div class="mycol a">
                             <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>   
                             <p><?php echo $ratings['votes']." ".t("Votes")?></p>
                          </div>
                          <div class="mycol b">
                             <?php echo FunctionsV3::prettyPrice($val['minimum_order'])?>
                             <p><?php echo t("Minimum Order")?></p>
                          </div>
                        </div> <!--mytable-->

                        <div class="top25"></div>
                        
                        <?php echo FunctionsV3::merchantOpenTag($merchant_id)?>
                        <?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?>                        
                        
                        <p class="top15 cuisine concat-text">
                        <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
                        </p>                
                                                 
                        <p>
                        <?php 
                        if ($distance){
                        	echo t("Delivery Est").": ".number_format($distance,3)." $distance_type";
                        } else echo  t("Delivery Est").": ".t("not available");
                        ?>
                        </p>
                        
                        <p><?php echo t("Delivery Est")?>: <?php echo FunctionsV3::getDeliveryEstimation($merchant_id)?></p>
                        
                        <p>
                        <?php 
                        if (!empty($merchant_delivery_distance)){
                        	echo t("Delivery Distance").": ".$merchant_delivery_distance." $distance_type";
                        } else echo  t("Delivery Distance").": ".t("not available");
                        ?>
                        </p>
                                                
                        <p>
                        <?php 
                        if ($delivery_fee){
                             echo t("Delivery Fee").": ".FunctionsV3::prettyPrice($delivery_fee);
                        } else echo  t("Delivery Fee").": ".t("not available");
                        ?>
                        </p>
                        
                        <?php echo FunctionsV3::displayServicesList($val['service'])?>          
                        
                        <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" 
                        class="orange-button rounded3 medium">
                        <?php echo t("Order Now")?>
                        </a>
                        
                        
                    </div> <!--inner-->
                 </div> <!--col-->          
              <?php endforeach;?>          
                                                   
             </div> <!--row-->                
             
             <div class="search-result-loader">
                <i></i>
                <p><?php echo t("Loading more restaurant...")?></p>
             </div> <!--search-result-loader-->
             
             <?php             
             $page_link=Yii::app()->createUrl('store/searcharea/',array(
               's'=>$_GET['s'],
             ));
             echo CHtml::hiddenField('current_page_url',$page_link);
             require_once('pagination.class.php'); 
             $attributes                 =   array();
			 $attributes['wrapper']      =   array('id'=>'pagination','class'=>'pagination');			 
			 $options                    =   array();
			 $options['attributes']      =   $attributes;
			 $options['items_per_page']  =   FunctionsV3::getPerPage();
			 $options['maxpages']        =   1;
			 $options['jumpers']=false;
			 $options['link_url']=$page_link.'&page=##ID##';			
			 $pagination =   new pagination( $data['total'] ,((isset($_GET['page'])) ? $_GET['page']:1),$options);		
			 $data   =   $pagination->render();
             ?>             
                    
         </div> <!--result-merchant-->
     
     </div> <!--col search-right-content-->
     
   </div> <!--row-->
  
  </div> <!--container-->
</div> <!--section-search-results-->