<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=description;?>">
        <meta name="author" content="<?=author;?>">
        <title><?=site_name;?></title>
 		<meta name="theme-color" content="#00698c">

		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
        <link href="assets/plugins/custombox/dist/custombox.min.css" rel="stylesheet">

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
        <link href="assets/plugins/c3/c3.min.css" rel="stylesheet" type="text/css"  />
        <link href="assets/plugins/bootstrapvalidator/src/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.php" class="logo"><i class="icon-c-logo"><img src="assets/images/logo_mini.png"/></i><span><img src="assets/images/logo_dark.png"/></span></a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>



                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="icon-bell"></i> <span class="badge badge-xs badge-danger"><?=$db->veriSaydir("notification",array("been_read"),array(0));?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="notifi-title"><span class="label label-default pull-right"><?=$db->veriSaydir("notification",array("been_read"),array(0));?> Yeni Bildirim</span>Bildirimler</li>
                                        <li class="list-group nicescroll notification-list">
<?php
if($db->veriSaydir("notification",array("been_read"),array(0)) > 0) {
$bilgi= $db->VeriOkuCoklu("notification",array("been_read"),array(0), "id", "DESC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
?>
                                           <a href="<?=$rows->url;?>" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left p-r-10">
                                                    <em class="fa <?=$rows->icon;?> fa-2x text-primary"></em>
                                                 </div>
                                                 <div class="media-body">
                                                    <h5 class="media-heading"><?=$rows->name;?></h5>
                                                    <p class="m-0">
                                                        <small><?=$rows->explanation;?></small>
                                                    </p>
                                                 </div>
                                              </div>
                                           </a>
<?php }} else { ?>
	                                        <div class="media text-center font-600 text-danger">Yeni bildirim yok</div>
<?php } ?>
                                        </li>
                                        <li>
                                            <a href="notification.php" class="list-group-item text-right">
                                                <small class="font-600">Tüm Bildirimleri Göster</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>

                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="assets/images/avatar.jpg" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="profile.php"><i class="ti-user m-r-5"></i> Profil</a></li>
                                        <li><a href="lock-screen.php"><i class="ti-lock m-r-5"></i> Ekranı Kilitle</a></li>
                                        <li><a href="login.php?logout=<?=rand();?>"><i class="ti-power-off m-r-5"></i> Çıkış Yap</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                        	<li class="text-muted menu-title">Menü</li>
                            <li <?php if($page == "main") { echo 'class="active"'; } ?> class="has">
                                <a href="index.php" class="waves-effect  <?php if($page == "main") { echo 'active'; } ?>"><i class="ti-home"></i> <span> Gösterge Paneli </span> </a>
                            </li>
<?php
if($db->veriSaydir("modul",array("status"),array(1)) > 0) {
$bilgi= $db->VeriOkuCoklu("modul",array("status"),array(1), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
?>
                            <li <?php if($page == $rows->url) { echo 'class="active"'; } ?> class="has">
                                <a href="index.php?page=<?=$rows->url;?>" class="waves-effect  <?php if($page == $rows->url . ".php") { echo 'active'; } ?>"><i class="<?=$rows->icon;?>"></i> <span> <?=$rows->name;?> </span> </a>
                            </li>
<?php }} ?>
                            <li <?php if($page == "settings.php") { echo 'class="active"'; } ?> class="has">
                                <a href="index.php?page=settings" class="waves-effect  <?php if($page == "settings.php") { echo 'active'; } ?>"><i class="ti-settings"></i> <span> Genel Ayarlar </span> </a>
                            </li>
                            <li <?php if($page == "module") { echo 'class="active"'; } ?> class="has">
                                <a href="index.php?page=module" class="waves-effect  <?php if($page == "module.php") { echo 'active'; } ?>"><i class="ti-paint-bucket"></i> <span> Modül Yönetimi </span> </a>
                            </li>
                            <li <?php if($page == "managers.php") { echo 'class="active"'; } ?> class="has">
                                <a href="index.php?page=managers" class="waves-effect  <?php if($page == "managers.php") { echo 'active'; } ?>"><i class="ti-crown"></i> <span> Yönetici Listesi </span> </a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">