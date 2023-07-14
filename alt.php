<div class="footer">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 footer-matchheight">
                <div class="row">
                    
                    <!-- FOOTER ITEM 1 -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 footer-item footer-item-1">
                        <h3 class="footer-title footer-title-line">Son Yazılarımız</h3>
                        <?php
if($db->veriSaydir("blog", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("blog", array(), array(), "row", "ASC",2);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
 ?>
						<div class="tweet">
                            <div class="tweet-login">
                                <a href="blog-<?=$rows->url;?>.html"><?=$rows->isim;?></a>
                            </div>
                            <div class="tweet-text">
                                <?=substr($rows->aciklama,0,120);?>...
                            </div>
                            <div class="tweet-date"><?=$rows->tarih;?></div>
                        </div>
                     <?php }} ?>
					 </div>
                    
                    <!-- FOOTER ITEM 2 -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 footer-item footer-item-2">
                        <h3 class="footer-title footer-title-line"><i class="fa fa-clock-o"></i> AÇILIŞ SAATLERİ</h3>
                        <div class="opening-left">
                            Pazartesi<br>
                            Salı<br>
                            Çarşamba<br>
                            Perşembe<br>
                            Cuma<br>
                            Cumartesi<br>
                            Pazar      
                        </div>
                        <div class="opening-right">
                             08:00  -  20:00 <br>
                            08:00  -  20:00 <br>
                            08:00  -  20:00 <br>
                            08:00  -  20:00 <br>
                            08:00  -  20:00 <br>
                            08:00  -  20:00 <br>
                            Kapalı
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer-copyright">
                        <div>
                            Copyright 2019 | Her Hakkı Saklıdır.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FOOTER ITEM 3 -->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 footer-item footer-item-3 footer-matchheight" id="footer-item-3">
                <h3 class="footer-title"><i class="fa fa-map-marker"></i> İLETİŞİM</h3>
                <div class="footer-item-3-phone">
                    <i class="fa fa-phone"></i> <?=$db->ayarlar("value" , "tel");?>
                </div>
                <div class="footer-item-3-location">
                    <i class="flaticon-navigation-arrow"></i> <?=$db->ayarlar("value" , "adres");?>
                </div>
                <div class="footer-item-3-mail">
                    <i class="fa fa-envelope"></i> <a  href="<?=$db->ayarlar("value" , "mail");?>" style="    color: #ffffff !important;" ><?=$db->ayarlar("value" , "mail");?></a>
                </div>
                <div class="footer-item-3-socials">
                    <a href="<?=$db->ayarlar("value" , "facebook");?>"><i class="fa fa-facebook"></i></a> 
                    <a href="<?=$db->ayarlar("value" , "twitter");?>"><i class="fa fa-twitter"></i></a> 
                    <a   href="<?=$db->ayarlar("value" , "instagram");?>"><i class="fa fa-instagram"></i></a> 
              </div>
            </div>
            
            <!-- FOOTER ITEM 4 -->
                 
        </div>
    </div>
</div>