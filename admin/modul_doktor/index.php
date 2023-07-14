<?php 
include("include/top.php");
$page_name = "Doktorlar";
$vt = "doktor";

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
		"name" => "Doktor İsmi",
		"url" => "isim",
		"type" => "text",
		"options" => "",
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	), 
	
 array(
		"name" => 'Doktor Ünvanı',
		"url" => "unvan",
		"type" => "text",
		"options" => "",
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	), 
 array(
		"name" => 'İnstagram Adresi (http:// ile başlayın)',
		"url" => "instagram",
		"type" => "text",
		"options" => "",
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	), 
	
 array(
		"name" => 'Facebook Adresi (http:// ile başlayın)',
		"url" => "facebook",
		"type" => "text",
		"options" => "",
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	), 
	
 array(
		"name" => 'Twitter Adresi (http:// ile başlayın)',
		"url" => "twitter",
		"type" => "text",
		"options" => "",
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),  
	
	
 
	  array(
		"name" => "Resmi  400x426",
		"url" => "resim",
		"type" => "image",
		"options" => array( 
			'extension' => 'jpg',
			'process' => '../upload/',
			'value' => array(
				1 => array(
					'prefix'=>'',
					'resize'=>'1',
					'crop'=>'0',
					'x'=>'400',
					'y'=>'426'
				)
			)
		),
		"forced" => 0,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
	
	
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
} elseif($action == "add") {
if($_POST) {
	$vt_row = array("NULL");
	$vt_value = array();
	
	foreach($tablo as $sira => $rows){

		if($rows["add"] == 1) {
		if(in_array($rows["type"], $normal_kayit)) {
			$vt_row[] = "?";
			$vt_value[] = $_POST[$rows["url"]];
		} elseif ($rows["type"] == "file") {
			
		} elseif($rows["type"] == "image") {
			$verot_alert = 0;
			if($_FILES[$rows["url"]]["size"] > 0) {
			$handle = new Upload($_FILES[$rows["url"]], 'tr_TR');
			if($handle->uploaded) {
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
					$vt_row[] = "?";
					$vt_value[] = $new_name . "." . $arr["extension"];
				} else {
					$verot_alert = 2;
				}
			} else {
					$verot_alert = 3;
			}
			} else {
					$vt_row[] = "?";
					$vt_value[] = "";
			}
		} elseif($rows["type"] == "date") {
			$vt_row[] = "?";
			$vt_value[] = dtomd($_POST[$rows["url"]]);
		} elseif($rows["type"] == "data") {
			$vt_row[] = "?";
			$vt_value[] = $rows["options"];
		} elseif($rows["type"] == "seo") { 
			$vt_row[] = "?";
			$vt_value[] = seo($_POST[$rows["options"]]) . rand(1,999);
		} else {
			
		}
	}
	}
	if($db->veriEkle($vt,$vt_row,$vt_value) == 1) {
		header("Location: ". $link . "alert=1");
	}
}
} else if($action == "edit") {
$id = $_GET["id"];
if($_POST) {
	foreach($tablo as $sira => $rows){
		if($rows["edit"] == 1) {
		if(in_array($rows["type"], $normal_kayit)) {

		$db->veriGuncelle($vt,array($rows["url"]),array($_POST[$rows["url"]],$id),"id");
		} elseif ($rows["type"] == "file") {
			
		} elseif($rows["type"] == "image") {
			$verot_alert = 0;
			if($_FILES[$rows["url"]]["size"] > 0) {
			$handle = new Upload($_FILES[$rows["url"]], 'tr_TR');
			if($handle->uploaded) {
				$new_name = seo($handle->file_src_name) . "-" . rand(1111,9999);
				
				$arr = $rows["options"];
				foreach ($arr["value"] as $json_row => $json_value){
	
					unlink($arr["process"] . $json_value["prefix"] . $db->VeriOkuTek($vt, $rows["url"], "id", $id));
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
					$db->veriGuncelle($vt,array($rows["url"]),array($new_name . "." . $arr["extension"],$id),"id");

				} else {
					$verot_alert = 2;
				}
			} else {
					$verot_alert = 3;
			}
			}
		} elseif($rows["type"] == "date") {
			$db->veriGuncelle($vt,array($rows["url"]),array(dtomd($_POST[$rows["url"]]),$id),"id");
		} elseif($rows["type"] == "data") {

		} elseif($rows["type"] == "seo") {
			$db->veriGuncelle($vt,array($rows["url"]),array(seo($_POST[$rows["options"]]) . "-" . rand(1,999),$id),"id");
		}  else {
			
		}
	}
	}
		header("Location: ". $link . "alert=2");
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
<?php if($action == "add") { ?>
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="m-t-0 header-title"><b><?=$page_name;?></b></h4>
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
if($rows["add"] == 1) {
if($rows["forced"] == 1) {
	$zorunlu = "required"; 
} else {
	$zorunlu = 0;
}

if($rows["type"] == "text") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="form-control"></div></div>'; }
elseif($rows["type"] == "hidden") {  }
elseif($rows["type"] == "textarea") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><textarea ' . $zorunlu . ' name="' . $rows["url"] . '" class="form-control" rows="5"></textarea></div></div>'; }
elseif($rows["type"] == "summernote") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' class="form-control summernote" name="' . $rows["url"] . '" rows="5"></textarea></div></div>'; }
elseif($rows["type"] == "tinymce") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' id="elm1" name="' . $rows["url"] . '" class="form-control" rows="5"></textarea></div></div>'; }
elseif($rows["type"] == "file") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label> <div class="col-md-5"><input ' . $zorunlu . ' type="file" name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Dosya Seçilmedi"></div></div>'; }
elseif($rows["type"] == "image") {
	$arr_image = json_decode($rows->options, true);
	echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-5"><input ' . $zorunlu . ' type="file" name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Resim Seçilmedi"></div></div>';
}
elseif($rows["type"] == "date") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
<div class="input-group">
	<input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose">
	<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
</div>
</div></div>';
}
elseif($rows["type"] == "clock") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
<div class="input-group m-b-15">
	<div class="bootstrap-timepicker">
		<input ' . $zorunlu . ' id="timepicker2" type="text" name="' . $rows["url"] . '" class="form-control">
	</div>
	<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
</div>
</div></div>';
}
elseif($rows["type"] == "color") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="colorpicker-default form-control"></div></div>'; }
elseif($rows["type"] == "tags") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" data-role="tagsinput"/></div></div>'; }
elseif($rows["type"] == "selectbox") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
	<select ' . $zorunlu . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
	$array = array();
	$array = explode(",", $rows->options);
	for($i=0; $i < count($array); $i++) {
		echo '<option value="' . $i. '">' . $array[$i] . '</option>';
	}
echo'	</select>
</div></div>'; }

}
}
?>
	                                            <button type="submit" class="btn btn-success waves-effect waves-light">Kaydet</button>
	                                        </form>
                        				</div>                    				
                        			</div>
                        		</div>
							</div>
<?php } elseif($action == "edit") { ?>
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="m-t-0 header-title"><b><?=$page_name;?></b></h4>
                        			<p class="text-muted m-b-30 font-13">
										* Zorunlu alanlar
									</p>
									<?php 
										if($verot_alert == 2) { alert_error("Yüklenirken bir hata oluştu (HATA 1)"); }
										elseif($verot_alert == 3) { alert_error("Yüklenirken bir hata oluştu (HATA 1)"); }
									?>
                        			<div class="row">
                        				<div class="col-md-12">
                        					<form class="form-horizontal" action="<?=$link;?>action=edit&id=<?=$id;?>" method="post" enctype="multipart/form-data" role="form"> 
											<input type="hidden" name="rand" value="<?=rand();?>"/>
<?php
foreach($tablo as $sira => $rows){
if($rows["add"] == 1) {
if($rows["forced"] == 1) {
	$zorunlu = "required"; 
} else {
	$zorunlu = 0;
}

if($rows["type"] == "text") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '"></div></div>'; }
elseif($rows["type"] == "hidden") {  }
elseif($rows["type"] == "textarea") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><textarea ' . $zorunlu . ' name="' . $rows["url"] . '" class="form-control" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea></div></div>'; }
elseif($rows["type"] == "summernote") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' class="form-control summernote" name="' . $rows["url"] . '" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea></div></div>'; }
elseif($rows["type"] == "tinymce") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-10"><textarea ' . $zorunlu . ' id="elm1" name="' . $rows["url"] . '" class="form-control" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea></div></div>'; }
elseif($rows["type"] == "file") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label>'; 
	if($db->VeriOkuTek($vt, $rows["url"], "id", $id) != "") {
		echo '<div class="col-md-2"><a href="#" class="btn btn-default waves-effect waves-light"> <i class="fa fa-download m-r-5"></i> <span>Şuanki Dosya</span> </a></div>';
	}
	echo '<div class="col-md-5"><input type="file" name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Dosya Seçilmedi"></div></div>';
}
elseif($rows["type"] == "image") {
	echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label>'; 
	if($db->VeriOkuTek($vt, $rows["url"], "id", $id) != "") {
		echo '<div class="col-md-2"><a href="' . $rows["options"]["process"] .  $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Resim Önizleme</span> </a></div>';
	}
	echo '<div class="col-md-5"><input type="file" name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Resim Seçilmedi"></div></div>';
}
elseif($rows["type"] == "date") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
<div class="input-group">
	<input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="form-control" placeholder="dd/mm/yyyy" value="' . mdtod($db->VeriOkuTek($vt, $rows["url"], "id", $id)) . '" id="datepicker-autoclose">
	<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
</div>
</div></div>';
}
elseif($rows["type"] == "clock") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
<div class="input-group m-b-15">
	<div class="bootstrap-timepicker">
		<input ' . $zorunlu . ' id="timepicker2" type="text" name="' . $rows["url"] . '" class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id). '">
	</div>
	<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
</div>
</div></div>';
}
elseif($rows["type"] == "color") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" class="colorpicker-default form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id). '"></div></div>'; }
elseif($rows["type"] == "tags") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7"><input ' . $zorunlu . ' type="text" name="' . $rows["url"] . '" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id). '" data-role="tagsinput"/></div></div>'; }
elseif($rows["type"] == "selectbox") { echo '<div class="form-group"><label class="col-md-2 control-label">' . $rows["name"] . '</label><div class="col-md-7">
	<select ' . $zorunlu . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
	$array = array();
	$array = explode(",", $rows->options);
	for($i=0; $i < count($array); $i++) {
		if($i == $db->VeriOkuTek($vt, $rows["url"], "id", $id)) {
			echo '<option selected value="' . $i. '">' . $array[$i] . '</option>';
		} else {
			echo '<option value="' . $i. '">' . $array[$i] . '</option>';
		}
	}
echo'	</select>
</div></div>'; }

}
}
?>
	                                            <button type="submit" class="btn btn-success waves-effect waves-light">Kaydet</button>
	                                        </form>
                        				</div>                    				
                        			</div>
                        		</div>
							</div>
<?php } else if($action == "edit") { ?>

<?php } else {
?>
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<div class="row">
			                        	<div class="col-sm-8">
			                        		<form role="form" action="<?=$link;?>" method="post">
			                                    <div class="form-group contact-search m-b-30">
			                                    	<input type="text" id="search" value="<?=$_POST["search"];?>" autocomplete="off" name="search" class="form-control" placeholder="Arama yap...">
			                                        <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
			                                    </div> <!-- form-group -->
			                                </form>
			                        	</div>
			                        	<div class="col-sm-4">
			                        		 <a href="<?=$link;?>action=add" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Yeni</a>
			                        	</div>
			                        </div>
<div id="sortable_sonuc"></div>
<?php
if($_POST["search"] == "") {
	$search = "";
} else {
	$search = " WHERE ";
	foreach($tablo as $sira => $rows){
		$search .= $rows["url"] . " LIKE '%" . $_POST["search"] . "%' or ";
	}
	$search = rtrim($search, "or ");
}

if($db->veriSaydirSorgu("SELECT * FROM " . $vt . $search . " ORDER BY row ASC") > 0) {
?>
                        			<div class="table-responsive">
                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
<?php
	foreach($tablo as $sira => $rows){
	if($rows["list"] == 1) {
?>
													<th><?=$rows["name"];?></th>
<?php }} ?>
													<th>İşlem</th>
											</thead>
											
                                            <tbody id="sortable">
<?php
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . $search . " ORDER BY row ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
?>
                                                <tr id="item-<?=$rows->id;?>">    
<?php
	foreach($tablo as $sira => $row){
	if($row["list"] == 1) {
		if(in_array($row["type"], $normal_kayit)) {
			echo '<td>' . $rows->$row["url"] . '</td>';
		} elseif($row["type"] == "date") {
			echo '<td>' . mdtod($rows->$row["url"]) . '</td>';
		} elseif($row["type"] == "image") {
			echo '<td><a href="' . $row["options"]["process"] . $rows->$row["url"] . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Resim Önizleme</span> </a></td>';
		} else if($row["type"] == "file") {
			echo '<td>' . $rows->$row["url"] . '</td>';
		} elseif($row["type"] == "data" and $row["url"] == "row") {
			if($_POST["search"] == "") {
				echo '<td class="sortable" style="width:20px"><i class="glyphicon glyphicon-sort"></i></td>';
			} else {
				echo '<td style="width:20px"><i class="glyphicon glyphicon-sort"></i></td>';
			}
		}
	}
} ?>
                                                    <td style="width:120px">
													<div class="btn-group">
                                                    	<a href="<?=$link;?>action=edit&id=<?=$rows->id;?>" title="Düzenle" class="btn btn-icon btn-warning waves-effect waves-light"><i class="md md-edit"></i></a>
                                                    	<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Silmeye hazır!', '<?=$link;?>action=delete&id=<?=$rows->id;?>')" title="Sil" class="btn btn-icon btn-danger  waves-effect waves-light"><i class="md md-close"></i></a>
													</div>
                                                    </td>
                                                </tr>
<?php } ?>
                                            </tbody>
                                        </table>
									</div>
								</div>
							</div>
<?php } else { ?>
				<div class="alert alert-warning">
				  <strong>Uyarı!</strong> Kayıtlı veri bulunmamaktadır
				</div>
<?php }} ?>
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
<script src="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/isotope/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>        
<script src="assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min.js"></script>

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