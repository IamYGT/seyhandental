<?php 
include("include/top.php");
include("header.php"); 
$vt = "general_settings";

if($_POST) {
	$normal_kayit = array("text", "textarea", "summernote", "tinymce", "clock", "color", "tags", "selectbox");

	if($db->veriSaydirSorgu("SELECT * FROM " . $vt) > 0) {
	$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . " ORDER BY id ASC");
	$bilgial= $db->bilgial;
	foreach($bilgial as $rows){
		if(in_array($rows->type, $normal_kayit)) {
			$db->veriGuncelle($vt,array("value"),array($_POST[$rows->url],$rows->id),"id");
		} elseif ($rows->type == "file") {
			
		} elseif($rows->type == "image") {
			$verot_alert = 0;
			$handle = new Upload($_FILES[$rows->url], 'tr_TR');
			if($handle->uploaded) {
				$new_name = seo($handle->file_src_name) . "-" . rand(1111,9999);
				
				$arr = json_decode($rows->options, true);
				foreach ($arr["value"] as $json_row => $json_value){
	
					unlink($arr["process"] . $json_value["prefix"] . $rows->value);
					$handle->file_new_name_body = $json_value["prefix"] . $new_name;
					
					$handle->image_convert = $arr["extension"]; 
					
					if($json_value["resize"] == 1) {
						$handle->image_resize = true;
					} else {
						$handle->image_resize = false;
					}

					if($json_value["crop"] == 1) {
						$handle->image_ratio_crop = true;
					} else {
						$handle->image_ratio_crop = false;
					}
										
					if($json_value["resize"] == 1) {
						if($json_value["x"] != "ratio") {
							$handle->image_x = $json_value["x"]; 
						} elseif($json_value["x"] == "ratio") {
							$handle->image_ratio_x = true; 
						}
						
						if($json_value["y"] != "ratio") {
							$handle->image_y = $json_value["y"]; 
						} elseif($json_value["y"] == "ratio") {
							$handle->image_ratio_y = true; 
						}
					}
					
					$handle->Process($arr["process"]);
				}
				
				if($handle->processed) {
					$db->veriGuncelle($vt,array("value"),array($new_name . "." . $arr["extension"],$rows->id),"id");
				} else {
					$verot_alert = 2;
				}
			} else {
					$verot_alert = 3;
			}
		} elseif($rows->type == "date") {
			$db->veriGuncelle($vt,array("value"),array(dtomd($_POST[$rows->url]),$rows->id),"id");
		} else {
			
		}
	}}
	$alert = 1;
}

?>
		<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="assets/plugins/summernote/dist/summernote.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/plugins/magnific-popup/dist/magnific-popup.css"/>

                      <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Genel Ayarlar</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">Genel Ayarlar</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="m-t-0 header-title"><b>Genel Ayarlar</b></h4>
                        			<p class="text-muted m-b-30 font-13">
										* Zorunlu alanlar
									</p>
									<?php 
										if($alert == 1) { alert_success("Genel Ayarlar Başarıyla Güncellendi!"); }
										if($verot_alert == 1) { alert_success("Resimler Başarıyla Yüklendi"); }
										elseif($verot_alert == 2) { alert_success("Yüklenirken bir hata oluştu (HATA 1)"); }
										elseif($verot_alert == 3) { alert_success("Yüklenirken bir hata oluştu (HATA 1)"); }
									?>
                        			<div class="row">
                        				<div class="col-md-12">
                        					<form class="form-horizontal" name="general_settings" action="" method="post" enctype="multipart/form-data" role="form"> 
											<input type="hidden" name="rand" value="<?=rand();?>"/>
<?php
if($db->veriSaydirSorgu("SELECT * FROM " . $vt) > 0) {
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . " ORDER BY id ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
	
if($rows->forced == 1) {
	$zorunlu = "required"; 
} else {
	$zorunlu = 0;
}

if($rows->type == "text") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows->url . '" class="form-control" value="' . $rows->value . '"></div></div>'; }
elseif($rows->type == "hidden") {  }
elseif($rows->type == "textarea") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7"><textarea ' . $zorunlu . ' name="' . $rows->url . '" class="form-control" rows="5">' . $rows->value . '</textarea></div></div>'; }
elseif($rows->type == "summernote") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' class="form-control summernote" name="' . $rows->url . '" rows="5">' . $rows->value . '</textarea></div></div>'; }
elseif($rows->type == "tinymce") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' id="elm1" name="' . $rows->url . '" class="form-control" rows="5">' . $rows->value . '</textarea></div></div>'; }
elseif($rows->type == "file") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label>'; 
	if($rows->value != "") {
		echo '<div class="col-md-2"><a href="#" class="btn btn-default waves-effect waves-light"> <i class="fa fa-download m-r-5"></i> <span>Şuanki Dosya</span> </a></div>';
	}
	echo '<div class="col-md-5"><input ' . $zorunlu . ' type="file" name="' . $rows->url . '" class="filestyle" data-placeholder="Yeni Dosya Seçilmedi"></div></div>';
}
elseif($rows->type == "image") {
	$arr_image = json_decode($rows->options, true);
	echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label>'; 
	if($rows->value != "") {
		echo '<div class="col-md-2"><a href="' . $arr_image["process"] .  $rows->value . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Resim Önizleme</span> </a></div>';
	}
	echo '<div class="col-md-5"><input ' . $zorunlu . ' type="file" name="' . $rows->url . '" class="filestyle" data-placeholder="Yeni Resim Seçilmedi"></div></div>';
}
elseif($rows->type == "date") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7">
<div class="input-group">
	<input ' . $zorunlu . ' type="text" name="' . $rows->url . '" class="form-control" placeholder="dd/mm/yyyy" value="' . mdtod($rows->value) . '" id="datepicker-autoclose">
	<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
</div>
</div></div>';
}
elseif($rows->type == "clock") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7">
<div class="input-group m-b-15">
	<div class="bootstrap-timepicker">
		<input id="timepicker2" type="text" ' . $zorunlu . ' name="' . $rows->url . '" class="form-control" value="' . $rows->value. '">
	</div>
	<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
</div>
</div></div>';
}
elseif($rows->type == "color") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows->url . '" class="colorpicker-default form-control" value="' . $rows->value. '"></div></div>'; }
elseif($rows->type == "tags") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows->url . '" value="' . $rows->value. '" data-role="tagsinput"/></div></div>'; }
elseif($rows->type == "selectbox") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows->name . '</label><div class="col-md-7">
	<select ' . $zorunlu . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows->url . '" data-style="btn-white">';
	$array = array();
	$array = explode(",", $rows->options);
	for($i=0; $i < count($array); $i++) {
		if($i == $rows->value) {
			echo '<option selected value="' . $i. '">' . $array[$i] . '</option>';
		} else {
			echo '<option value="' . $i. '">' . $array[$i] . '</option>';
		}
	}
echo'	</select>
</div></div>'; }


}}
?>
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
<script type="text/javascript" src="assets/plugins/isotope/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		
		$('.image-popup').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-fade',
			gallery: {
				enabled: false,
				navigateByImgClick: false,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			}
		});

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