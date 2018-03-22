<?php
$data=$_GET;
if ( isset($data['merchant'])){
   $re_info=Yii::app()->functions->getMerchantBySlug($data['merchant']);
} else $re_info='';

$now=date('Y-m-d');
$now_time='';//date("h:i A");
?>
<div class="menu-wrapper page-right-sidebar">
  <div class="main">    
  
  <?php if (is_array($re_info) && count($re_info)>=1):?> 
  <?php 
  $cuisine_list=Yii::app()->functions->Cuisine(true);	    		    	
  $country_list=Yii::app()->functions->CountryList();
  
  $resto_cuisine='';
  
  $merchant_id=$re_info['merchant_id'];
  echo CHtml::hiddenField('merchant_id',$merchant_id);
  $_SESSION['kr_merchant_id']=$merchant_id;

  $merchant_photo=Yii::app()->functions->getOption("merchant_photo",$re_info['merchant_id']);  
  $cuisine=!empty($re_info['cuisine'])?(array)json_decode($re_info['cuisine']):false;  
  if($cuisine!=false){
	foreach ($cuisine as $valc) {	    						
		if ( array_key_exists($valc,(array)$cuisine_list)){
			$resto_cuisine.=$cuisine_list[$valc].",";
		}				
	}
	$resto_cuisine=!empty($resto_cuisine)?substr($resto_cuisine,0,-1):'';
  }	    		     
  if (array_key_exists($re_info['country_code'],(array)$country_list)){  	
     $country_name=$country_list[$re_info['country_code']];
  } else $country_name=$re_info['country_code'];
  
  $minimum_order=Yii::app()->functions->getOption("merchant_minimum_order",$re_info['merchant_id']);
  $delivery_fee=Yii::app()->functions->getOption("merchant_delivery_charges",$re_info['merchant_id']);
  
  $ratings=Yii::app()->functions->getRatings($re_info['merchant_id']);
  $rating_meanings='';
  if ( $ratings['ratings'] >=1){
	$rating_meaning=Yii::app()->functions->getRatingsMeaning($ratings['ratings']);
	$rating_meanings=ucwords($rating_meaning['meaning']);
  }	    		  
  ?>
  <div class="restaurant-wrap">
    <div class="uk-grid">
    
      <div class="uk-width-1-4" style="width:110px;">
       <?php if ( !empty($merchant_photo)):?>
       <img src="<?php echo baseUrl()."/upload/$merchant_photo"?>" alt="" title="" class="uk-thumbnail uk-thumbnail-mini">
       <?php else :?>
       no image
       <?php endif;?>       
      </div> <!--END uk-width-1-4-->
      
      <div class="uk-width-1-3">
        <h5><?php echo $re_info['restaurant_name']?></h5>
        <p class="uk-text-muted"><?php echo $re_info['street']." ".$re_info['city']." ".$re_info['state'] ." ".$re_info['post_code']?></p>
        <p class="uk-text-bold"><?php echo $country_name?></p>
        <p class="uk-text-bold">Cuisine - <?php echo $resto_cuisine?></p>
        <p><span class="uk-text-bold">Distance:</span> 1.5 miles</p>
        <p><span class="uk-text-bold">Delivery Est:</span> 45 minutes (approx)</p>
        <p><span class="uk-text-bold">Delivery Fee:</span> <?php echo getCurrencyCode().$delivery_fee?></p>        
        <?php echo Yii::app()->widgets->getOperationalHours($re_info['merchant_id'])?>
      </div> <!--END uk-width-1-4-->
      
      <div class="uk-width-1-4">
       <p class="uk-text-bold">Minimum</p>
       <p><?php echo getCurrencyCode().$minimum_order;?></p>
      </div> <!--END uk-width-1-4-->
      
      <div class="uk-width-1-4">
         <div class="rate-wrap">
	     <h6 class="rounded2" data-uk-tooltip="{pos:'bottom-right'}" title="<?php echo $rating_meanings?>"><?php echo $ratings['ratings']?></h6>
	     <span><?php echo $ratings['votes']?> Votes</span>
	    </div>
      </div> <!--END uk-width-1-4-->
      
    </div>
  </div> <!--restaurant-wrap-->
  
  <div class="rating-wrapper">
    <div class="uk-grid">
      <div class="uk-width-1-2" style="width:220px;padding-top:10px;">
        <a href="javascript:;" class="btn-flat-grey rounded2">write a review <i class="fa fa-angle-right"></i></a>
      </div>
      <div class="uk-width-1-2">
          <p>Your Rating</p>
          <select id="bar-rating" name="rating">
                <option value=""></option>
                <option value="1" class="level1">1.0</option>
                <option value="1.5">1.5</option>
                <option value="2">2.0</option>
                <option value="2.5">2.5</option>
                <option value="3">3.0</option>
                <option value="3.5">3.5</option> 
                <option value="4">4.0</option> 
                <option value="4.5">4.5</option> 
                <option value="5">5.0</option>                 
            </select>
      </div>      
    </div>
  </div><!-- END rating-wrapper-->
  
  <div class="grid" id="menu-wrap">
     
  <div class="grid-1 left">
  
  <ul data-uk-tab="{connect:'#tab-content'}" class="uk-tab uk-active">
    <li class="uk-active"><a href="#"><?php echo Yii::t("default","Menu")?></a></li>
    <li class=""><a href="#"><?php echo Yii::t("default","Reviews")?></a></li>
    <li class=""><a href="#"><?php echo Yii::t("default","Map")?></a></li>
    <li class=""><a href="#"><?php echo Yii::t("default","Photos")?></a></li>
  </ul>
  
  
  <?php 
  $menu=Yii::app()->functions->getMerchantMenu($merchant_id);
  ?>
  
  <ul class="uk-switcher uk-margin" id="tab-content">
    <li class="uk-active">
    <?php if (is_array($menu) && count($menu)>=1):?>
    
    <div class="menu">
    <?php foreach ($menu as $val):?>
     <div class="inner">
      <a class="menu-category" href="javascript:;">
        <?php echo $val['category_name']?>
        <i class="fa fa-chevron-up"></i>
      </a>
      <?php if (is_array($val['item']) && count($val['item'])>=1):?>     
      <ul>
       <?php foreach ($val['item'] as $val_item): //dump($val_item);?>
       <li>
         <div class="uk-grid">
          <div class="uk-width-1-2">
            <a href="javascript:;" rel="<?php echo $val_item['item_id']?>" class="menu-item"><?php echo $val_item['item_name']?></a>
          </div>
          <div class="uk-width-1-2 proce-wrap">
            <?php if (is_array($val_item['prices']) && count($val_item['prices'])>=1):?>
              <?php if (!empty($val_item['discount'])):?>
              <div class="normal-price"><?php echo getCurrencyCode().
               prettyFormat($val_item['prices'][0]['price'])?></div>
              <div class="sale-price"><?php echo getCurrencyCode().
               prettyFormat($val_item['prices'][0]['price']-$val_item['discount']);
              ?></div>
              <?php else :?>
              <?php echo getCurrencyCode().prettyFormat($val_item['prices'][0]['price'])?>
              <?php endif;?>
            <?php endif;?>
          </div>
         </div>
       </li>
       <?php endforeach;?>
       <div class="clear"></div>
      </ul>
      <?php endif;?>
      </div> <!--inner-->
    <?php endforeach;?>     
    </div> <!--menu-->
    
    <?php else :?>
    <p><?php echo Yii::t("default","This restaurant has not been published their menu.")?></p>
    <?php endif;?>
    </li>
    <li class="uk-active">
    reviews
    </li>
    <li class="uk-active">
    map
    </li>
    <li class="uk-active">
    photo
    </li>
  </ul> <!--END tab-content-->
  
  </div>  <!--END GRID-1-->
  
  <div class="grid-2 left">
    <div class="order-list-wrap">
      <h5>Your Order</h5>

      <!--<div class="item-order-list item-row">
          <div class="a">1</div>
          <div class="b">Albacore Tempura</div>
          <div class="manage">
            <div class="c">
              <a href="#"><i class="fa fa-pencil-square-o"></i></a>
              <a href="#"><i class="fa fa-trash-o"></i></a>
            </div>
             <div class="d">$7.50</div>
          </div>
          <div class="clear"></div>
                              
          <div class="a">1</div>
          <div class="b uk-text-muted">Albacore Tempura</div>
          <div class="manage">            
             <div class="d">$7.50</div>
          </div>
          <div class="clear"></div>
          
      </div>--> <!--item-order-list-->
      
      <!--<div class="item-order-list item-row">
          <div class="a">1</div>
          <div class="b">Albacore Tempura</div>
          <div class="manage">
            <div class="c">
              <a href="#"><i class="fa fa-pencil-square-o"></i></a>
              <a href="#"><i class="fa fa-trash-o"></i></a>
            </div>
             <div class="d">$7.50</div>
          </div>
          <div class="clear"></div>
          
      </div>--> <!--item-order-list-->
      
      <div class="item-order-wrap"></div> <!--END item-order-wrap-->
      
      <!--<div class="summary-wrap">
         <div class="a">Subtotal:</div>
         <div class="manage">
           <div class="b">7.50</div>
         </div>
         <div class="a">Delivery Fee:</div>
         <div class="manage">
           <div class="b">7.50</div>
         </div>
         <div class="a">Tax:</div>
         <div class="manage">
           <div class="b">7.50</div>
         </div>
         <div class="a bold">Total:</div>
         <div class="manage">
           <div class="b bold">7.50</div>
         </div>
         <div class="clear"></div>        
      </div>--> <!--summary-->
      
      <?php $minimum_order=Yii::app()->functions->getOption('merchant_minimum_order',$merchant_id);?>
      <?php if (!empty($minimum_order)):?>
      <?php 
            echo CHtml::hiddenField('minimum_order',unPrettyPrice($minimum_order));
            echo CHtml::hiddenField('minimum_order_pretty',baseCurrency().prettyFormat($minimum_order))
       ?>
      <p class="uk-text-muted">Subtotal must exceed 
         <?php echo baseCurrency().prettyFormat($minimum_order,$merchant_id)?>
      </p>      
      <?php endif;?>
      
      <div class="delivery_options">
       <h5><?php echo Yii::t("default","Delivery Options")?></h5>
       <?php echo CHtml::dropDownList('delivery_type',$now,(array)Yii::app()->functions->DeliveryOptions())?>
       <?php echo CHtml::textField('delivery_date',$now,array('class'=>"j_date"))?>
       <?php echo CHtml::textField('delivery_time',$now_time,
       array('class'=>"timepick",'placeholder'=>"Delivery Time"))?>
       <span class="uk-text-small uk-text-muted">Delivery ASAP?</span>
       <?php echo CHtml::checkBox('delivery_asap',false,array('class'=>"icheck"))?>
      </div>
      
      <a href="javascript:;" class="uk-button uk-button-success checkout">Checkout</a>
      
   </div> <!--order-list-wrap-->
  </div> <!--END GRID-2-->
  
  <div class="clear"></div>
  
  </div> <!--END GRID menu-wrap-->
  
  <?php else :?>
  <p><?php echo Yii::t("default","Sorry but we cannot find what you are looking for.")?></p>
  <?php endif;?>
  
  </div>
</div> <!--END  menu-wrapper--> 