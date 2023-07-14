<?php include("admin/include/site_db.php"); ?>   <!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- SITE TITLE -->
<title> <?=$db->ayarlar("value" , "siteismi");?> l İletişim </title>
 <meta name="description" content="Seyhan Dental Adana Özel Ağız ve Diş Sağlığı Kliniği Tel: 0322 459 08 23" />
<meta name="keywords" content="Adana'da, Özel Diş Kliniği, Olan, Özel Seyhan, Seyhan Dental, Adana Özel Diş Poliklinik, Hizmeti veren, Bir Diş, Kliniğidir. Diş Kliniği Tel: 0322 459 08 23" />

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

<div class="page-title page-title-contacts bg-pattern" data-bgcolor="014087">
    <div class="page-title-overlay">
        <div class="container">

            <h1>İletişim</h1>
            <p>Bize Adresimizden ulaşabilir veya telefondan arayarak iletişim kurabilirsiniz.</p>

        </div>
    </div>
</div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            
            <ol class="breadcrumb">
                <li class="breadcrumb-home"><a href="#"><i class="fa fa-home"></i></a></li>
                <li class="active">İletişim</li>
            </ol>
            
        </div>
    </div>
</div> 
  
<div class="feedback">
    <div class="container">
        <div class="row">
            
            <h2 class="section-title"><span class="bold700">İletişim</span></h2>
            
            <p class="section-subtitle">Aşşağıdaki form'dan bize İstek & Dileklerinizi iletebilirsiniz.</p>
            
                <form>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item name">
                                <input type="text" name="name" id="name" data-validation="required" placeholder="İsminiz">
                                <div class="help help-sm help-red">!</div>
                            </div>          
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item phone">
                                <input type="text" name="phone" id="phone" data-validation="required" placeholder="Telefon">
                                <div class="help help-sm help-red">!</div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item email">
                                <input type="text" name="email" id="email" placeholder="E-posta">
                            </div>

                        </div>
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item">
                                <textarea name="message" id="message" data-validation="required" placeholder="Mesajınız.."></textarea>
                                <div class="help help-sm help-red">!</div>
                            </div>

                        </div>
                        
                    </div>
                    
                    <div class="row latest-row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 booking-form-item">
                            <button class="btn btn-primary">GÖNDER</button>
                        </div>
                    </div>
                    
                </form>
            
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