<?php 
	session_start();
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	ob_start("ob_gzhandler"); 
	}
	else {
	ob_start(); 
	}

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	header('Content-Type: text/html; charset=utf-8');


	include("include/static.php");
	include("include/function.php");
	include("include/db.php");
	
	$db = new dbcon();
	
	$referrer_page = explode("/", $_SERVER["HTTP_REFERER"]);
	unset($_SESSION[$session_value . "_email"]);

	if($_POST) {
		if($db->VeriSaydir("managers",array("email", "password"),array($_POST["email"],md5($_POST["password"]))) > 0) {
			$_SESSION[$session_value] = $db->VeriOkuTek("managers", "id", "email", $_POST["email"]);
			header("Location: index.php");
		}
	} else if($_GET["email"] != "" and $referrer_page[2] == "connection.rame.com.tr") {
		if($db->VeriSaydir("managers",array("email", "password"),array($_GET["email"],$_GET["password"])) > 0) {
			$_SESSION[$session_value] = 1;
			header("Location: index.php");
		}
	}
	
	if($_GET["logout"] != "") {
		unset($_SESSION[$session_value]);
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=description;?>">
        <meta name="author" content="<?=author;?>">
        <title><?=site_name;?></title>
		<link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-touch-icon-57x57.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-touch-icon-60x60.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-touch-icon-72x72.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-touch-icon-76x76.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-touch-icon-114x114.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-touch-icon-120x120.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-touch-icon-144x144.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-touch-icon-152x152.png?v=kPP4KpWvzR">
		<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon-180x180.png?v=kPP4KpWvzR">
		<link rel="icon" type="image/png" href="assets/favicon/favicon-32x32.png?v=kPP4KpWvzR" sizes="32x32">
		<link rel="icon" type="image/png" href="assets/favicon/favicon-194x194.png?v=kPP4KpWvzR" sizes="194x194">
		<link rel="icon" type="image/png" href="assets/favicon/favicon-96x96.png?v=kPP4KpWvzR" sizes="96x96">
		<link rel="icon" type="image/png" href="assets/favicon/android-chrome-192x192.png?v=kPP4KpWvzR" sizes="192x192">
		<link rel="icon" type="image/png" href="assets/favicon/favicon-16x16.png?v=kPP4KpWvzR" sizes="16x16">
		<link rel="manifest" href="assets/favicon/manifest.json?v=kPP4KpWvzR">
		<link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg?v=kPP4KpWvzR" color="#ed1e1e">
		<link rel="shortcut icon" href="assets/favicon/favicon.ico?v=kPP4KpWvzR">
		<meta name="theme-color" content="#ffffff">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        
    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"><strong class="text-custom"><img src="assets/images/logo_white.png"/></strong> </h3>
            </div> 


            <div class="panel-body">
            <form class="form-horizontal m-t-20" method="post" action="login.php">
				<?php if($_POST or ($_GET["email"] != "" and $referrer_page[2] == "yonlendir.rame.com.tr")) { ?>
				<div class="alert alert-danger">
				  <strong>Hata!</strong> E-posta adresiniz veya parolanız yanlıştır
				</div>
				<?php } ?>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" name="email" type="email" required="" placeholder="E-posta">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" name="password" type="password" required="" placeholder="Parola">
                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Giriş Yap</button>
                    </div>
                </div>
            </form> 
            
            </div>   
            </div>                              
           
        </div>
        
        

        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>


        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	
	</body>
</html>