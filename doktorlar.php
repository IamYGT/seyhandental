<?php include("admin/include/site_db.php"); ?>   <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l Doktorlar </title>

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
<div class="page-title page-title-doctor bg-pattern" data-bgcolor="014087">
    <div class="page-title-overlay">
        <div class="container">

            <h1>DOKTORLARIMIZ</h1>
            <p>Hekimlerimiz akademisyen kimlikleriyle uzman oldukları alanlarda bilim ve sanatı birleştirerek bu adreste bilgi ve deneyimlerini sizlerle paylaşmaktadır.</p>

        </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Anasayfa </a></li>
                <li class="active">Doktorlar</li>
            </ol>
            
        </div>
    </div>
</div>
     
<div class="doctors doctors-2">
    <div class="container">
        <div class="row">
            
            <h2 class="section-title">DOKTORLARIMIZ</h2>
            
            <div class="doctors-container">
                    

<?php
if($db->veriSaydir("doktor", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("doktor", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
                    <div class="doctors-item col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="doctors-item-container">
                            <div class="doctors-item-image">
                                <img src="upload/<?=$rows->resim;?>" alt="Adana Seyhan Özel Diş Kliniği">
                            </div>
                            <div class="doctors-item-name"><?=$rows->isim;?></div>
                            <div class="doctors-item-position"><?=$rows->unvan;?></div>
                        </div>
                        <div class="doctors-item-social">
                            <a href="<?=$rows->facebook;?>"><i class="fa fa-facebook"></i></a> 
                            <a href="<?=$rows->twitter;?>"><i class="fa fa-twitter"></i></a> 
                            <a href="<?=$rows->instagram;?>"><i class="fa fa-instagram"></i></a> 
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