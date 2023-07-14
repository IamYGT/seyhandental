<?php include("admin/include/site_db.php"); ?>   <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l Şubelerimiz </title>
 <meta name="description" content="Adana, Seyhan'da Seyhan Özel Diş Kliniği , Seyhan Adana Özel Diş Poliklinik Hizmeti veren Bir Diş Kliniğidir. Diş Kliniği Tel: <?=$db->ayarlar("value" , "tel");?>" />
 
<!-- =========================
      FAV AND TOUCH ICONS  
============================== -->
<?php include("favo.php"); ?>

<!-- =========================
     STYLESHEETS   
============================== -->

<link rel="stylesheet" type="text/css" href="css\master.css">

</head>

<body data-spy="scroll" data-target=".navbar">
    
	
	 <?php include("ust.php") ?>
<div class="page-title page-title-about bg-pattern" data-bgcolor="014087">
    <div class="page-title-overlay">
        <div class="container">

            <h1>Şubelerimiz</h1>
         </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li class="active">Şubelerimiz</li>
            </ol>
            
        </div>
    </div>
</div>
<div style="
       padding: 12px 12px 241px;

    margin-top: -110px"  class="gallery gallery-1">
    <div class="container">
        <div class="row">
            
      
            
            <div class="gallery-1-items" id="isotope-items">
                
				<?php
if($db->veriSaydir("sube_category", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("sube_category", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
              
			  <div class="gallery-1-item isotope-item col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                    <div class="gallery-1-item-image">
                        <img src="upload/<?=$rows->resim;?>" alt="Adana Seyhan Özel Diş Kliniği" />
                        <a href="sube-<?=$rows->url;?>.html">
                            <div class="gallery-1-item-overlay">
                                <i class="fa fa-plus"></i>
                            </div>
                        </a>
                    </div>    
                    <div class="gallery-1-item-info">
                       <a href="sube-<?=$rows->url;?>.html">  <h4 class="gallery-1-item-title"><?=$rows->sube_isim;?></h4> </a>
                        <p class="gallery-1-item-desc"><?=$rows->sube_adres;?></p>
                    </div>
                </div>
                
             
<?php }} ?>
			 
            </div>
            
            
        </div>
    </div>
</div>
    
	 <?php include("alt.php") ?> 
    
<link rel="stylesheet" type="text/css" href="css\responsive.css">
    
<!-- =========================
     SCRIPTS   
============================== -->	
<!-- JQUERY -->
<script src="js\jquery-2.2.0.min.js"></script>

<!-- BOOTSTRAP -->
<script src="js\bootstrap.min.js"></script>

<!-- SLIDER PRO -->
<script src="js\jquery.sliderPro.min.js"></script>
    
<!-- LIGHTBOX -->
<script src="js\jquery.fancybox.pack.js"></script>

<!-- CAROUSEL -->
<script src="js\owl.carousel.js"></script>

<!-- STAR RATING -->
<script src="js\jquery.barrating.min.js"></script>   

<!-- ISOTOPE FILTER -->
<script src="js\isotope.pkgd.min.js"></script>

<!-- SCROLLSPY -->
<script src="js\scrollspy.js"></script>

<!-- DATEPICKER -->
<script src="js\moment.js"></script>
<script src="js\bootstrap-datetimepicker.min.js"></script>
 
<!-- FORM VALIDATOR -->
<script src='js\jquery.form-validator.js'></script>
    
<!-- SELECT STYLING -->
<script src='js\jquery.selectBox.js'></script>

<!-- CUSTOM SCRIPT -->
<script src="js\theme.js"></script>

<!-- GOOGLE MAPS -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC1N87a_NHjocaepKKcovPAYTMUkJBr9pQ&amp;language=en&amp;sensor=true"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>