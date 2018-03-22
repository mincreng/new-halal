<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Payment"),
   'sub_text'=>t("step 3 of 4")
));

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/progress-merchantsignup',array(
   'step'=>3,
   'show_bar'=>true
));

$my_token=isset($_GET['token'])?$_GET['token']:'';
$package_id=isset($_GET['package_id'])?$_GET['package_id']:'';	

$back_url=Yii::app()->request->baseUrl."/store/merchantSignup/Do/step3/token/".$my_token;
$payment_ref=Yii::app()->functions->generateCode()."TT".Yii::app()->functions->getLastIncrement('{{package_trans}}');

$extra_params='';
$label=t("Pay");

$db_ext=new DbExt;

if (isset($_GET['renew'])){
	//$extra_params="/renew/1/package_id/".$package_id;
	$extra_params="?action=upgradeMembership&package_id=".$package_id;
}

if ( $res=Yii::app()->functions->getMerchantByToken($my_token)){ 
		
	$merchant_id=$res['merchant_id'];
	$payment_description="Membership Package - ".$res['package_name'];
	$amount_to_pay=standardPrettyFormat($res['package_price']);
	$amount_to_pay=unPrettyPrice($amount_to_pay);	
	
	$label.=" ".displayPrice(baseCurrency(),standardPrettyFormat($amount_to_pay));
	
	if (isset($_GET['renew'])){ 
		if ($new_info=Yii::app()->functions->getPackagesById($package_id)){	    					
			$res['package_name']=$new_info['title'];
			$res['package_price']=$new_info['price'];
			if ($new_info['promo_price']>0){
				$res['package_price']=$new_info['promo_price'];
			}						
			$amount_to_pay=standardPrettyFormat($res['package_price']);
	        $amount_to_pay=unPrettyPrice($amount_to_pay);	
	        $label=t("Pay")." ".displayPrice(baseCurrency(),standardPrettyFormat($amount_to_pay));
		}
	}	
	
	if(is_array($_POST) && count($_POST)>=1){ 	
		 $transaction_id=BraintreeClass::PaymentMethod(
	      2,
	      '',
	      $amount_to_pay,
	      $_POST['payment_method_nonce'],
	      $res['contact_name'],
	      $res['restaurant_name']
	   );	   
	   	   
	   if($transaction_id){	  
	   	
	   	  if (isset($_GET['renew'])){ 
	   	  	
	   	  	   if ($new_info=Yii::app()->functions->getPackagesById($package_id)){	    					
					$res['package_name']=$new_info['title'];
					$res['package_price']=$new_info['price'];
					if ($new_info['promo_price']>0){
						$res['package_price']=$new_info['promo_price'];
					}			
				}
				
				$membership_info=Yii::app()->functions->upgradeMembership($res['merchant_id'],$package_id);
				
				$params=array(
		          'package_id'=>$package_id,	          
		          'merchant_id'=>$res['merchant_id'],
		          'price'=>$res['package_price'],
		          'payment_type'=>'btr',
		          'membership_expired'=>$membership_info['membership_expired'],
		          'date_created'=>date('c'),
		          'ip_address'=>$_SERVER['REMOTE_ADDR'],
		          'PAYPALFULLRESPONSE'=>$transaction_id,
		           'TRANSACTIONID'=>$transaction_id,
		           'TOKEN'=>$my_token,
		           'status'=>'paid'
		        );		
		        
		        /*auto update the merchant expiration*/
		        $params_1=array(
		          'membership_expired'=>$membership_info['membership_expired'],
		          'membership_purchase_date'=>date('c')
		        );
		        $db_ext->updateData("{{merchant}}",$params_1,'merchant_id',$res['merchant_id']);
		        
	   	  } else {
		   	  $params=array(
		           'package_id'=>$res['package_id'],	          
		           'merchant_id'=>$res['merchant_id'],
		           'price'=>$res['package_price'],
		           'payment_type'=>'btr',
		           'membership_expired'=>$res['membership_expired'],
		           'date_created'=>date('c'),
		           'ip_address'=>$_SERVER['REMOTE_ADDR'],
		           'PAYPALFULLRESPONSE'=>$transaction_id,
		           'TRANSACTIONID'=>$transaction_id,
		           'TOKEN'=>$my_token,
		           'status'=>'paid'
			   );
	   	  }
		   	   	   
	   	   $db_ext->insertData("{{package_trans}}",$params);	
	   	   
   	       $db_ext->updateData("{{merchant}}",
				  array(
				    'payment_steps'=>3,
				    'membership_purchase_date'=>date('c')
				  ),'merchant_id',$res['merchant_id']);
	   	   
		   if (isset($_GET['renew'])){
                     header('Location: '.Yii::app()->request->baseUrl."/store/renewSuccesful");
           } else header('Location: '.Yii::app()->request->baseUrl."/store/merchantSignup/Do/step4/token/$my_token");	
           Yii::app()->end();
             	  
	   } else $error=t("Error processing transaction");
	} else {	
		/*generate client token*/
		if(!$client_token=BraintreeClass::generateCLientToken(2,'','')){
			$error=t("Failed generating client token");
		}
	}

} else $error=t("Failed. Cannot process payment");
?>

<div class="sections section-grey2 section-orangeform">
<div class="container">  
  <div class="row top30">
     <div class="inner">
     <h1><?php echo t("Pay using Braintree")?></h1>
     <div class="box-grey rounded">	
     
     <?php if(!empty($error)):?>
       <p class="text-danger"><?php echo $error?></p>
     <?php else :?>
        <?php if(is_array($_POST) && count($_POST)>=1):?>
           <?php echo t("Payment successful please wait while we redirect you to receipt")?>
        <?php else :?>  
           <?php BraintreeClass::displayForms($client_token, $label)?>
        <?php endif;?>
     <?php endif;?>     
     
	<div class="top25">
	<a href="<?php echo Yii::app()->getBaseUrl(true)."/store/merchantsignup/do/step3/token/$my_token/$extra_params"?>">
	<i class="ion-ios-arrow-thin-left"></i> <?php echo Yii::t("default","Click here to change payment option")?></a>
	</div>
	         
     </div> <!--box-->
     </div> <!--inner-->     
  </div> <!--row-->
</div> <!--container-->
</div> <!--sections-->