<?php include("admin/include/site_db.php"); ?>      <!DOCTYPE html>

<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l Anasayfa</title>
<meta name="description" content="Adana, Seyhan'da Seyhan Özel Diş Kliniği , Seyhan Adana Özel Diş Poliklinik Hizmeti veren Bir Diş Kliniğidir. Diş Kliniği Tel: <?=$db->ayarlar("value" , "tel");?>" />
 
 <?php include("favo.php"); ?>
 
<link rel="stylesheet" type="text/css" href="css\master.css">

</head>

<body data-spy="scroll" data-target=".navbar"> 


<?php include("ust.php") ?>
 <div id="slider" class="slider">
    <div class="sp-slides">
            
            <!-- HEADER SLIDER ITEM -->
			
			
<?php
if($db->veriSaydir("slayt", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("slayt", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
 
	        <div class="sp-slide">
	        	<img class="sp-image" src="css\images\blank.gif" alt="Adana Seyhan Özel Diş Kliniği" data-src="upload/<?=$rows->resim;?>">
                <div class="container">
                    <h3 class="sp-layer slider-welcome" data-position="leftCenter" data-horizontal="15" data-vertical="-370" data-show-transition="left" data-hide-transition="left" data-show-delay="0" data-hide-delay="0">
<?=$rows->baslik1;?>                    </h3>

                    <h1 class="sp-layer slider-title" data-position="leftCenter" data-horizontal="15" data-vertical="-230" data-show-transition="left" data-hide-transition="left" data-show-delay="200" data-hide-delay="200">
<?=$rows->baslik2;?>                    </h1>

                    <h2 class="sp-layer slider-subtitle" data-position="leftCenter" data-horizontal="15" data-vertical="-120" data-show-transition="left" data-hide-transition="left" data-show-delay="400" data-hide-delay="400">
<?=$rows->baslik3;?>                    </h2>
                    
                    <p class="sp-layer slider-text" data-position="leftCenter" data-horizontal="15" data-vertical="80" data-show-transition="left" data-hide-transition="left" data-show-delay="600" data-hide-delay="600">
                        <?=$rows->baslik4;?><br> 
                    </p>
                    
                    <p class="sp-layer slider-button" data-position="leftCenter" data-horizontal="15" data-vertical="300" data-show-transition="left" data-hide-transition="left" data-show-delay="800" data-hide-delay="800">
                        <a href="<?=$rows->buton_link;?>" class="btn btn-primary"><?=$rows->buton_isim;?></a>
                    </p>
                    
                </div>
			</div>
			
			
			<?php }} ?>
            
       </div>
</div>
<!-- =========================
     END HEADER SLIDER
============================== -->

<!-- =========================
     SERVICES
============================== -->
<div class="services" id="services">
    <div class="container-fluid">
        <div class="row">
            
            <!-- SERVICES ITEM -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 service bg-primary-2">
                <div class="service-icon">
                    <i class="flaticon-medical-1"></i>
                </div>
                <div class="service-title">
                    <h3>DİŞ İMPLANTI</h3>
                </div>
                <div class="service-text">
Diş İmplantları, eksik olan dişlerin yerine, çene kemiğine yerleştirilen titanyumdan yapılmış vidalardır.                </div>
            </div>
            
            <!-- SERVICES ITEM -->
            <div style="    background: #1c394a;"  class="col-lg-3 col-md-3 col-sm-3 col-xs-12 service bg-child-2">
                <div class="service-icon">
                    <i class="flaticon-medical-2"></i>
                </div>
                <div class="service-title">
                    <h3>ESTETİK DİŞ HEKİMLİĞİ</h3>
                </div>
                <div class="service-text">
Diş çürüklerinin, renkleşmiş dişlerin , aralıklı dişlerin, kırık dişlerin, şekil bozukluğu olan dişlerin,tedavisini gerçekleştirir. .
                </div>
            </div>
            
            <!-- SERVICES ITEM -->
            <div style="        background: #014087;" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 service bg-child-3">
                <div class="service-icon">
                    <i class="flaticon-tool"></i>
                </div>
                <div class="service-title">
                    <h3>DİŞ BEYAZLATMA</h3>
                </div>
                <div class="service-text">
Diş beyazlatma olarak bilinen ‘bleaching’ işlemi temel olarak; kimyasal ajanlar kullanılarak dişlerin rengini kalıcı olarak beyazlatma işlemidir. .
                </div>
            </div>
            
            <!-- SERVICES ITEM -->
            <div style="        background: #1c394a;" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 service bg-child-4">
                <div class="service-icon">
                    <i class="flaticon-medical"></i>
                </div>
                <div class="service-title">
                    <h3>ENDODONTİ</h3>
                </div>
                <div class="service-text">
Kendini tamir edemeyecek şekilde hasar gördüğü durumlarda uygulanan bir tedavi şeklidir .
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
     END SERVICES
============================== -->
 
    
<!-- =========================
     ABOUT
============================== -->    
<div class="about">
    <div class="container">
        <div class="row">
            
            <!-- ABOUT TEXT -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 about-text">
                <h2  class=""><span class="bold700"> <?=$db->ayarlar("value" , "siteismi");?> </span></h2>
                <p style="margin:0px 0px 0px 0px"><?=$db->ayarlar("value" , "hakkimizda");?></p>
             </div>
            
            <!-- ABOUT BACKGROUND -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 about-bg">
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
     END ABOUT
============================== -->
    
 
<!-- =========================
     CERTIFICATES
============================== --> 
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
<!-- =========================
     END CERTIFICATES
============================== -->
    

<!-- =========================
     DOCTORS
============================== -->
<div class="doctors">
    <div class="container">
        <div class="row">
            
            <h2 class="section-title"> DOKTORLARIMIZ </h2>
            <p class="section-subtitle">Hekimlerimiz akademisyen kimlikleriyle uzman oldukları alanlarda bilim ve sanatı <br> birleştirerek bu adreste bilgi ve deneyimlerini sizlerle paylaşmaktadır.</p>
            
            <div class="doctors-container">
                <div class="owl-doctors" id="owl-doctors">
                     
 
<?php
if($db->veriSaydir("doktor", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("doktor", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   

 <div class="doctors-item">
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
                <!-- DOCTORS BUTTONS -->
                <div class="carousel-btn carousel-next" id="next-doctors"><i class="fa fa-angle-right"></i></div>
                <div class="carousel-btn carousel-prev" id="prev-doctors"><i class="fa fa-angle-left"></i></div>
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
     END DOCTORS
============================== -->
    

<!-- =========================
     BOOKING FORM
============================== -->
<div class="booking">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 booking-form">
                <h2 class="section-title"><span class="bold700">Randevu Al</span></h2>
               <?php
if($_POST) {
	if($_POST["ad"] == "" or $_POST["telefon"] == "") {
		echo "Boş bırakılamaz";
	} else {
		if($db->veriEkle("randevu", array("NULL", "?", "?", "?", "?", "?", "?"), array($_POST["ad"], $_POST["telefon"], $_POST["eposta"], $_POST["tarih"],$_POST["saat"], $_POST["mesaj"])) == 1) {
			echo '<div class="alert alert-success"> Başarılı </div>';
		} else {
			echo '<div class="alert alert-warning"> Başarısız </div>';
		}
	}
}
?>
 <form    action="" method="post"  id="randevu">
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item name">
                            <input type="text" name="ad" id="ad" data-validation="required" placeholder="İsminiz">
                            <div class="help help-sm help-red">!</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 booking-form-item phone">
                            <input type="text" name="telefon" id="telefon" data-validation="required" placeholder="Telefon">
                            <div class="help help-sm help-red">!</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 booking-form-item email">
                            <input type="text" name="eposta" id="eposta" placeholder="E-mail">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 booking-form-item date">
                            <input type="text" class="datepicker-f" id="tarih" name="tarih" data-validation="required" placeholder="Tarih">
                            <div class="help help-sm help-red">!</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 booking-form-item time-f">
                            <input type="text" class="timepicker-f" id="saat" name="saat" data-validation="required" placeholder="Saat">
                            <div class="help help-sm help-red">!</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item">
                            <textarea name="mesaj" id="mesaj" placeholder="Mesajınız.."></textarea>
                        </div>
                    </div>
                    
                    <div class="row latest-row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 booking-form-item">
                            <button class="btn btn-primary">GÖNDER</button>
                        </div>
                       
                    </div>
                    
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
     END BOOKING FORM
============================== -->

    
<!-- =========================
     NUMBERS
============================== -->
<div class="numbers" id="numbers">
    <div class="numbers-overlay">
        <div class="container">
            <div class="row">

                <h2 class="section-title"><span class="bold700">RAKAMLARLA</span> KLİNİĞİMİZ</h2>
                <p class="section-subtitle"> Sizlere verdiğimiz önceliği , sevgiyi ve en önemlisi tecrübemizi <br> birde rakamlarla inceleyelim!</p>
                
                <!-- NUMBERS ITEM -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 numbers-item">
                    <div id="num1" class="numbers-item-number"><?=$db->ayarlar("value" , "tecrube");?></div>
                    <div class="numbers-item-title">YILLIK<br>TECRÜBE</div>
                </div>
                
                <!-- NUMBERS ITEM -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 numbers-item">
                    <div id="num2" class="numbers-item-number"><?=$db->ayarlar("value" , "hasta");?></div>
                    <div class="numbers-item-title">MUTLU HASTA</div>
                </div>
                
                <!-- NUMBERS ITEM -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 numbers-item">
                    <div id="num3" class="numbers-item-number"><?=$db->ayarlar("value" , "sel");?></div>
                    <div class="numbers-item-title">SELTİFİKA</div>
                </div>
                
                <!-- NUMBERS ITEM -->
                

            </div>
        </div>
    </div>
</div>
<!-- =========================
     END NUMBERS
============================== -->

    
<!-- =========================
     STORIES
============================== -->
<div class="stories">
    <div class="container">
        <div class="row">
            
            <h2 class="section-title"><span class="bold700">SİZDEN</span> GELENLER</h2>
            <p class="section-subtitle">Bir gülümseme bir hayattır..</p>
            
            <div class="certs-container">
                <div class="owl-stories" id="owl-stories">
                 
                    

<?php
if($db->veriSaydir("sizden", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("sizden", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   

                    <!-- STORIES ITEM -->
                    <div class="stories-item">
                        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
                            <div class="stories-item-name">
                                <?=$rows->isim;?>
                            </div>
                            <div class="stories-item-position">
                                <?=$rows->unvan;?>
                            </div>
                            <div class="stories-item-rating">
                                <select id="stories-rating-1" name="stories-rating-1">
                                    <option value="1">1
                                    <option value="2">2
                                    <option value="3">3
                                    <option value="4">4
                                    <option value="5">5
                                </select>
                            </div>
                            <div class="stories-item-text">
                                <div class="stories-item-text-quote"><img src="images\quote.png" alt="Adana Seyhan Özel Diş Kliniği"></div>
                               <?=$rows->yorum;?>
                            </div>
                            
                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                            <div class="stories-item-before">
                                <img  style="width:300px; height:250px;" src="upload/<?=$rows->once;?>" alt="Adana Seyhan Özel Diş Kliniği">
                                <div class="stories-item-before-title">
                                    ÖNCESİ
                                </div>
                            </div>
                            <div class="stories-item-after">
                                <img src="upload/<?=$rows->sonra;?>" alt="Adana Seyhan Özel Diş Kliniği">
                                <div class="stories-item-after-title">
                                    SONRASI
                                </div>
                            </div>
                        </div>
                    </div>
<?php }} ?>
	   
 
                </div>
                <div class="carousel-btn carousel-next" id="next-stories"><i class="fa fa-angle-right"></i></div>
                <div class="carousel-btn carousel-prev" id="prev-stories"><i class="fa fa-angle-left"></i></div>
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
    END STORIES
============================== -->

     
<div class="blog">
    <div class="container">
        <div class="row">

            <h2 class="section-title">SON <span class="bold700">YAZILARIMIZ</span></h2>
            <p class="section-subtitle">Sizleri bilgilendirmek amacıyla sizlere haftalık blog yazıyoruz! <br> Son yazılarımız hemen altta!</p>
            
            <div class="blog-container">
                <div class="owl-blog" id="owl-blog">
                    


<?php
if($db->veriSaydir("blog", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("blog", array(), array(), "row", "ASC",3);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?> 

                    <!-- BLOG ITEM -->
                    <div class="blog-item">
                        <div class="blog-item-image">
                            <img src="upload/<?=$rows->resim;?>" style="width:360px; height:254px;" alt="Adana Seyhan Özel Diş Kliniği">
                            <div style="    right: 0px;" class="blog-item-date"><i class="fa fa-calendar-o"></i> <?=$rows->tarih;?> </div>
                         </div>
                        <div class="blog-item-title"><h3><a href="blog-<?=$rows->url;?>.html"><?=$rows->isim;?> </a></h3></div>
                        <div class="blog-item-author"><a href="blog-<?=$rows->url;?>.html">Yazan: <?=$db->ayarlar("value" , "siteismi");?></a></div>
                        <div class="blog-item-text">  <?=substr($rows->aciklama,0,228);?>...</div>
                        <div class="blog-item-button"><a href="blog-<?=$rows->url;?>.html" class="btn btn-primary-1">Devamı</a></div>
                    </div>
                    
            


<?php }} ?>
                </div>
                <!-- BLOG BUTTONS -->
                <div class="carousel-btn carousel-next" id="next-blog"><i class="fa fa-angle-right"></i></div>
                <div class="carousel-btn carousel-prev" id="prev-blog"><i class="fa fa-angle-left"></i></div>
            </div>
            
        </div>
    </div>
</div>
<!-- =========================
    END BLOG
============================== -->
 
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

<!-- GOOGLE MAPS -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC1N87a_NHjocaepKKcovPAYTMUkJBr9pQ&amp;language=en&amp;sensor=true"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85192583-2', 'auto');
  ga('send', 'pageview');

</script>




<script>

	$('#numbers').on('scrollSpy:enter', function() {
		$('#num1').animate({ num: <?=$db->ayarlar("value" , "tecrube");?> - 1 }, {
			duration: 4000,
			step: function (num){
				this.innerHTML = (num + 1).toFixed(0)
			}
		});
		$('#num2').animate({ num: <?=$db->ayarlar("value" , "hasta");?> - 3 }, {
			duration: 4300,
			step: function (num){
				this.innerHTML = (num + 3).toFixed(0)
			}
		});

		$('#num3').animate({ num: <?=$db->ayarlar("value" , "sel");?> - 1 }, {
			duration: 4600,
			step: function (num){
				this.innerHTML = (num + 1).toFixed(0)
			}
		});

		 
	});

	$('#numbers').scrollSpy();
</script>


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


</body>
</html>