<?php include("admin/include/site_db.php"); ?>   <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l Galeri </title>
 <meta name="description" content="Mirzadiş Galeri -  Özel Diş Kliniği Olan Mirzadent, Mirzadiş Gaziantep Özel Kliniği Tel: 444 10 63" />
<meta name="keywords" content="Gaziantep'te, Özel Diş Kliniği, Olan, Mirzadent, Mirzadiş, Gaziantep Özel Diş Poliklinik, Hizmeti veren, Bir Diş, Kliniğidir. Diş Kliniği Tel: 444 10 63" />

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


<div class="page-title page-title-gallery2 bg-pattern" data-bgcolor="014087">
    <div class="page-title-overlay">
        <div class="container">

            <h1>Galeri</h1>
            <p>Hayatlarını değiştirdiğimiz hastalarımızın önceki ve sonraki görselleri.</p>

        </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Anasayfa</a></li>
                <li class="active">Galeri</li>
            </ol>
            
        </div>
    </div>
</div>


<div class="gallery gallery-2">
    <div class="container">
        <div class="row">
             
            
<?php
if($db->veriSaydir("sizden", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("sizden", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
            <div class="gallery-2-items col-sm-6">
 <div class="gallery-2-item col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="gallery-2-item-images">
                        <div class="gallery-2-item-image">
                            <img style="width:280px; height:200px;" src="upload/<?=$rows->once;?>" alt="Adana Seyhan Özel Diş Kliniği">  
                            <div class="gallery-2-item-image-title">ÖNCE</div>
                        </div>
                        <div class="gallery-2-item-image">
                            <img style="width:280px; height:200px;" src="upload/<?=$rows->sonra;?>" alt="Adana Seyhan Özel Diş Kliniği">
                            <div class="gallery-2-item-image-title">SONRA</div>
                        </div>
                    </div>
                    <div class="gallery-2-item-info">
                        <h4 class="gallery-2-item-title"><?=$rows->isim;?></h4>
                        <p class="gallery-2-item-desc"><?=$rows->yorum;?></p>
                    </div>
                </div>
        
                
            </div>
            
           <?php }} ?>
            
        </div>
    </div>
</div>
    

<div class="make">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 make-text">
                <h2>İLETİŞİME GEÇ!</h2>
                <p>Sizinde diş ile ilgili sorununuz varsa randevu almaktan çekinmeyin.</p>
            </div>
            
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 make-button">
                <a href="iletisim" class="btn btn-default"><span class="plus">+</span> İLETİŞİM</a>
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