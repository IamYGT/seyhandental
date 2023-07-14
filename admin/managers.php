<?php 
include("include/top.php");
$vt = "managers";

if($_GET["ajax"] == 1) {
	if($db->veriSaydir($vt, array("id"), array($_POST["id"])) > 0) {
	$bilgi= $db->VeriOkuCoklu($vt, array("id"), array($_POST["id"]));
	$bilgial= $db->bilgial;
	foreach($bilgial as $rows){
		$sonuc = array("name" => $rows->name, "email" => $rows->email);
	}} else {
		$sonuc = array();
	}
	echo json_encode($sonuc);

	exit();
}

include("header.php"); 

if($_GET["delete"] != "") {
	if($_GET["delete"] == 1 or $db->veriSaydir($vt, array("id"), array($_GET["delete"])) == 0) {
		$alert = 7;
	} else {
		if($db->veriSil($vt, array("id"), array($_GET["delete"])) == 0) {
			$alert = 6;
		} else {
			$alert = 7;
		}
	}
}

if($_POST) {
	if($_GET["add"] == "new") {
		if($_POST["name"] == "" or $_POST["email"] == "" or $_POST["password"] == "") {
			$alert = 1;
		} else if($db->veriSaydir($vt, array("email"), array($_POST["email"])) > 0) {
			$alert = 2;
		} else if(strlen($_POST["password"]) < 8) {
			$alert = 3;
		} else {
			if($db->veriEkle($vt,array("NULL","?","?","?","?","?"),array($_POST["name"],$_POST["email"],md5($_POST["password"]),date("Y-m-d"),"")) == 1) {
				$alert = 4;
			} else {
				$alert = 5;
			}
		}
	}
	if($_GET["edit"] != "") {
		if($_POST["name"] == "" or $_POST["email"] == "") {
			$alert = 1;
		} else if($db->veriSaydirSorgu("SELECT id FROM " . $vt . " WHERE email = '" . $_POST["email"] . "' and id != '" . $_POST["id"] ."'") > 0) {
			$alert = 2;
		} else if($_POST["password"] != "" and strlen($_POST["password"]) < 8) {
			$alert = 3;
		} else {
			if($db->veriGuncelle($vt,array("name","email"),array($_POST["name"],$_POST["email"],$_POST["id"]),"id")==1) {
				
				if($_POST["password"] != "") {
					if($db->veriGuncelle($vt,array("password"),array(md5($_POST["password"]),$_POST["id"]),"id")==1) {
						$alert = 8;
					} else {
						$alert = 9;
					}
				} else {
					$alert = 8;
				}
			} else {
				$alert = 9;
			}
		}
	}
}
?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Yönetici Listesi</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">Yönetici Listesi</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
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
			                        		 <a href="#add" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Yeni Yönetici</a>
			                        	</div>
			                        </div>
                        			<div class="table-responsive">
									<?php 
									if($alert == 1) { 
										alert_error("Ad, e-posta ve parola kısımlarını boş bırakamazsınız. Lütfen tekrar deneyiniz.");
									} else if($alert == 2) {
										alert_error("Sistemde varolan bir e-posta adresi yazdınız. Lütfen başka bir e-posta adresiyle tekrar deneyiniz.");
									} else if($alert == 3) {
										alert_error("Parolanız en az 8 karakterden oluşmalıdır. Lütfen tekrar deneyiniz.");
									} else if($alert == 4) {
										alert_success("Yeni yönetici oluşturuldu.");
									} else if($alert == 5) {
										alert_error("Yönetici eklenemedi. Veri tabanı hatasıyla karşılaşıldı. Lütfen tekrar deneyiniz.");
									} else if($alert == 6) {
										alert_success("Yönetici başarıyla silindi.");
									} else if($alert == 7) {
										alert_error("Yönetici silinirken hatayla karşılaşıldı. Lütfen tekrar deneyiniz.");
									} else if($alert == 8) {
										alert_success("Yönetici başarıyla güncellendi.");
									} else if($alert == 9) {
										alert_error("Yönetici güncellenirken hatayla karşılaşıldı.");
									}
									?>

<?php
$search = "";
if($_POST["search"] != "") {
	$search = "(name LIKE '%" . $_POST["search"] . "%' or email LIKE '%" . $_POST["search"] . "%') and ";
}
if($db->veriSaydirSorgu("SELECT * FROM " . $vt . " WHERE " . $search . " id != '1' ORDER BY id DESC") > 0) {
?>
                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
													<th>Ad</th>
													<th>E-posta</th>
													<th>Kayıt Tarihi</th>
													<th>İşlem</th>
											</thead>
											
                                            <tbody>
<?php
$i=0;
$bilgi= $db->VeriOkuCokluSorgu("SELECT * FROM " . $vt . " WHERE " . $search . " id != '1' ORDER BY id DESC");
$bilgial= $db->bilgial;
foreach($bilgial as $rows){
$i++;
?>
                                                <tr>    
                                                    <td><?=$rows->name;?></td>
                                                    <td><a href="mailto:<?=$rows->email;?>"><?=$rows->email;?></a></td>
                                                    <td><?=mdtod($rows->register_date);?></td>
                                                    <td style="width:120px">
													<div class="btn-group">
                                                    	<a href="#edit" title="Düzenle" onClick="anlik(<?=$rows->id;?>);" class="btn btn-icon btn-warning waves-effect waves-light " data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-edit"></i></a>
                                                    	<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Silmeye hazır!', '<?=$link;?>delete=<?=$rows->id;?>')" title="Sil" class="btn btn-icon btn-danger  waves-effect waves-light"><i class="md md-close"></i></a>
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
	<h4 class="custom-modal-title">Yönetici Ekle</h4>
	<div class="custom-modal-text text-left">
		<form role="form" action="<?=$link;?>add=new" method="post">
			<div class="form-group">
				<label for="name">Ad</label>
				<input type="text" class="form-control" required name="name" id="name">
			</div>
			
			<div class="form-group">
				<label for="email">E-posta</label>
				<input type="email" class="form-control" required parsley-type="email" name="email" id="email">
			</div>
			
			<div class="form-group">
				<label for="password">Parola</label>
				<input type="text" class="form-control" required data-parsley-minlength="8" name="password" id="password">
			</div>
			
			
			<button type="submit" class="btn btn-default waves-effect waves-light">Kaydet</button>
			<button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">Vazgeç</button>
		</form>
	</div>
</div>
<div id="edit" class="modal-demo">
	<button type="button" class="close" onclick="Custombox.close();">
		<span>&times;</span><span class="sr-only">Kapat</span>
	</button>
	<h4 class="custom-modal-title">Yönetici Düzenle</h4>
	<div class="custom-modal-text text-left">
		<form role="form" action="<?=$link;?>edit=new" method="post">
			<input type="hidden" name="id" id="editid">
			<div class="form-group">
				<label for="name">Ad</label>
				<input type="text" class="form-control" required name="name" id="editname">
			</div>
			<div class="form-group">
				<label for="email">E-posta</label>
				<input type="email" class="form-control" required parsley-type="email" name="email" id="editemail">
			</div>
			<div class="form-group">
				<label for="password">Parola</label>
				<input type="text" class="form-control" required data-parsley-minlength="8" name="password" id="editpassword">
				<br>
				<?php alert_info("Parola güncelleme işlemi yapacaksanız doldurun.");?>
			</div>
			<button type="submit" class="btn btn-default waves-effect waves-light">Kaydet</button>
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

<!-- Modal-Effect -->
<script src="assets/plugins/custombox/dist/custombox.min.js"></script>
<script src="assets/plugins/custombox/dist/legacy.min.js"></script>
<script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('form').parsley();
	});
	
	function anlik(id){
		$.ajax({
			type:'POST',
			data: {"id":id},
			dataType: 'json',
			url:'<?=$link;?>ajax=1',
			success: function (msg) {
				$("#editname").val(msg.name);
				$("#editemail").val(msg.email);
				$("#editid").val(id);
			}
		});
	} 
</script>
 <?php include("footer.php");?>