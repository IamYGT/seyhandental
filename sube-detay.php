<?php include("admin/include/site_db.php"); ?>   <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l <?=$db->VeriOkuTek("sube_category", "sube_isim", "url", $_GET["url"]);?></title>

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

            <h1><?=$db->VeriOkuTek("sube_category", "sube_isim", "url", $_GET["url"]);?>  </h1>
         </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li class="active"><?=$db->VeriOkuTek("sube_category", "sube_isim", "url", $_GET["url"]);?>  </li>
            </ol>

        </div>
    </div>
</div>
 
 <div    class="blog blog-2">
    <div class="container">
        <div class="row">
            
            <div class="blog-container col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
    
                <div class="blog-item">
                      
                            <div class="image-carousel">

                                <div class="owl-image-carousel" id="owl-image-carousel">
                                    
                                  <?php 
$cat_id = $db->VeriOkuTek("sube_category", "id", "url", $_GET["url"]);
$db->VeriOkuCoklu("sube_items",array("cat_id"),array($cat_id));
$veriler = $db->bilgial;
foreach ($veriler as $veri){
	?>
                                    <div class="image-carousel-item">
                                        <img src="upload/<?=$veri->resim;?>" alt="Adana Seyhan Özel Diş Kliniği" />
                                        
                                    </div>
		<?php }?>
                                </div>
                                
                                <div class="carousel-btn carousel-next" id="next-image-carousel"><i class="fa fa-angle-right"></i></div>
                                <div class="carousel-btn carousel-prev" id="prev-image-carousel"><i class="fa fa-angle-left"></i></div>
                                
                            </div>
                           
					 
                    <div class="blog-item-desc single-desc">
                        <div class="blog-item-title"><h3><a href="#"><?=$db->VeriOkuTek("sube_category", "sube_isim", "url", $_GET["url"]);?>  </a></h3></div>
                         <div class="blog-item-text">
                           
                            <div class="quote">
                                <div class="quote-quote"><img src="images/quote.png" alt="Adana Seyhan Özel Diş Kliniği"></div>
Adres: <?=$db->VeriOkuTek("sube_category", "sube_adres", "url", $_GET["url"]);?>                                  <div class="quote-info">
                                    <span class="quote-name">Telefon: <?=$db->VeriOkuTek("sube_category", "sube_telefon", "url", $_GET["url"]);?>  </span>                                </div>
                            </div>
                            
                            
                        </div>
                    </div> 
                </div>
                
                <h3 class="related-items-title">DİĞER ŞUBELERİMİZ</h3>
                    
                    <div class="related-items">
                        
                        <div class="row">
                              
				<?php
if($db->veriSaydir("sube_category", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("sube_category", array(), array(), "row", "ASC",2);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
              
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="blog-item">
                                    <div class="blog-item-image">
                                        <img src="upload/<?=$rows->resim;?>" alt="Adana Seyhan Özel Diş Kliniği" />
                                        <div class="related-item-overlay">
                                            <div class="related-item-title">
                                                <a href="sube-<?=$rows->url;?>.html"><h3><?=$rows->sube_isim;?></h3></a>
                                            </div>
                                            
                                            <div class="related-item-button">
                                                <a href="sube-<?=$rows->url;?>.html" class="btn btn-primary-1 btn-sm">DETAYLAR</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
<?php }} ?>
                        
                        </div>
                        
                    </div>
                    
            </div>
            
        </div>
    </div>
</div>
     
    

 
   <div class="certs">
    <div class="container">
        <div class="row">
            
            <h3>Anlaşmalı Kurumlar</h3>
 
<section class="client">
	<div class="container">
		<div class="row">

			<div class="carousel-client">
				
				<?php
if($db->veriSaydir("sel", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("sel", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
 
				<div class="slide"><img style="       width: 190px;" src="upload/<?=$rows->image;?>"></div>
 
<?php }} ?>

 </div>
		</div> 
	</div>
</section>


             
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.js"></script>


<script>

	/**********************/
	/*	Client carousel   */
	/**********************/
	$('.carousel-client').bxSlider({
		auto: true,
	    slideWidth: 234,
	    minSlides: 2,
	    maxSlides: 5,
	    controls: false
	});
	
	</script>
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
 
<!-- BOOTSTRAP -->
<!-- GOOGLE MAPS -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC1N87a_NHjocaepKKcovPAYTMUkJBr9pQ&amp;language=en&amp;sensor=true"></script>

<style> 

.section-title h2 {
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    padding-bottom: 6px;
    color: #000;
    letter-spacing: 0.3px;
    padding: 0;
}
.section-title::after {
    content: "";
    height: 3px;
    background: #fbb900;
    width: 80px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
}
/****************/
/*	 BX-SLIDER 	*/
/****************/
section.client {
	padding:4em 0em;
 
}
section.client .section-title {
	margin-bottom: 6em;
}
.bx-controls {
	position: relative;
}
.bx-wrapper .bx-pager {
    text-align: center;
    padding-top: 30px;
}
.bx-wrapper .bx-pager .bx-pager-item, .bx-wrapper .bx-controls-auto .bx-controls-auto-item {
    display: inline-block;
    *zoom: 1;
    *display: inline;
}
.bx-wrapper .bx-pager.bx-default-pager a {
    background: #666;
    text-indent: -9999px;
    display: block;
    width: 10px;
    height: 10px;
    margin: 0 5px;
    outline: 0;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
}



</style> 

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>