<?php 
$cuisine=Yii::app()->functions->Cuisine(false);
$city=Yii::app()->functions->getCityList();
?>


<div class="ie-no-supported-msg">
<div class="main">
<h2><?php echo Yii::t("default","Oopps..It Seems that you are using browser which is not supported.")?></h2>
<p class="uk-text-danger">
<?php echo Yii::t("default","Restaurant will not work properly..")?>
<?php echo Yii::t("default","Please use firefox,chrome or safari instead. THANK YOU!")?></p>
</div>
</div>

<div class="menu-wrapper page-right-sidebar">
  <div class="main">
      <h2 class="uk-h2"><i class="fa fa-bars"></i> <?php echo Yii::t("default","Restaurants")?></h2>            
      
      <div class="two-columns">
        <div class="grid-1 left">
        
        <div class="uk-grid" id="tabs">
	        <div class="uk-width-small-1-3">
	            <ul data-uk-tab="{connect:'#tab-left-content'}" class="uk-tab uk-tab-left">
	                <li class="uk-active"><a href="#"><i class="fa fa-cutlery"></i> <?php echo Yii::t("default","Restaurants")?></a></li>
	                <li class=""><a href="#"><i class="fa fa-bolt"></i> <?php echo Yii::t("default","Newest")?></a></li>
	                <li class=""><a href="#"><i class="fa fa-star-o"></i> <?php echo Yii::t("default","Featured")?></a></li>	            
	
	        </div>
	        <div class="uk-width-medium-1-2">
	            <ul class="uk-switcher" id="tab-left-content">
	                <li class="uk-active">
	                   <?php Widgets::displayMerchant(Yii::app()->functions->getAllMerchant());?>
	                </li>
	                <li class="">
	                   <?php Widgets::displayMerchant(Yii::app()->functions->getAllMerchantNewest());?>
	                </li>
	                <li class="">
	                   <?php Widgets::displayMerchant(Yii::app()->functions->getFeaturedMerchant());?>
	                </li>
	            </ul>
	        </div>
	    </div><!-- uk-grid-->
        
        </div> <!--left-->
        <div class="grid-2 left"></div>
        <div class="clear"></div>
      </div><!-- two-columns-->     
      
  </div> <!--main-->
</div> <!--END browse-wrapper-->