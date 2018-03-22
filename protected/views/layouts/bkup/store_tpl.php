<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<head>

<!-- IE6-8 support of HTML5 elements --> 
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico?ver=1.0" />
<?php Widgets::analyticsCode();?>

</head>
<body>

<div id="mobile-menu" class="uk-offcanvas">
    <div class="uk-offcanvas-bar">
      <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>                     
      <?php echo Yii::app()->functions->mobileMenu()?>      
	 </ul>	
    </div> <!--offcanvar bar-->
</div> <!--uk-offcanvas-->

<?php Widgets::languageBar();?>

<div class="header-wrap" id="header-wrap">
  <div class="main">
     <div class="uk-grid">
     
        <div class="section-mobile-menu-link">
           <a href="#mobile-menu" data-uk-offcanvas><i class="fa fa-bars"></i></a>
        </div>
     
        <div class="uk-width-1-3 top-a">
                          
          <div class="section-top section-to-menu-user">
          
            <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->topMenu());?>
                                   
            <?php if ( Yii::app()->functions->isClientLogin()):?>
            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
			    <button class="uk-button">
			       <i class="uk-icon-user"></i> <?php echo ucwords(Yii::app()->functions->getClientName());?> <i class="uk-icon-caret-down"></i>
			    </button>	    
			    <div class="uk-dropdown" style="">
			        <ul class="uk-nav uk-nav-dropdown">            	            
			            <li>
			            <a href="<?php echo Yii::app()->request->baseUrl; ?>/store/Profile">
			            <i class="uk-icon-user"></i> <?php echo Yii::t("default","Profile")?></a>
			            </li>
			            <li>
			            <a href="<?php echo Yii::app()->request->baseUrl; ?>/store/orderHistory">
			            <i class="fa fa-file-text-o"></i> <?php echo Yii::t("default","Order History")?></a>
			            </li>
			            
			            <li>
			            <a href="<?php echo Yii::app()->request->baseUrl; ?>/store/addressbook">
			            <i class="fa fa-map-marker"></i> <?php echo Yii::t("default","Address Book")?></a>
			            </li>
			            
			            <?php if (Yii::app()->functions->getOptionAdmin('disabled_cc_management')==""):?>
			            <li>
			            <a href="<?php echo Yii::app()->request->baseUrl; ?>/store/Cards">
			            <i class="uk-icon-gear"></i> <?php echo Yii::t("default","Credit Cards")?></a>
			            </li>
			            <?php endif;?>
			            
			            <!--POINTS PROGRAM-->			            
			            <?php //PointsProgram::frontMenu(true);?>
			            
			            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/store/logout">
			            <i class="uk-icon-sign-out"></i> <?php echo Yii::t("default","Logout")?></a></li>
			        </ul>
			     </div>
			 </div> <!--uk-button-dropdown-->
		  <?php endif;?>
		              
          </div>
        </div>
        <div class="uk-width-1-3 top-b">
           <div class="logo-wrap">
             <?php $website_logo=yii::app()->functions->getOptionAdmin('website_logo');?>
             <?php $website_title=yii::app()->functions->getOptionAdmin('website_title');?>             
             <a href="<?php echo Yii::app()->request->baseUrl;?>/store">
             <?php if ( !empty($website_logo)):?>
             <img src="<?php echo Yii::app()->request->baseUrl."/upload/$website_logo";?>" alt="<?php echo $website_title;?>" title="<?php echo $website_title;?>">
             <?php else :?>
                <h1><?php echo $website_title?></h1>
             <?php endif;?>
             </a>
           </div>
        </div>
        <div class="uk-width-1-3 top-c">
          <div class="section-top section-right">
                      
            <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->topLeftMenu());?>                                  
            <div class="clear"></div>
            
            <div class="section-social">
            <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->socialMenu());?>            
            <div class="clear"></div>
            </div>               
            
          </div>                              
        </div>
     </div>
  </div> <!--END main-->
</div> <!--END header-wrap-->

<?php Widgets::orderBar();?>
<?php Widgets::merhantSignupBar();?>

<?php 
if ( Yii::app()->controller->action->id =="index"){
	if (getOptionA('home_search_mode')!="postcode"){
		if ( getOptionA('enabled_advance_search') =="yes"){
		   Widgets::searchAdvanced();
		} else Widgets::searchBox();
	} else {
		Widgets::searchByZipCodeOptions();
	}
}
?>


<div class="content">
 <?php echo $content;?>
</div> <!--END content-->

<?php if ( Yii::app()->controller->action->id =="index"):?>
<?php if ( Yii::app()->functions->getOptionAdmin('disabled_featured_merchant')!="yes"):?>
<?php Widgets::featuredMerchant();?>
<?php endif;?>
<?php endif;?>

<div class="footer-wrap">

<div class="back-top" data-uk-scrollspy="{cls:'uk-animation-fade', repeat: true}" >
   <a href="#header-wrap" data-uk-smooth-scroll ><i class="fa fa-arrow-up"></i></a>
   <!--<a href="#header-wrap" class="to-top" data-uk-smooth-scroll ></a>-->
</div>

 <div class="main">
    <div class="uk-grid">
      <div class="uk-width-1-4 footer-address-wrap" >
          <ul>           
           <li class="footer-address">
           <?php echo Yii::app()->functions->getOptionAdmin('website_address') ." ".yii::app()->functions->adminCountry();?>    </li>
           <li class="footer-contactphone">
             <?php echo Yii::t("default","Call Us")?> <?php echo Yii::app()->functions->getOptionAdmin('website_contact_phone');?>
           </li>
           <li class="footer-contactmail">
           <?php echo Yii::app()->functions->getOptionAdmin('website_contact_email');?>
          </li>
          </ul>
      </div>
      <div class="uk-width-1-4 footer-buttom-menu-wrap" >
         <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->bottomMenu());?>            
      </div>
      
      <div class="uk-width-1-4 footer-buttom-menu-wrap" >
         <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->bottomMenu('bottom2'));?>            
      </div>
      
      <div class="uk-width-1-4 footer-social-wrap" >
         <p><?php echo Yii::t("default","Stay in touch")?></p>          
          <div class="footer-soocial">
          <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->socialMenu());?>            
          </div>
      </div>
    </div> <!--END uk-grid-->
 </div>
</div> <!--END footer-wrap-->

<div class="footer-sub">
  <div class="main">
     <div class="footer-a left">
     <p><?php echo Yii::t("default","Copyright")."&copy;".date("Y")?> <?php echo yii::app()->functions->getOptionAdmin('website_title')?></p>
     </div>
     
     <?php $disabled_subscription=Yii::app()->functions->getOptionAdmin('disabled_subscription')?>
     <?php if ($disabled_subscription!="yes"):?>
     <form method="POST" onsubmit="return false;" id="frm-subscribe" class="frm-subscribe">
     <?php echo CHtml::hiddenField('action','subscribeNewsletter')?>
     <div class="footer-b right">
     <div class="tbl-wraper">
        <div class="tbl-col">
        <p><?php echo t("Subscribe to our latest news")?>:</p>
        </div>
        <div class="tbl-col">
        <?php echo CHtml::textField('subscriber_email','',array(
         'placeholder'=>t("Your email")         
         ))?>
        </div>
        <div class="tbl-col">
        <?php echo CHtml::submitButton('submit_subscribe',array('value'=>t("Subscribe")))?>
        </div>
     </div> <!-- tbl-wraper-->    
     </div><!-- footer-b-->
     </form>
     <?php endif;?>
     
     <div class="clear"></div>
     
  </div>
</div> <!--END footer-sub-->
<?php ScriptManager::registerGlobalVariables();?>
</body>
</html>