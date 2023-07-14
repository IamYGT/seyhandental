<?php 
include("include/top.php");
$page_name = "Anlaşmalı Kurumlar";
$vt = "sel";

if($action == "row") {
	if ( is_array($_POST['item']) ){		
		foreach ( $_POST['item'] as $key => $value ){
			$db->veriGuncelle($vt,array("row"),array(($key+1),$value),"id");
		}
		$returnMsg = array( 'islemSonuc' => true , 'islemMsj' => '<div class="alert alert-success" role="alert">Sıra Güncellendi</div>' );
	} else {
		$returnMsg = array( 'islemSonuc' => false , 'islemMsj' => '<div class="alert alert-danger" role="alert">Sıra Güncellenirken Hata Oluştu</div>' );
	}

	if ( isset($returnMsg) ){
		echo json_encode($returnMsg);
	}
	exit;
}

include("header.php"); 

$tablo = array(
	  array(
		"name" => "Sıra",
		"url" => "row",
		"type" => "data",
		"options" => "0",
		"forced" => 1,
		"add" => 1,
		"edit" => 0,
		"list" => 1
	), 
	
	  array(
		"name" => "Resim 239x227",
		"url" => "image",
		"type" => "image",
		"options" => array(
			'extension' => 'png',
			'process' => '../upload/',
			'value' => array(
				1 => array(
					'prefix'=>'',
					'resize'=>'0',
					'crop'=>'0',
					'x'=>'239',
					'y'=>'227'
				)
			)
		),
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	)
);

$normal_kayit = array("text", "textarea", "summernote", "tinymce", "clock", "color", "tags", "selectbox");

if($action == "delete") {
	$id = $_GET["id"];
	foreach($tablo as $sira => $rows){
		if($rows["type"] == "image") {
			$arr = $rows["options"];
			foreach ($arr["value"] as $json_row => $json_value){
				unlink($arr["process"] . $json_value["prefix"] . $db->VeriOkuTek($vt, $rows["url"], "id", $id));
			}
		}
	}
	
	$bilgi= $db->veriSil($vt, array("id"), array($id));
	header("Location: ". $link . "alert=1");
} else {
if($_POST) {	
	foreach($tablo as $sira => $rows){
		if($rows["type"] == "image") {				
			$verot_alert = 0;

			if($_FILES[$rows["url"]]["size"] > 0) {
			$resimler = array();
			foreach ($_FILES[$rows["url"]] as $k => $l) {
			  foreach ($l as $i => $v) {
					if (!array_key_exists($i, $resimler))
					  $resimler[$i] = array();
					$resimler[$i][$k] = $v;
			  }
			}
				
			$i = 0;
			foreach ($resimler as $resim){

					$handle = new Upload($resim, 'tr_TR');
					if ($handle->uploaded) {
						$i++;
			
						$new_name = seo($handle->file_src_name) . "-" . rand(1111,9999);
						
						$arr = $rows["options"];
						foreach ($arr["value"] as $json_row => $json_value){
			
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
								$handle->image_background_color = '#ffffff';
								$handle->image_ratio_fill = false;
								
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
							if($db->veriEkle($vt,array("NULL", "?", "?"),array("0", $new_name . "." . $arr["extension"])) == 1) {
								header("Location: ". $link . "alert=1");
							}
						} else {
							$verot_alert = 2;
						}
					} else {
							$verot_alert = 3;
					}
				}
			} else {
				header("Location: ". $link . "alert=4");
			}
		}
	}

}
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
                                <h4 class="page-title"><?=$page_name;?></h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
									<?php if($action == "add") {
										echo '<li><a href="' . $link . '">' . $page_name . '</a></li>';
										echo '<li class="active">Ekle</li>';
									} elseif($action == "edit") {
										echo '<li><a href="' . $link . '">' . $page_name . '</a></li>';
										echo '<li class="active">Düzenle</li>';
									} else {
										echo '<li class="active">' . $page_name . '</li>';
									}
									?>
                                    
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="m-t-0 header-title"><b>YENİ EKLE</b></h4>
                        			<p class="text-muted m-b-30 font-13">
										* Zorunlu alanlar
									</p>
									<?php 
										if($verot_alert == 2) { alert_error("Yüklenirken bir hata oluştu (HATA 1)"); }
										elseif($verot_alert == 3) { alert_error("Yüklenirken bir hata oluştu (HATA 1)"); }
									?>
                        			<div class="row">
                        				<div class="col-md-12">
                        					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" role="form"> 
											<input type="hidden" name="rand" value="<?=rand();?>"/>
<?php
	foreach($tablo as $sira => $rows){
		if($rows["type"] == "image") {	
			echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-5"><input required type="file" name="' . $rows["url"] . '[]" multiple class="filestyle" data-placeholder="Yeni Resim Seçilmedi"></div></div>';
	}}
?>
	                                            <button type="submit" class="btn btn-success waves-effect waves-light">Kaydet</button>
	                                        </form>
                        				</div>                    				
                        			</div>
                        		</div>
							</div>
                        	<div class="col-lg-12">
                        		<div class="card-box"> 
<div id="sortable_sonuc"></div>
<?php
if($db->veriSaydirSorgu("SELECT * FROM " . $vt . " ORDER BY row ASC") > 0) {
?>
                        <div class="row port">
                            <div class="portfolioContainer" id="sortable">
<?php
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . " ORDER BY row ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
	foreach($tablo as $sira => $row){
		if($row["type"] == "image") {
?>
                                <div class="col-sm-6 col-lg-3 col-md-4 " id="item-<?=$rows->id;?>">
                                    <div class="gal-detail thumb sortable">
                                        <a href="<?=$row["options"]["process"] . $rows->$row["url"];?>" class="image-popup" title="<?=$rows->id;?>">
                                            <img src="<?=$row["options"]["process"] . $rows->$row["url"];?>" class="thumb-img" alt="work-thumbnail">
                                        </a>
										<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Silmeye hazır!', '<?=$link;?>action=delete&id=<?=$rows->id;?>')" title="Sil" class="btn btn-icon btn-danger btn-block waves-effect waves-light"><i class="md md-close"></i></a>
                                    </div>
                                </div>
<?php }}} ?>
							</div>
						</div>

								</div>
							</div>
<?php } else { ?>
				<div class="alert alert-warning">
				  <strong>Uyarı!</strong> Kayıtlı veri bulunmamaktadır
				</div>
<?php } ?>
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
<script src="assets/js/jquery-ui.js"></script>

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
	
	$(function() {
		$( "#sortable" ).sortable({
			revert: true,
			handle: ".sortable",
			stop: function (event, ui) {
				var data = $(this).sortable('serialize');

				$.ajax({
					type: "POST",
					dataType: "json",
					data: data,
					url: "<?=$link;?>action=row",
					success: function(msg){
						$("#sortable_sonuc").html(msg.islemMsj);
						
						setTimeout(function(){
							$("#sortable_sonuc").html("");
						},2000); 
					}
				});	                      				
			}
		});
		$( "#sortable" ).disableSelection();	                      		
	});
</script>
 <?php include("footer.php");?>