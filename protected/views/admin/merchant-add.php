<?php 
$url_login='';
if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->getMerchant($_GET['id'])){
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	} else {
		$url_login=baseUrl()."/merchant/autologin/id/".$data['merchant_id']."/token/".$data['password'];		
	}
}
?>                              

<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchantAdd" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchant" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>

<?php if (!empty($url_login)):?>
<a target="_blank" href="<?php echo $url_login;?>" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","AutoLogin")?></a>
<?php endif;?>

</div>

<div class="spacer"></div>

<div class="merchant-add"></div>

<div class="right" style="margin-top:-30px">
<?php if ($data['is_commission']==2):?>
<h3 style="margin:0 0 8px;"><?php echo t("Charges Type")?>: <span class="uk-text-danger"><?php echo t("Commission")?><span></h3>
<?php else :?>
<h3 style="margin:0 0 8px;"><?php echo t("Charges Type")?>: <span class="uk-text-danger"><?php echo t("Membership")?></span></h3>
<?php endif;?>
</div>
<div class="clear"></div>

<ul data-uk-tab="{connect:'#tab-content'}" class="uk-tab uk-active">
<li class="uk-active"><a href="#"><?php echo t("Restaurant Information")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Login Information")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Membership")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Featured")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Payment History")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Commission Settings")?></a></li>
<li class=""><a href="#"><?php echo Yii::t("default","Google Map")?></a></li>
</ul>     

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','addMerchant')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php echo CHtml::hiddenField('old_status',isset($data['status'])?$data['status']:"")?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/merchantAdd")?>
<?php endif;?>

<ul class="uk-switcher uk-margin " id="tab-content">
<li class="uk-active">
    <fieldset>        
    
    
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Restaurant Slug")?></label>
          <?php echo CHtml::textField('restaurant_slug',
          isset($data['restaurant_slug'])?stripslashes($data['restaurant_slug']):""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
    
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Restaurant name")?></label>
          <?php echo CHtml::textField('restaurant_name',
          isset($data['restaurant_name'])?stripslashes($data['restaurant_name']):""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        
         <?php if ( Yii::app()->functions->getOptionAdmin('merchant_reg_abn')=="yes"):?>
         <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","ABN")?></label>
          <?php echo CHtml::textField('abn',
          isset($data['abn'])?$data['abn']:""
          ,array(
          'class'=>'uk-form-width-large',
          //'data-validation'=>"required"
          ))?>
        </div>
        <?php endif;?>
        
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Restaurant phone")?></label>
          <?php echo CHtml::textField('restaurant_phone',
          isset($data['restaurant_phone'])?$data['restaurant_phone']:""
          ,array(
          'class'=>'uk-form-width-large'
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Contact name")?></label>
          <?php echo CHtml::textField('contact_name',
          isset($data['contact_name'])?$data['contact_name']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Contact phone")?></label>
          <?php echo CHtml::textField('contact_phone',
          isset($data['contact_phone'])?$data['contact_phone']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Contact email")?></label>
          <?php echo CHtml::textField('contact_email',
          isset($data['contact_email'])?$data['contact_email']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo t("Country")?></label>
          <?php echo CHtml::dropDownList('country_code',
          isset($data['country_code'])?$data['country_code']:"",
          (array)Yii::app()->functions->CountryList(),          
          array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Street address")?></label>
          <?php echo CHtml::textField('street',
          isset($data['street'])?$data['street']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
                
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","City")?></label>
          <?php echo CHtml::textField('city',
          isset($data['city'])?$data['city']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Post code/Zip code")?></label>
          <?php echo CHtml::textField('post_code',
          isset($data['post_code'])?$data['post_code']:""
          ,array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
		
		<div class="uk-form-row">
		<label class="uk-form-label"><?php echo Yii::t("default","State/Region")?></label>
		<?php echo CHtml::textField('state',
		isset($data['state'])?$data['state']:""
		,array(
		'class'=>'uk-form-width-large',
		'data-validation'=>"required"
		))?>
		</div>    		

        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Cuisine")?></label>
          <?php echo CHtml::dropDownList('cuisine[]',
          isset($data['cuisine'])?(array)json_decode($data['cuisine']):"",
          (array)Yii::app()->functions->Cuisine(true),          
          array(
          'class'=>'uk-form-width-large chosen',
          'multiple'=>true,
          'data-validation'=>"required"
          ))?>
        </div>
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Pick Up or Delivery?")?></label>
          <?php echo CHtml::dropDownList('service',
          isset($data['service'])?$data['service']:"",
          (array)Yii::app()->functions->Services(),          
          array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        
         <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Published Merchant")?></label>
          <?php 
          echo CHtml::checkBox('is_ready',
          $data['is_ready']==2?true:false
          ,array(
            'value'=>2,
            'class'=>"icheck"
          ))
          ?>
        </div>
        
        <div class="uk-form-row">
          <label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>
          <?php echo CHtml::dropDownList('status',
          isset($data['status'])?$data['status']:"",
          (array)clientStatus(),          
          array(
          'class'=>'uk-form-width-large',
          'data-validation'=>"required"
          ))?>
        </div>
        
               
    </fieldset>
</li>

<li>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Username")?></label>
  <?php echo CHtml::textField('username',
  isset($data['username'])?$data['username']:""
  ,array(
  'class'=>'uk-form-width-large'
  ))?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Password")?></label>
  <?php echo CHtml::passwordField('password',
  ""
  ,array(
  'class'=>'uk-form-width-large',
  'autocomplete'=>"off"
  ))?>
</div>
</li>

<li>
<?php 
Yii::app()->functions->data="list";
?>
<div class="uk-form-row">
  <!--<label class="uk-form-label"><?php echo Yii::t("default","Package Name")?></label>
  <span class="uk-text-bold"><?php echo isset($data['package_name'])?ucwords($data['package_name']):"Not Available";?></span>-->
  <label class="uk-form-label"><?php echo Yii::t("default","Package Name")?></label>
  <?php 
  echo CHtml::dropDownList('package_id',
  $data['package_id']
  ,Yii::app()->functions->getPackagesList())
  ?>
  </div>
  
  <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Package Price")?></label>
  <span class="uk-text-primary"><?php echo adminCurrencySymbol().standardPrettyFormat($data['package_price'])?></span>
  </div>
  
  <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Membership Expired On")?></label>
  <span class="uk-text-success">
  <?php 
  echo CHtml::hiddenField('membership_expired',$data['membership_expired']);
  echo CHtml::textField('membership_expired1',FormatDateTime($data['membership_expired'],false),array(
    'class'=>"j_date",
    'data-validation'=>"requiredx",
    'data-id'=>'membership_expired'
  ))
  ?>
  </div>  
</li>

<li>
 <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Featured")?>?</label>
  <?php 
  echo CHtml::checkBox('is_featured',
  $data['is_featured']==2?true:false
  ,array('class'=>"icheck",'value'=>2))
  ?>
  <p class="uk-text-muted"><?php echo Yii::t("default","Check this if you want this merchant featured on homepage")?></p>
  </div>
</li>

<li>
  <?php if ($payment_res=Yii::app()->functions->getMerchantPaymentTransaction($_GET['id'])):?>
	  <table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
	  <caption><?php echo Yii::t("default","Merchant Payment History")?></caption>
	   <thead>	
	   <th><?php echo Yii::t("default","Package Name")?></th>
	   <th><?php echo Yii::t("default","Amount")?></th>
	   <th><?php echo Yii::t("default","Expired On")?></th>
	   <th><?php echo Yii::t("default","Payment Type")?></th>
	   <th><?php echo Yii::t("default","Status")?></th>
	   <th><?php echo Yii::t("default","Transaction Date")?></th>	   
	   </thead>    
	   <tbody>
	  <?php foreach ($payment_res as $val):?>
	  <tr>
	   <td><?php echo $val['package_name']?></td>
	   <td><?php echo Yii::app()->functions->standardPrettyFormat($val['price'])?></td>
	   <td><?php echo prettyDate($val['membership_expired'])?></td>
	   <td><?php echo strtoupper($val['payment_type']);?></td>
	   <td><?php echo Yii::t("default",$val['status'])?></td>
	   <td><?php echo prettyDate($val['date_created'],true)?></td>
	  </tr>
	  <?php endforeach;?>  
	  </tbody>
	  </table>
  <?php else :?>	  
  <p class="uk-text-warning"><?php echo Yii::t("default","No Payment records")?></p>
  <?php endif;?>
</li>

<li>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Commission")?>?</label>
  <?php   
  echo CHtml::checkBox('is_commission',
  $data['is_commission']==2?true:false
  ,array(
    'value'=>2,
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","commission on orders")?></label>
  <?php 
  $percent_commision=Yii::app()->functions->getOptionAdmin('admin_commision_percent');
  if ($data['percent_commision']<=0){
  	  $data['percent_commision']=$percent_commision;
  }
  
  $commision_type=Yii::app()->functions->getOptionAdmin('admin_commision_type');
  if (!empty($data['commision_type'])){
  	  $data['commision_type']=$data['commision_type'];
  }
  
  echo CHtml::dropDownList('commision_type',
  $data['commision_type']
  ,array(
   'fixed'=>"Fixed",
   'percentage'=>"Percentage"
  ));
  
  echo CHtml::textField('percent_commision',
  normalPrettyPrice($data['percent_commision'])
  ,array(
    'class'=>"uk-form-width-small"
  ))
  ?>
</div>

<p class="uk-text-danger">
<?php echo t("Note: If this is ticked, the merchant will be charged commission per order and membership package will be ignored")?>
</p>


<?php $merchant_id=isset($_GET['id'])?$_GET['id']:''; ?>
<h3><?php echo t("Offline Payment Option")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Cash On delivery")?>?</label>
  <?php   
  echo CHtml::checkBox('merchant_switch_master_cod',
  Yii::app()->functions->getOption("merchant_switch_master_cod",$merchant_id)==2?true:false
  ,array(
    'value'=>2,
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Offline Credit Card Payment")?>?</label>
  <?php   
  echo CHtml::checkBox('merchant_switch_master_ccr',
  Yii::app()->functions->getOption("merchant_switch_master_ccr",$merchant_id)==2?true:false
  ,array(
    'value'=>2,
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Pay On Delivery")?>?</label>
  <?php   
  echo CHtml::checkBox('merchant_switch_master_pyr',
  Yii::app()->functions->getOption("merchant_switch_master_pyr",$merchant_id)==2?true:false
  ,array(
    'value'=>2,
    'class'=>"icheck"
  ))
  ?> 
</div>

</li>


<li>

 <?php 
 $lat=''; $lng='';
 if (!empty($merchant_id)){
    $lat=getOption($merchant_id,'merchant_latitude');
    $lng=getOption($merchant_id,'merchant_longtitude');
 }
 ?>

 <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Latitude")?></label>
  <?php echo CHtml::textField('merchant_latitude',
  $lat
  ,array(
  'class'=>'uk-form-width-large',
  //'data-validation'=>"required"
  ))?>
</div>

 <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Longitude")?></label>
  <?php echo CHtml::textField('merchant_longtitude',
  $lng
  ,array(
  'class'=>'uk-form-width-large',
  //'data-validation'=>"required"
  ))?>
</div>
</li>

</ul>    

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>