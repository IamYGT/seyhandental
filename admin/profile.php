<?php 
include("include/top.php");
include("header.php"); 
$vt = "managers";

if($_POST) {
	if($_SESSION[$session_value] == 1) {
		$alert = 2;
	} else {
		if($db->veriSaydirSorgu("SELECT * FROM " . $vt . " WHERE id='" . $_SESSION[$session_value] . "'") > 0) {
			$db->veriGuncelle($vt,array("name", "email"),array($_POST["name"],$_POST["email"],$_SESSION[$session_value]),"id");
			
			if($_POST["password"] != "") {
				$db->veriGuncelle($vt,array("password"),array(md5($_POST["password"]),$_SESSION[$session_value]),"id");
			}
		}
		$alert = 1;
	}
}

?>
                      <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Profil</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">Profil</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="m-t-0 header-title"><b>Profil</b></h4>
                        			<p class="text-muted m-b-30 font-13">
										* Zorunlu alanlar
									</p>
									<?php if($alert == 1) {
										alert_success("Genel Ayarlar Başarıyla Güncellendi!");
									} elseif($alert == 2) {
										alert_error("Sistem Yöneticisi Hesabında Değişiklik Yapamazsınız!");
									}
									?>
                        			<div class="row">
                        				<div class="col-md-12">
                        					<form class="form-horizontal" name="profile" action="" method="post" role="form"> 
											<input type="hidden" name="rand" value="<?=rand();?>"/>
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label" for="register_date">Kayıt Tarihi</label>
	                                                <div class="col-md-5">
	                                                    <input type="text" class="form-control" disabled id="register_date" name="register_date" value="<?=mdtod($db->VeriOkuTek("managers", "register_date", "id", $_SESSION[$session_value]));?>">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label" for="name">Ad</label>
	                                                <div class="col-md-5">
	                                                    <input type="text" class="form-control" id="name" name="name" value="<?=$db->VeriOkuTek("managers", "name", "id", $_SESSION[$session_value]);?>">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label" for="email">E-posta</label>
	                                                <div class="col-md-5">
	                                                    <input type="email" id="email" name="email" class="form-control" value="<?=$db->VeriOkuTek("managers", "email", "id", $_SESSION[$session_value]);?>">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label" for="password">Yeni Parola</label>
	                                                <div class="col-md-5">
	                                                    <input type="text" class="form-control" id="password" name="password" value="">
	                                                </div>
	                                            </div>
	                                            <button type="submit" class="btn btn-success waves-effect waves-light">Değişiklikleri Kaydet</button>
	                                        </form>
                        				</div>                    				
                        			</div>
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


<script src="assets/plugins/notifyjs/dist/notify.min.js"></script>
<script src="assets/plugins/notifications/notify-metro.js"></script>
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<!-- Modal-Effect -->
<script src="assets/plugins/custombox/dist/custombox.min.js"></script>
<script src="assets/plugins/custombox/dist/legacy.min.js"></script>
<script src="assets/plugins/summernote/dist/summernote.js"></script>
<script src="assets/plugins/tinymce/tinymce.min.js"></script>
<script src="assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

<script src="assets/plugins/moment/moment.js"></script>
<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function () {
		if($("#elm1").length > 0){
			tinymce.init({
				selector: "textarea#elm1",
				language: 'tr_TR',
				theme: "modern",
				height:300,
				plugins: [
					"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"save table contextmenu directionality emoticons template paste textcolor"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
				style_formats: [
					{title: 'Kalın Yazı', inline: 'b'},
					{title: 'Kırmızı Yazı', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Kırmızı Başlık', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Örnek 1', inline: 'span', classes: 'example1'},
					{title: 'Örnek 2', inline: 'span', classes: 'example2'},
					{title: 'Tablo stili'},
					{title: 'Tablo satırı 1', selector: 'tr', classes: 'tablerow1'}
				]
			});    
		}  
	});
	
			jQuery(document).ready(function() {
				jQuery(function() {
				jQuery('.summernote').summernote({
					height: "200px"
				});
				var postForm = function() {
				var content = jQuery('.summernote')
				}
				});
				
				jQuery('#timepicker2').timepicker({
					showMeridian : false
				});
				//colorpicker start

                $('.colorpicker-default').colorpicker({
                    format: 'hex'
                });
                $('.colorpicker-rgba').colorpicker();
                
                // Date Picker
                jQuery('#datepicker-autoclose').datepicker({
		            format: 'dd/mm/yyyy',
                	autoclose: true,
                	todayHighlight: true,
					language:'tr'

                });
               
			});

</script>
 <?php include("footer.php");?>