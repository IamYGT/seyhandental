<?php  include("admin/include/site_db.php"); 

$sayfada = 2;
$toplam_icerik = $db->VeriSaydir("blog");
$toplam_sayfa = ceil($toplam_icerik / $sayfada);
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 


?>  <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="Adana Seyhan Blog - Sizler İçin Yazıyoruz. Özel Diş Kliniği Olan Seyhan, Seyhan Adana Özel Kliniği Tel: <?=$db->ayarlar("value" , "tel");?>" />
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l Blog</title>

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
<div class="page-title page-title-blog bg-pattern" data-bgcolor="014087" style="    background-color: #014087 !important;" >
    <div class="page-title-overlay">
        <div class="container">

            <h1>Blog</h1>
            <p>Sizleri bilgilendirmek amacıyla sizlere haftalık blog yazıyoruz!</p>

        </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Anasayfa</a></li>
                <li class="active">Blog</li>
            </ol>
            
        </div>
    </div>
</div>
   

<div class="blog blog-2">
    <div class="container">
        <div class="row">
            
            <div class="blog-container col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    
                <div class="row">
                    


<?php
if($db->veriSaydir("blog", array(), array()) > 0) {
$limit = ($sayfa - 1) * $sayfada;
$bilgi= $db->VeriOkuCoklu("blog", array(), array(), "row", "DESC",$limit .', '. $sayfada);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?> 

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        
                        <div class="blog-item">
                            <div class="blog-item-image">
                                <img src="upload/<?=$rows->resim;?>" alt="Adana Seyhan Özel Diş Kliniği">
                             </div>
                            <div class="blog-item-desc">
                        <div class="blog-item-title"><h3><a href="blog-<?=$rows->url;?>.html"><?=$rows->isim;?> </a></h3></div>
                        <div class="blog-item-author"><a href="blog-<?=$rows->url;?>.html">Yazan: <?=$db->ayarlar("value" , "siteismi");?></a></div>
                        <div class="blog-item-text">  <?=substr($rows->aciklama,0,228);?>...</div>
                        <div class="blog-item-button"><a href="blog-<?=$rows->url;?>.html" class="btn btn-primary-1">Devamı</a></div>
                   
                            </div>
                        </div>
                    </div>
                    
                            


<?php }} ?>
                 
                    
                </div>
                
                <ul class="pagination">
<?php 
		$sayfa_goster = 4; // gösterilecek sayfa sayısı
		$en_az_orta = ceil($sayfa_goster/2);
		$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
		$sayfa_orta = $sayfa;
		if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
		if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
		$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
		$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
		if($sol_sayfalar < 1) $sol_sayfalar = 1;
		if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
 
		if($sayfa != 1) echo '<li><a class="first" href="href="?sayfa=1"><i class="fa fa-angle-left"></i></a></li> ';
		if($sayfa != 1) echo ' <li><a class="last" href="?sayfa='.($sayfa-1).'"><i class="fa fa-angle-right"></i></a></li> ';
 
		for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
			if($sayfa == $s) {
				echo '<li><a href="#" class="tran3s active">' . $s . '</a></li>';
			} else {
			echo '<li><a class="tran3s" href="?sayfa='.$s.'">'.$s.'</a></li>';
			}
		}
 
		if($sayfa != $toplam_sayfa) echo ' <li><a href="?sayfa='.($sayfa+1).'"><i class="fa fa-angle-left"></i></a></li> ';
		if($sayfa != $toplam_sayfa) echo ' <li><a href="?sayfa='.$toplam_sayfa.'"><i class="fa fa-angle-right"></i></a></li>';
		?>
 
                </ul>
                    
            </div>
            
            <div class="right-bar col-lg-3 col-md-3 col-sm-3 col-xs-12">
              
                
                <div class="right-bar-categories">
                    <h3 class="right-bar-title"><i class="fa fa-folder-open"></i> SON YAZILAR</h3>
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