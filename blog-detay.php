<?php include("admin/include/site_db.php"); ?> 
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
 <title> <?=$db->ayarlar("value" , "siteismi");?> l <?=$db->VeriOkuTek("blog", "isim", "url", $_GET["url"]);?>  </title>

<!-- =========================
      FAV AND TOUCH ICONS  
============================== -->
<link rel="shortcut icon" href="images/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

<!-- =========================
     STYLESHEETS   
============================== -->

<link rel="stylesheet" type="text/css" href="css/master.css" />

</head>

<body data-spy="scroll" data-target=".navbar">
    

<?php include("ust.php") ?>
<div class="page-title page-title-blog bg-pattern" data-bgcolor="014087">
    <div class="page-title-overlay">
        <div class="container">

            <h1><?=$db->VeriOkuTek("blog", "isim", "url", $_GET["url"]);?></h1>
 
        </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="index"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Blog</a></li>
                <li class="active"><?=$db->VeriOkuTek("blog", "isim", "url", $_GET["url"]);?></li>
            </ol>
            
        </div>
    </div>
</div>
   

<div class="blog blog-2">
    <div class="container">
        <div class="row">
            
            <div class="blog-container col-lg-9 col-md-9 col-sm-9 col-xs-12">
                
    
                <div class="blog-item">
                    <div style="background-position: center !important;" class="blog-item-image">
                        <img src="upload/<?=$db->VeriOkuTek("blog", "resim", "url", $_GET["url"]);?>" alt="Adana Seyhan Özel Diş Kliniği" />
                        
                    </div>
                    <div class="blog-item-desc single-desc">
                        <div class="blog-item-title"><h3><a href="#"><?=$db->VeriOkuTek("blog", "isim", "url", $_GET["url"]);?></a></h3></div>
                        <div class="blog-item-author"><a href="#">Yazan: <?=$db->ayarlar("value" , "siteismi");?></a></div>
                        <div class="blog-item-text">
                            
<p>  <?=$db->VeriOkuTek("blog", "aciklama", "url", $_GET["url"]);?></p>                 

 
                        
                   
                        </div>
                    </div>
                     
                
                 
                </div>
                
                <h3 class="related-items-title">Son Yazılar</h3>
                    
                    <div class="related-items">
                        
                        <div class="row">
                            


<?php
if($db->veriSaydir("blog", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("blog", array(), array(), "row", "ASC",2);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?> 


                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="blog-item">
                                    <div class="blog-item-image">
                                        <img src="upload/<?=$rows->resim;?>" alt="Adana Seyhan Özel Diş Kliniği" />
                                        <div class="related-item-overlay">
                                            <div class="related-item-title">
                                                <a href="blog-<?=$rows->url;?>.html"><h3><?=$rows->isim;?></h3></a>
                                            </div>
                                            <div class="related-item-author">
                                                <a href="blog-<?=$rows->url;?>.html">Yazan: <?=$db->ayarlar("value" , "siteismi");?></a>
                                            </div>
                                            <div class="related-item-button">
                                                <a href="blog-<?=$rows->url;?>.html" class="btn btn-primary-1 btn-sm">DEVAMINI OKU</a>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>


<?php }} ?>
                          
 </div>
                        
                    </div>
                    
            </div>
            
            <div class="right-bar col-lg-3 col-md-3 col-sm-3 col-xs-12">
                
               
                
                <div class="right-bar-categories">
                    <h3 class="right-bar-title"><i class="fa fa-folder-open"></i> Son Yazılar</h3>
                    <ul>


<?php
if($db->veriSaydir("blog", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("blog", array(), array(), "row", "ASC",2);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?> 
                        <li><a href="blog-<?=$rows->url;?>.html"><?=$rows->isim;?></a></li>
 <?php }} ?>
                    </ul>
                </div>
                
                 
                
               
                
            </div>
            
        </div>
    </div>
</div>
     
    
 <?php include("alt.php") ?>
    
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
    
<!-- =========================
     SCRIPTS   
============================== -->	
<!-- JQUERY -->
<script src="js/jquery-2.2.0.min.js"></script>

<!-- BOOTSTRAP -->
<script src="js/bootstrap.min.js"></script>

<!-- SLIDER PRO -->
<script src="js/jquery.sliderPro.min.js"></script>
    
<!-- LIGHTBOX -->
<script src="js/jquery.fancybox.pack.js"></script>

<!-- CAROUSEL -->
<script src="js/owl.carousel.js"></script>

<!-- STAR RATING -->
<script src="js/jquery.barrating.min.js"></script>   

<!-- ISOTOPE FILTER -->
<script src="js/isotope.pkgd.min.js"></script>

<!-- SCROLLSPY -->
<script src="js/scrollspy.js"></script>

<!-- DATEPICKER -->
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
 
<!-- FORM VALIDATOR -->
<script src='js/jquery.form-validator.js'></script>
    
<!-- SELECT STYLING -->
<script src='js/jquery.selectBox.js'></script>

<!-- CUSTOM SCRIPT -->
<script src="js/theme.js"></script>

<!-- GOOGLE MAPS -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC1N87a_NHjocaepKKcovPAYTMUkJBr9pQ&amp;language=en&amp;sensor=true"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>