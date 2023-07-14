<?php 
include("include/top.php");
$f = 0;
if($_GET["action"] == "row") {
	if ( is_array($_POST['item']) ){		
		foreach ( $_POST['item'] as $key => $value ){
			$db->veriGuncelle("modul",array("row"),array(($key+1),$value),"id");
		}
		$returnMsg = array( 'islemSonuc' => true , 'islemMsj' => '<div class="alert alert-success" role="alert">Sıra Güncellendi</div>' );
	} else {
		$returnMsg = array( 'islemSonuc' => false , 'islemMsj' => '<div class="alert alert-danger" role="alert">Sıra Güncellenirken Hata Oluştu</div>' );
	}

	if ( isset($returnMsg) ){
		echo json_encode($returnMsg);
	}
} else {
include("header.php");

if($_GET["file"] == 1) {
	$yuklenecek_dosya = "temp/" .  basename($_FILES['file']['name']);

	if (move_uploaded_file($_FILES['file']['tmp_name'], $yuklenecek_dosya))
	{
		$zip = new ZipArchive;
		$res = $zip->open($yuklenecek_dosya);
		if ($res === TRUE) {
		  $zip->extractTo('./');
		  $zip->close();
			$alert = 3;
			unlink($yuklenecek_dosya);
		} else {
			$alert = 4;
		}
	} else {
		$alert = 5;
	}
	
}

if($db->veriSaydir("modul", array(), array()) > 0) {
$bilgi= $db->VeriOkuCoklu("modul", array(), array());
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
	$db->veriGuncelle("modul",array("action"),array(0,$rows->id),"id");
}}
$f = 0;
$dir = opendir("./");
while (($modul = readdir($dir)) !== false)
{
$exp_file = explode("_", $modul);
if(is_dir($modul) and $exp_file[0] == "modul"){
	
	if($db->VeriSaydir("modul", array("url"), array($modul)) > 0) {
		$f++;
		$db->veriGuncelle("modul",array("action"),array(1,$modul),"url");
	} else {
		if(file_exists($modul . '/info.php')) {
			include($modul . '/info.php');
			$db->veriEkle("modul",array("NULL","?","?","?","?","?","?","?"),array($install_modul_name,$install_modul_icon,$modul,base64_encode($uninstall_sql),0,1,1));
			
			if($install_sql != "") {
				$db->veriSaydirSorgu($install_sql);
				$df = 1;
			}
		}
	}
}}

if($db->veriSaydir("modul", array("action"), array(0)) > 0) {
$bilgi= $db->VeriOkuCoklu("modul", array("action"), array(0));
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
	if(base64_decode($rows->uninstall) != "") {
		$db->veriSaydirSorgu(base64_decode($rows->uninstall));
	}
}
	$db->veriSil("modul", array("action"), array(0));
	$df = 1;
}

if($df == 1) {
	header("Location: " . $link . "alert=6");
}

if($_GET["status"] != "") {
	$status = $db->VeriOkuTek("modul", "status", "id", $_GET["status"]);
	
	if($status == 0) {
		$status = 1;
	} else {
		$status = 0;
	}
	
	if($db->veriGuncelle("modul",array("status"),array($status,$_GET["status"]),"id")==1) {
		header("Location: " . $link . "alert=1");
	} else {
		header("Location: " . $link . "alert=2");
	}
}

if($db->veriSaydir("modul", array(), array()) != $f) {
	header("Location: index.php?page=module");
}

?>

                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Modül Yönetimi</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">Modül Yönetimi</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<div class="card-box">
                        			<div class="table-responsive">
			                        	<a href="#add" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Yeni Modül</a>
<?php if($_GET["alert"] == 2) { 
	alert_error("İşlem gerçekleştirilirken hatayla karşılaştı");
} else if($_GET["alert"] == 1) { 
	alert_success("İşlem başarıyla tamamlandı");
} else if($_GET["alert"] == 3) { 
	aler_success("Modül Başarıyla Yüklendi");
} else if($_GET["alert"] == 4) { 
	alert_error("Dosya ZIP ten çıkarılırken bir hata oluştu. Sunucu üzerinden ZIP ten çıkarmayı deneyin.");
} else if($_GET["alert"] == 5) { 
	alert_error("Dosya yüklenirken bir hata oluştu");
} else if($_GET["alert"] == 6) { 
	alert_info("Modüller Güncellendi");
} ?>
<div id="sortable_sonuc"></div>
<?php
if($db->veriSaydirSorgu("SELECT * FROM modul ORDER BY row ASC") > 0) {
?>									
                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
													<th>Sıra</th>
													<th>Ad</th>
													<th>Url</th>
													<th>İşlem</th>
											</thead>
											
                                            <tbody id="sortable">
<?php
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM modul ORDER BY row ASC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
?>
                                                <tr id="item-<?=$rows->id;?>">    
													<td class="sortable" style="width:20px"><center><i class="fa fa-sort" aria-hidden="true"></i></center></td>
                                                    <td><i class="<?=$rows->icon;?>"></i> <?=$rows->name;?></td>
                                                    <td><?=$rows->url;?></td>
                                                    <td style="width:120px">
													<div class="btn-group">
													<?php if($rows->status == 1) { ?>
                                                    	<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Pasifleştirmeye hazır!', '<?=$link;?>status=<?=$rows->id;?>')" title="Pasifleştir" class="btn btn-icon btn-danger waves-effect waves-light"><i class="md md-close"></i></a>
													<?php } else { ?>
                                                    	<a href="javascript:;" onclick="$.Notification.confirm('success','top center', 'Aktifleştirmeye hazır!', '<?=$link;?>status=<?=$rows->id;?>')" title="Aktifleştir" class="btn btn-icon btn-success waves-effect waves-light"><i class="md md-done"></i></a>
													<?php } ?>
													</div>
                                                    </td>
                                                </tr>
<?php } ?>
                                            </tbody>
                                        </table>
<?php } else { ?>
	<div class="alert alert-warning">
	  <strong>Uyarı!</strong> Kayıtlı veri bulunmamaktadır
	</div>
<?php } ?>
                                    </div>
                        		</div>
                                
                            </div> <!-- end col -->                            
                        </div>
<!-- Modal -->
<div id="add" class="modal-demo">
	<button type="button" class="close" onclick="Custombox.close();">
		<span>&times;</span><span class="sr-only">Kapat</span>
	</button>
	<h4 class="custom-modal-title">Modül Ekle</h4>
	<div class="custom-modal-text text-left">
		<form role="form" enctype="multipart/form-data" action="<?=$link;?>file=1" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
			<div class="form-group">
				<label for="name">Dosya</label>
				<input type="file" name="file" data-placeholder="Dosya Seçilmedi" accept=".zip" class="filestyle" required data-buttonname="btn-primary">
			</div>
			<button type="submit" class="btn btn-default waves-effect waves-light">Yükle</button>
			<button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">Vazgeç</button>
		</form>
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
<script src="assets/js/jquery-ui.js"></script>

<script src="assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

<!-- Modal-Effect -->
<script src="assets/plugins/custombox/dist/custombox.min.js"></script>
<script src="assets/plugins/custombox/dist/legacy.min.js"></script>
<script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('form').parsley();
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


<?php include("footer.php"); } ?>