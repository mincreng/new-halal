<?php
$this->renderPartial('/front/banner-receipt',array(
   /*'h1'=>t("Thank You"),
   'sub_text'=>t("Your order has been placed.")*/
));
echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));

echo $tabs;
?>

<div class="sections section-grey2 section-profile">
  <div class="container">

  <div class="tabs-wrapper">
     <ul id="tabs">
       <li class="<?php echo $tabs==""?"active":''?>"><i class="ion-android-contact"></i> <?php echo t("Profile")?></li>       
       <li class="address-book <?php echo $tabs==2?"active":''?>" >
         <i class="ion-ios-compose-outline"></i> <?php echo t("Address Book")?>
       </li>
       <li ><i class="ion-ios-cart"></i> <?php echo t("Order History")?></li>
       <li ><i class="ion-card"></i> <?php echo t("Credit Cards")?></li>
     </ul>
     
     <ul id="tab">
       <li class="<?php echo $tabs==""?"active":''?>">
          <?php $this->renderPartial('/front/profile',array(
            'data'=>Yii::app()->functions->getClientInfo(Yii::app()->functions->getClientId())            
          ));?>
       </li>
       <li class="<?php echo $tabs==2?"active":''?>">
         <?php $this->renderPartial('/front/address-book',array(
           'client_id'=>Yii::app()->functions->getClientId(),
           'data'=>Yii::app()->functions->getAddressBookByID( isset($_GET['id'])?$_GET['id']:'' )
         ));?>
       </li>
       <li>
         <?php $this->renderPartial('/front/order-history',array(           
           'data'=>Yii::app()->functions->clientHistyOrder( Yii::app()->functions->getClientId() )
         ));?>
                
       </li>
       <li>
       <?php 
	     $this->renderPartial('/front/manage-credit-card',array(		 
		 ));
		 ?>     
       </li>
     </ul>
  </div> <!--tabs-wrapper--> 
  
  </div> <!--container-->  
</div> <!--sections-->
