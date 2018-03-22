<?php
$enabled=Yii::app()->functions->getOptionAdmin('admin_commission_enabled');
$disabled_membership=Yii::app()->functions->getOptionAdmin('admin_disabled_membership');
$admin_commision_ontop=Yii::app()->functions->getOptionAdmin('admin_commision_ontop');
?>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','commissionSettings')?>

<h3><?php echo t("Admin Commission Settings")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Exclude All Offline Payment from admin balance")?></label>
  <?php 
  echo CHtml::checkBox('admin_exclude_cod_balance',
  Yii::app()->functions->getOptionAdmin('admin_exclude_cod_balance')==2?true:false
  ,array(
    'value'=>2,
    'class'=>"icheck"
  ))
  ?> 
</div>

<h3><?php echo t("Merchant Signup Settings")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Commission")?>?</label>
  <?php 
  echo CHtml::checkBox('admin_commission_enabled',
  $enabled=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Membership Signup")?>?</label>
  <?php 
  echo CHtml::checkBox('admin_disabled_membership_signup',
  getOptionA('admin_disabled_membership_signup')==1?true:false
  ,array(
    'value'=>1,
    'class'=>"icheck"
  ))
  ?> 
</div>
<!--<p class="uk-text-muted"><?php echo t("This options only take affect if you enabled the commission signup")?></p>-->

<!--<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Membership")?>?</label>
  <?php 
  echo CHtml::checkBox('admin_disabled_membership',
  $disabled_membership=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>-->
  
  
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Include Cash Payment on merchant balance")?>?</label>
  <?php 
  echo CHtml::checkBox('admin_include_merchant_cod',
  Yii::app()->functions->getOptionAdmin('admin_include_merchant_cod')=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","commission on orders")?></label>
  <?php 
  echo CHtml::dropDownList('admin_commision_type',
  Yii::app()->functions->getOptionAdmin('admin_commision_type')
  ,array(   
   'percentage'=>t("Percentage"),
   'fixed'=>t("Fixed"),
  ));
  echo CHtml::textField('admin_commision_percent',
  Yii::app()->functions->getOptionAdmin('admin_commision_percent')
  ,array(
    'class'=>"uk-form-width-small numeric_only"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Set commission on")?></label>  
</div>
<ul>
<li style="list-style:none;margin-bottom:10px;">
<?php echo CHtml::radioButton('admin_commision_ontop',
$admin_commision_ontop==1?true:false
,array('value'=>1,'class'=>"icheck"))?>
&nbsp;&nbsp;<?php echo t("Commission on Sub total order")?>
</li>
<li style="list-style:none;">
<?php echo CHtml::radioButton('admin_commision_ontop',
$admin_commision_ontop==2?true:false
,array('value'=>2,'class'=>"icheck"))?>
&nbsp;&nbsp;<?php echo t("Commission on Total order")?>
</li>
</ul>	


<h3><?php echo t("Total Commission")?></h3>
<?php  
$order_stats=Yii::app()->functions->orderStatusList2(false);
$total_commission_status=Yii::app()->functions->getOptionAdmin('total_commission_status');
if (!empty($total_commission_status)){
	$total_commission_status=json_decode($total_commission_status);
} else {
	$total_commission_status=array('paid');
}
?>

<div class="uk-form-row">
  <label class="uk-form-label" style="padding-right:5px;"><?php echo Yii::t("default","Compute Total Commission base on the following order status")?></label>
  <?php echo CHtml::dropDownList('total_commission_status[]',$total_commission_status,(array)$order_stats,array(
  'class'=>"chosen uk-form-width-large",
  'multiple'=>true
  ))?>
</div>

<!--
<h3><?php echo Yii::t("default","Invoice")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","VAT No")?></label>
  <?php 
  echo CHtml::textField('admin_vat_no',
  Yii::app()->functions->getOptionAdmin('admin_vat_no')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","VAT")?>(%)</label>
  <?php 
  echo CHtml::textField('admin_vat_percent',
  Yii::app()->functions->getOptionAdmin('admin_vat_percent')
  ,array(
    'class'=>"uk-form-width-large numeric_only"
  ))
  ?>
</div>
-->
  
<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>