
<div class="preloader" id="preloader">
    <img src="images/preloader.gif" alt="Adana Seyhan Özel Diş Kliniği">
</div>   
<div style="    background: url(images/arka.png) repeat !important;
    background-color: #f1f8f9!important;
"  class="header" id="header">
    <div class="container">
        <div class="row">
            
 			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                <div class="header-logo">
                    <a href="index"><img src="images/logo.png" alt="Adana Seyhan Özel Diş Kliniği">
						</a>
                </div>
			</div>
			
 			<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                <div class="header-button hidden-xs">
                    <a href="iletisim" class="btn btn-default"><span class="plus">+</span> İLETİŞİM</a>
                </div>
                <div class="header-phone"> 
                    <i class="fa fa-phone"></i> <?=$db->ayarlar("value" , "tel");?>
                </div>
			</div>

			
		</div>
	</div>
</div> 
<div class="top-menu" id="top-menu">
    <div class="container">
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-bar-cont">
                    <div class="top-menu-logo">
                        <a href="index"><img src="images/kucuk_logo.png" alt="Adana Seyhan Özel Diş Kliniği">
                         </a>
                    </div>
                    <div class="mobile-bar">
                        <div class="show-menu" id="show-menu">
                            <i class="fa fa-bars"></i>
                        </div> 
                    </div>
                </div>
                <ul class="nav navbar-nav">
                    <li ><a href="index" >ANASAYFA</a></li>
                    <li><a href="hakkimizda">HAKKIMIZDA</a></li> 
                    <li class="dropdown ">
                        <a data-toggle="dropdown" href="#">HİZMETLERİMİZ</a>
                        <ul class="dropdown-menu with-bg"" role="menu">
<?php
if($db->veriSaydir("hizmet", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("hizmet", array(), array(), "row", "ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>   
                            <li><a href="hizmet-<?=$rows->url;?>.html"><?=$rows->h_isim;?></a></li>
					 	<?php }} ?>

                        </ul>
                    </li>
                    <li><a href="doktorlar">DOKTORLARIMIZ</a></li> 
                    <li><a href="subelerimiz">ŞUBELERİMİZ</a></li> 
                    <li><a href="galeri">GALERİ</a></li> 
                    <li><a href="blog">BLOG</a></li> 
					<li><a href="iletisim">İLETİŞİM</a></li>
                </ul>
            </div>
		</div>
	</div>
</div> 
