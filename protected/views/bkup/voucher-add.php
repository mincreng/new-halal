
<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/voucher/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/voucher" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
</div>

<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','addVoucher')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/voucher/")?>
<?php endif;?>

<?php 
$user_access='';
if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->getVoucherCodeById($_GET['id'])){
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	} else $user_access=json_decode($data['user_access'],true);
}
?>                                 

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Voucher name")?></label>
  <?php echo CHtml::textField('voucher_name',$data['voucher_name'],array('data-validation'=>'required'))?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Nos. Of Voucher")?></label>
  <?php if (isset($_GET['id'])):?>
  <?php echo CHtml::textField('number_of_voucher',$data['number_of_voucher'],array('data-validation'=>'required','class'=>'numeric_only','disabled'=>"disabled"))?>
  <?php else :?>
  <?php echo CHtml::textField('number_of_voucher',$data['number_of_voucher'],array('data-validation'=>'required','class'=>'numeric_only'))?>
  <?php endif;?>
  <span class="uk-text-muted"><?php echo Yii::t("default","Number of vouchers to be generated")?></span>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Type")?></label>  
  <?php
echo CHtml::dropDownList('voucher_type',$data['voucher_type'],
Yii::app()->functions->voucherType()
)
?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Discount")?></label>  
  <?php echo CHtml::textField('amount',$data['amount'],array('data-validation'=>'required','class'=>'numeric_only'))?>
  <span class="uk-text-muted"><?php echo Yii::t("default","Voucher amount discount.")?></span>
</div>

<div class="uk-form-row">
  <label class="uk-form-label">Status</label>
  <?php echo CHtml::dropDownList('status',
  isset($data['status'])?$data['status']:"",
  (array)statusList(), 
  array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>


<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>