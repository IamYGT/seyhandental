<?php 
include("include/top.php");
$page_name = "Randevu";
$vt = "randevu";
$order_by = "id DESC";
$row_limit = 20;
$extra_sql = "";
$special_button = array();

$tablo = array(
	array(
		"name" => "Adı",
		"url" => "ad",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
array(
		"name" => "telefon",
		"url" => "telefon",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
array(
		"name" => "Eposta",
		"url" => "eposta",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
array(
		"name" => "Tarih",
		"url" => "tarih",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
array(
		"name" => "Saat",
		"url" => "saat",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
 
array(
		"name" => "Mesaj",
		"url" => "mesaj",
		"type" => "text",
		"script" => "",
		"mask" => "",
		"forced" => 1,
		"add" => 1,
		"edit" => 1,
		"list" => 1
	),
 
	 
);

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

$normal_kayit = array("text", "hidden", "textarea", "summernote", "tinymce", "clock", "color", "tags");
$extra_kayit = array("selectbox_array", "selectbox_db", "radio_array", "radio_db");
//DELETE
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
} 

// NEW ADD
elseif($action == "add") {
if($_POST) {
	$vt_row = array("NULL");
	$vt_value = array();
	
	foreach($tablo as $sira => $rows){
		if($rows["add"] == 1) {
			if(in_array($rows["type"], $normal_kayit) or in_array($rows["type"], $extra_kayit)) {
				$vt_row[] = "?";
				$vt_value[] = $_POST[$rows["url"]];
			} elseif($rows["type"] == "admin" and $_SESSION[$session_value] == 1) {
				$vt_row[] = "?";
				$vt_value[] = $_POST[$rows["url"]];
			} elseif($rows["type"] == "date_now") {
				$vt_row[] = "?";
				$vt_value[] = date($rows["write_format"]);
			} elseif($rows["type"] == "clock_now") {
				$vt_row[] = "?";
				$vt_value[] = date($rows["format"]);
			} elseif ($rows["type"] == "file") {
				$vt_row[] = "?";
				$seo_file_name = seo($_FILES['photo']['tmp_name']) . "." . uzanti($seo_file_name);
				if(move_uploaded_file($_FILES[$rows["url"]]['tmp_name'], $rows["upload"] .'/'.$seo_file_name)) {
					$db->veriGuncelle($vt,array($rows["url"]),array($seo_file_name,$id),"id");
					$vt_value[] = $seo_file_name;
				} else {
					$vt_value[] = ""; 
				}
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
				$vt_value[] = date_format(date_create_from_format('d/m/Y', $_POST[$rows["url"]]), $rows["write_format"]);
			} elseif($rows["type"] == "data") {
				$vt_row[] = "?";
				$vt_value[] = $rows["default"];
			} elseif($rows["type"] == "seo") { 
				$vt_row[] = "?";
				$vt_value[] = seo($_POST[$rows["options"]]) . rand(1,999);
			} elseif($rows["type"] == "checkbox_array") { 
				$vt_row[] = "?";
				
				$check_value = "";
				if(isset($_POST[$rows["url"]])) {
					$check_value = json_encode($_POST[$rows["url"]],JSON_UNESCAPED_UNICODE);
				}
				
				$vt_value[] = $check_value;
			} elseif($rows["type"] == "checkbox_array" or $rows["type"] == "checkbox_db") {
				$vt_row[] = "?";
				
				$check_value = "";
				if(isset($_POST[$rows["url"]])) {
					$check_value = json_encode($_POST[$rows["url"]],JSON_UNESCAPED_UNICODE);
				}
				
				$vt_value[] = $check_value;
			} else {
				
			}
		}
	}
	if($db->veriEkle($vt,$vt_row,$vt_value) == 1) {
		header("Location: ". $link . "alert=1");
	}
}
} 

//EDİT 
else if($action == "edit") {
$id = $_GET["id"];
if($_POST and isset($id)) {
	foreach($tablo as $sira => $rows){
		if($rows["edit"] == 1) {
			if(in_array($rows["type"], $normal_kayit) or in_array($rows["type"], $extra_kayit)) {
				$db->veriGuncelle($vt,array($rows["url"]),array($_POST[$rows["url"]],$id),"id");
			} elseif($rows["type"] == "admin" and $_SESSION[$session_value] == 1) {
				$db->veriGuncelle($vt,array($rows["url"]),array($_POST[$rows["url"]],$id),"id");
			} elseif($rows["type"] == "date_now") {
				$db->veriGuncelle($vt,array($rows["url"]),array(date($rows["write_format"]),$id),"id");
			} elseif($rows["type"] == "date_now") {
				$db->veriGuncelle($vt,array($rows["url"]),array(date($rows["format"]),$id),"id");
			} elseif ($rows["type"] == "file") {
				$seo_file_name = seo($_FILES['photo']['tmp_name']) . "." . uzanti($seo_file_name);
				if(move_uploaded_file($_FILES[$rows["url"]]['tmp_name'], $rows["upload"] .'/'.$seo_file_name)) {
					unlink($rows["upload"] .'/'.$db->VeriOkuTek($vt,$rows["url"],"id",$id));
					$db->veriGuncelle($vt,array($rows["url"]),array($seo_file_name,$id),"id");
				}
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
				$db->veriGuncelle($vt,array($rows["url"]),array(date_format(date_create_from_format('d/m/Y', $_POST[$rows["url"]]), $rows["write_format"]),$id),"id");
			} elseif($rows["type"] == "data") {
				$db->veriGuncelle($vt,array($rows["url"]),array($rows["default"],$id),"id");
			} elseif($rows["type"] == "seo") {
				$db->veriGuncelle($vt,array($rows["url"]),array(seo($_POST[$rows["options"]]) . "-" . rand(1,999),$id),"id");
			} elseif($rows["type"] == "checkbox_array" or $rows["type"] == "checkbox_db") { 
				$check_value = "";
				
				if(isset($_POST[$rows["url"]])) {
					$check_value = json_encode($_POST[$rows["url"]],JSON_UNESCAPED_UNICODE);
				}
				
				$db->veriGuncelle($vt,array($rows["url"]),array($check_value,$id),"id");
			}  else {
				
			}
		}
	}
		header("Location: ". $link . "alert=2");
}
}

?>
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
	$zorunlu_label = "* ";
} else {
	$zorunlu = 0;
	$zorunlu_label = "";
}

if($rows["type"] == "text") { 
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" ' . $rows["script"] . ' name="' . $rows["url"] . '" '; if($rows["mask"] != "") { echo 'data-mask="' . $rows["mask"] . '"'; } echo ' class="form-control">
		</div>
	</div>'; 
}
elseif($rows["type"] == "hidden") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" '; if($_SESSION[$session_value] != 1) { echo 'hidden'; }  echo ' value="' . $rows["default"] . '" name="' . $rows["url"] . '" class="form-control">
		</div>
	</div>'; 
}
elseif($rows["type"] == "admin" and $_SESSION[$session_value] == 1) {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" value="' . $rows["default"] . '" name="' . $rows["url"] . '" class="form-control">
		</div>
	</div>'; 
}
elseif($rows["type"] == "textarea") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' name="' . $rows["url"] . '" class="form-control" rows="5"></textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "summernote") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-10">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' class="form-control summernote" name="' . $rows["url"] . '" rows="5"></textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "tinymce") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-10">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' id="elm1" name="' . $rows["url"] . '" class="form-control" rows="5"></textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "file") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-5">
			<input ' . $zorunlu . ' type="file" ' . $rows["script"] . ' name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Dosya Seçilmedi">
		</div>
	</div>';
}
elseif($rows["type"] == "image") {
	$arr_image = json_decode($rows->options, true);
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-5">
			<input ' . $zorunlu . ' type="file" ' . $rows["script"] . ' name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Resim Seçilmedi">
		</div>
	</div>';
}
elseif($rows["type"] == "date") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<div class="input-group">
				<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose">
				<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
			</div>
		</div>
	</div>';
}
elseif($rows["type"] == "clock") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<div class="input-group m-b-15">
				<div class="bootstrap-timepicker">
					<input ' . $zorunlu . ' ' . $rows["script"] . ' id="timepicker2" type="text" name="' . $rows["url"] . '" class="form-control">
				</div>
				<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
			</div>
		</div>
	</div>';
}
elseif($rows["type"] == "color") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" class="colorpicker-default form-control">
		</div>
	</div>'; 
}
elseif($rows["type"] == "tags") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" data-role="tagsinput"/>
			<span>Aralarında virgül bırakarak yazınız</span>
		</div>
	</div>';
}
elseif($rows["type"] == "selectbox_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
			<select ' . $zorunlu . ' ' . $rows["script"] . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
			foreach($rows["options"] as $i => $value) {
				echo '
				<option'; if($rows["default"] == $i) { echo ' selected'; } echo ' value="' . $i. '">' . $value . '</option>';
			}
	echo'
			</select>
		</div>
	</div>'; 
}
elseif($rows["type"] == "selectbox_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
			<select ' . $zorunlu . ' ' . $rows["script"] . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
				echo '
				<option'; if($rows["default"] == $rowb->$rows["options_id"]) { echo ' selected'; } echo ' value="' . $rowb->$rows["options_id"]. '">' . $rowb->$rows["options_name"] . '</option>';
				}
			}
	echo'
			</select>
		</div>
	</div>'; 
}
elseif($rows["type"] == "checkbox_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			foreach($rows["options"] as $i => $value) {
			$y++;
				echo '
					<div class="checkbox checkbox-pink">
						<input'; if(in_array($i, $rows["default"])) { echo ' checked'; } echo ' id="' . $rows["url"] . "_" . $y . '" type="checkbox" name="' . $rows["url"] . '[]" value="' . $i . '" data-parsley-multiple="groups" ';
				if($rows["min"] != 0) {
				echo 'data-parsley-mincheck="' . $rows["min"] . '"';
				}
				if($rows["max"] != 0) {
				echo 'data-parsley-maxcheck="' . $rows["max"] . '"';
				}
				echo '>
						<label for="' . $rows["url"] . "_" . $y . '">' . $value . '</label>
					</div>
				';
			}
	echo'
		</div>
	</div>'; 
}
elseif($rows["type"] == "checkbox_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
				$y++;
				echo '
					<div class="checkbox checkbox-pink">
						<input'; if(in_array($rowb->$rows["options_id"], $rows["default"])) { echo ' checked'; } echo ' id="' . $rows["url"] . "_" . $y . '" type="checkbox" name="' . $rows["url"] . '[]" value="' . $rowb->$rows["options_id"] . '" data-parsley-multiple="groups" ';
				if($rows["min"] != 0) {
				echo 'data-parsley-mincheck="' . $rows["min"] . '"';
				}
				if($rows["max"] != 0) {
				echo 'data-parsley-maxcheck="' . $rows["max"] . '"';
				}
				echo '>
						<label for="' . $rows["url"] . "_" . $y . '">' . $rowb->$rows["options_name"] . '</label>
					</div>
				';
			}}
	echo'
		</div>
	</div>'; 
}
elseif($rows["type"] == "radio_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			foreach($rows["options"] as $i => $value) {
				$y++;
				echo '
					<div class="radio radio-pink">
						<input'; if($rows["default"] == $i) { echo ' checked'; } echo ' type="radio" name="' . $rows["url"] . '" id="' . $rows["url"] . "_" . $y . '" value="' . $i . '">
						<label for="' . $rows["url"] . "_" . $y . '">' . $value . '</label>
					</div>
				';
			}
	echo'
		</div>
	</div>';
}
elseif($rows["type"] == "radio_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
					$y++;
				echo '
					<div class="radio radio-pink">
						<input'; if($rows["default"] == $rowb->$rows["options_id"]) { echo ' checked'; } echo ' type="radio" name="' . $rows["url"] . '" id="' . $rows["url"] . "_" . $y . '" value="' . $rowb->$rows["options_id"] . '">
						<label for="' . $rows["url"] . "_" . $y . '">' . $rowb->$rows["options_name"] . '</label>
					</div>
				';
			}
			}
	echo'
		</div>
	</div>';
}
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
	$zorunlu_label = "* ";
} else {
	$zorunlu = 0;
	$zorunlu_label = "";
}

if($rows["type"] == "text") { 
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" ' . $rows["script"] . ' name="' . $rows["url"] . '" '; if($rows["mask"] != "") { echo 'data-mask="' . $rows["mask"] . '"'; } echo ' class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '">
		</div>
	</div>'; 
}
elseif($rows["type"] == "hidden") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" '; if($_SESSION[$session_value] != 1) { echo 'hidden'; }  echo ' value="' . $rows["default"] . '" name="' . $rows["url"] . '" class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '">
		</div>
	</div>'; 
}
elseif($rows["type"] == "admin" and $_SESSION[$session_value] == 1) {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' type="text" value="' . $rows["default"] . '" name="' . $rows["url"] . '" class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '">
		</div>
	</div>'; 
}
elseif($rows["type"] == "textarea") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' name="' . $rows["url"] . '" class="form-control" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "summernote") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-10">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' class="form-control summernote" name="' . $rows["url"] . '" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "tinymce") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-10">
			<textarea ' . $zorunlu . ' ' . $rows["script"] . ' id="elm1" name="' . $rows["url"] . '" class="form-control" rows="5">' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '</textarea>
		</div>
	</div>';
}
elseif($rows["type"] == "file") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>'; 
	if($db->VeriOkuTek($vt, $rows["url"], "id", $id) != "") {
		echo '
		<div class="col-md-2">
			<a href="' . $rows["upload"] . '/' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '" class="btn btn-default waves-effect waves-light">
				<i class="fa fa-download m-r-5"></i> <span>Şuanki Dosya</span>
			</a>
		</div>';
	}
	echo '
		<div class="col-md-5">
			<input ' . $zorunlu . ' type="file" ' . $rows["script"] . ' name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Dosya Seçilmedi">
		</div>
	</div>';
}
elseif($rows["type"] == "image") {
	$arr_image = json_decode($rows->options, true);
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>'; 
	if($db->VeriOkuTek($vt, $rows["url"], "id", $id) != "") {
		echo '<div class="col-md-2"><a href="' . $rows["options"]["process"] .  $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Resim Önizleme</span> </a></div>';
	}
	echo '
		<div class="col-md-5">
			<input ' . $zorunlu . ' type="file" ' . $rows["script"] . ' name="' . $rows["url"] . '" class="filestyle" data-placeholder="Yeni Resim Seçilmedi">
		</div>
	</div>';
}
elseif($rows["type"] == "date") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<div class="input-group">
				<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" class="form-control" placeholder="dd/mm/yyyy" value="' . date_format(date_create_from_format($rows["write_format"], $db->VeriOkuTek($vt, $rows["url"], "id", $id)), 'd/m/Y') . '" id="datepicker-autoclose">
				<span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
			</div>
		</div>
	</div>';
}
elseif($rows["type"] == "clock") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<div class="input-group m-b-15">
				<div class="bootstrap-timepicker">
					<input ' . $zorunlu . ' ' . $rows["script"] . ' id="timepicker2" type="text" name="' . $rows["url"] . '" class="form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id) . '">
				</div>
				<span class="input-group-addon bg-custom b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
			</div>
		</div>
	</div>';
}
elseif($rows["type"] == "color") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" class="colorpicker-default form-control" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id). '">
		</div>
	</div>'; 
}
elseif($rows["type"] == "tags") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
			<input ' . $zorunlu . ' ' . $rows["script"] . ' type="text" name="' . $rows["url"] . '" data-role="tagsinput" value="' . $db->VeriOkuTek($vt, $rows["url"], "id", $id). '"/>
			<span>Aralarında virgül bırakarak yazınız</span>
		</div>
	</div>';
}
elseif($rows["type"] == "selectbox_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
			<select ' . $zorunlu . ' ' . $rows["script"] . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
			foreach($rows["options"] as $i => $value) {
				echo '
				<option'; if($db->VeriOkuTek($vt, $rows["url"], "id", $id) == $i) { echo ' selected'; } echo ' value="' . $i. '">' . $value . '</option>';
			}
	echo'
			</select>
		</div>
	</div>'; 
}
elseif($rows["type"] == "selectbox_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
			<select ' . $zorunlu . ' ' . $rows["script"] . ' class="selectpicker show-tick" data-live-search="true"  name="' . $rows["url"] . '" data-style="btn-white">';
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
				echo '
				<option'; if($db->VeriOkuTek($vt, $rows["url"], "id", $id) == $rowb->$rows["options_id"]) { echo ' selected'; } echo ' value="' . $rowb->$rows["options_id"]. '">' . $rowb->$rows["options_name"] . '</option>';
				}
			}
	echo'
			</select>
		</div>
	</div>'; 
}
elseif($rows["type"] == "checkbox_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			$json_check = array();
			if(json_decode($db->VeriOkuTek($vt, $rows["url"], "id", $id), true) != "") {
				$json_check = json_decode($db->VeriOkuTek($vt, $rows["url"], "id", $id), true);
			}
			foreach($rows["options"] as $i => $value) {
			$y++;
				echo '
					<div class="checkbox checkbox-pink">
						<input'; if(in_array($i, $json_check)) { echo ' checked'; } echo ' id="' . $rows["url"] . "_" . $y . '" type="checkbox" name="' . $rows["url"] . '[]" value="' . $i . '" data-parsley-multiple="groups" ';
				if($rows["min"] != 0) {
				echo 'data-parsley-mincheck="' . $rows["min"] . '"';
				}
				if($rows["max"] != 0) {
				echo 'data-parsley-maxcheck="' . $rows["max"] . '"';
				}
				echo '>
						<label for="' . $rows["url"] . "_" . $y . '">' . $value . '</label>
					</div>
				';
			}
	echo'
		</div>
	</div>'; 
}
elseif($rows["type"] == "checkbox_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">' . $zorunlu_label . $rows["name"] . '</label>
		<div class="col-md-7">
	';		
			$json_check = array();
			if(json_decode($db->VeriOkuTek($vt, $rows["url"], "id", $id), true) != "") {
				$json_check = json_decode($db->VeriOkuTek($vt, $rows["url"], "id", $id), true);
			}
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
				$y++;

				echo '
					<div class="checkbox checkbox-pink">
						<input'; if(in_array($rowb->$rows["options_id"], $json_check)) { echo ' checked'; } echo ' id="' . $rows["url"] . "_" . $y . '" type="checkbox" name="' . $rows["url"] . '[]" value="' . $rowb->$rows["options_id"] . '" data-parsley-multiple="groups" ';
				if($rows["min"] != 0) {
				echo 'data-parsley-mincheck="' . $rows["min"] . '"';
				}
				if($rows["max"] != 0) {
				echo 'data-parsley-maxcheck="' . $rows["max"] . '"';
				}
				echo '>
						<label for="' . $rows["url"] . "_" . $y . '">' . $rowb->$rows["options_name"] . '</label>
					</div>
				';
			}}
	echo'
		</div>
	</div>'; 
}
elseif($rows["type"] == "radio_array") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			foreach($rows["options"] as $i => $value) {
				$y++;
				echo '
					<div class="radio radio-pink">
						<input'; if($db->VeriOkuTek($vt, $rows["url"], "id", $id) == $i) { echo ' checked'; } echo ' type="radio" name="' . $rows["url"] . '" id="' . $rows["url"] . "_" . $y . '" value="' . $i . '">
						<label for="' . $rows["url"] . "_" . $y . '">' . $value . '</label>
					</div>
				';
			}
	echo'
		</div>
	</div>';
}
elseif($rows["type"] == "radio_db") {
	echo '
	<div class="form-group">
		<label class="col-md-2 control-label">* ' . $rows["name"] . '</label>
		<div class="col-md-7">
	';
			$y = 0;
			if($db->VeriSaydirSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]) > 0) {
			$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $rows["vt"] . " " . $rows["extra"]);
			$bilgial= $db->bilgial;
				foreach($bilgial as $rowb){
					$y++;
				echo '
					<div class="radio radio-pink">
						<input'; if($db->VeriOkuTek($vt, $rows["url"], "id", $id) == $rowb->$rows["options_id"]) { echo ' checked'; } echo ' type="radio" name="' . $rows["url"] . '" id="' . $rows["url"] . "_" . $y . '" value="' . $rowb->$rows["options_id"] . '">
						<label for="' . $rows["url"] . "_" . $y . '">' . $rowb->$rows["options_name"] . '</label>
					</div>
				';
			}
			}
	echo'
		</div>
	</div>';
}

}
}
?>
	                                            <button type="submit" class="btn btn-success waves-effect waves-light">Kaydet</button>
	                                        </form>
                        				</div>                    				
                        			</div>
                        		</div>
							</div>
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
$sayfa = isset($_GET['page_num']) ? (int) $_GET['page_num'] : 1;

$toplam_sayfa = ceil($db->veriSaydirSorgu("SELECT * FROM " . $vt . $search . " " . $extra_sql) / $row_limit);

if($sayfa < 1) { $sayfa = 1; } 
if($sayfa > $toplam_sayfa) { $sayfa = $toplam_sayfa; } 

$limit = ($sayfa - 1) * $row_limit;

$toplam_icerik = $db->veriSaydirSorgu("SELECT * FROM " . $vt . $search . " " . $extra_sql);
if($toplam_icerik > 0) {
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
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . $search . " " . $extra_sql . " ORDER BY " . $order_by . " LIMIT " . $limit . ", " . $row_limit);
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
?>
                                                <tr id="item-<?=$rows->id;?>">    
<?php
	foreach($tablo as $sira => $row){
	if($row["list"] == 1) {
		if(in_array($row["type"], $normal_kayit) or $row["type"] == "clock_now" or $row["type"] == "seo" or $row["type"] == "admin") {
			echo '<td>' . $rows->$row["url"] . '</td>';
		} elseif($row["type"] == "date" or $row["type"] == "date_now") {
			echo '<td>';
			if($rows->$row["url"] != "0000-00-00") {
				echo date_format(date_create_from_format($row["write_format"], $rows->$row["url"]), $row["read_format"]);
			}
			echo '</td>';
		} elseif($row["type"] == "image") {
			echo '<td><a href="' . $row["options"]["process"] . $rows->$row["url"] . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Resim Önizleme</span> </a></td>';
		} else if($row["type"] == "file") {
			echo '<td><a href="' . $row["upload"] . $rows->$row["url"] . '" class="image-popup btn btn-default waves-effect waves-light"> <i class="fa fa-eye m-r-5"></i> <span>Dosyayı İndir</span> </a></td>';
		} elseif($row["type"] == "data" and $row["url"] == "row") {
			if($_POST["search"] == "") {
				echo '<td class="sortable" style="width:20px"><i class="glyphicon glyphicon-sort"></i></td>';
			} else {
				echo '<td style="width:20px"><i class="glyphicon glyphicon-sort"></i></td>';
			}
		} elseif($row["type"] == "data") {
			echo '<td>' . $rows->$row["url"] . '</td>';
		} elseif($row["type"] == "selectbox_array" or $row["type"] == "radio_array") {
			echo '<td>' . $row["options"][$rows->$row["url"]] . '</td>';
		} elseif($row["type"] == "selectbox_db" or $row["type"] == "radio_db") {
			echo '<td>' . $db->VeriOkuTek($row["vt"], $row["options_name"], $row["options_id"], $rows->$row["url"]) . '</td>';
		} elseif($row["type"] == "checkbox_array") {
			$json_decode = json_decode($rows->$row["url"], true);
			echo '<td>';
				if($json_decode != "") {
					foreach($json_decode as $checkbox_value) {
						echo $row["options"][$checkbox_value] . '<br>';
					}
				}
			echo '</td>';
		} elseif($row["type"] == "checkbox_db") {
			$json_decode = json_decode($rows->$row["url"], true);
			echo '<td>';
				if($json_decode != "") {
					foreach($json_decode as $checkbox_value) {
						echo $db->VeriOkuTek($row["vt"], $row["options_name"], $row["options_id"], $checkbox_value) . '<br>';
					}
				}
			echo '</td>';
		} 
	}
} ?>
                                                    <td style="width:auto">
														<?php foreach($special_button as $button_val => $button_url) { ?>
                                                    	<a href="<?=str_replace("%id", $rows->id, $button_url);?>" title="<?=$button_val;?>" class="btn btn-icon btn-primary waves-effect waves-light"><?=$button_val;?></a>
														<?php } ?>
														<div class="btn-group">
															
															<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Silmeye hazır!', '<?=$link;?>action=delete&id=<?=$rows->id;?>')" title="Sil" class="btn btn-icon btn-danger  waves-effect waves-light"><i class="md md-close"></i></a>
														</div>
                                                    </td>
                                                </tr>
<?php } ?>
                                            </tbody>
                                        </table>
									</div>
                        			<div class="row">
			                        	<div class="col-sm-6 margin-top"><?php if($toplam_icerik == 1) { echo '1 kayıt gösteriliyor'; } else {?><strong><?=$toplam_icerik;?></strong> kayıt içinden <strong><?=(($sayfa-1)*$row_limit)+1; ?></strong> ile <strong><?php if($sayfa*$row_limit <= $toplam_icerik) { echo $sayfa*$row_limit; } else { echo $toplam_icerik; }?></strong> arasındaki kayıtlar gösteriliyor<?php } ?></div>
			                        	<div class="col-sm-6">
											<ul class="pagination pull-right">
												<?php if($sayfa > 1) { ?>
												<li>
													<a href="<?=page_simple;?>page_num=<?=$sayfa-1;?>"><i class="fa fa-angle-left"></i></a>
												</li>
												<?php } ?>
												<?php
													for($i = ($sayfa-3); $i <= ($sayfa + 3); $i++) {
													if($i > 0 and $i <= $toplam_sayfa) {
												?>
												<li <?php if($sayfa == $i) { echo 'class="active"'; } ?>>
													<a href="<?php if($sayfa == $i) { echo '#'; } else { echo page_simple . "page_num=" . $i; } ?>"><?=$i;?></a>
												</li>
												<?php }} ?>
												<?php if($sayfa < $toplam_sayfa) { ?>
												<li>
													<a href="<?=page_simple;?>page_num=<?=$sayfa++;?>"><i class="fa fa-angle-right"></i></a>
												</li>
												<?php } ?>
											</ul>
										</div>
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


<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>


<script src="assets/plugins/notifyjs/dist/notify.min.js"></script>
<script src="assets/plugins/notifications/notify-metro.js"></script>


<!-- Modal-Effect -->
<script src="assets/plugins/custombox/dist/custombox.min.js"></script>
<script src="assets/plugins/custombox/dist/legacy.min.js"></script>
<script src="assets/plugins/summernote/dist/summernote.js"></script>
<script src="assets/plugins/tinymce/tinymce.min.js"></script>
<script src="assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

<script src="assets/js/jquery-ui.js"></script>
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
<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>

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