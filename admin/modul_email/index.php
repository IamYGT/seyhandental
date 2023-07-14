<?php 
//E-mail Module

include("include/top.php");

define('C_KULLANICI',$db->ayarlar("value", $module_on_ek . "_kullanici")); //CPANEL Kullanıcı Adı
define('C_PAROLA',$db->ayarlar("value", $module_on_ek . "_parola")); //CPANEL Parola
define('C_PORT',$db->ayarlar("value", $module_on_ek . "_port")); //CPANEL Port
define('LIMIT',$db->ayarlar("value", $module_on_ek . "_kota"));
define('DOMAIN',$db->ayarlar("value", $module_on_ek . "_domain"));
define('HOST_IP',$db->ayarlar("value", $module_on_ek . "_ip"));

include($module_dir . 'lib/functions.php');
include($module_dir . "lib/xmlapi.php");
include($module_dir . 'lib/class_cpanel.php');

$new = new CPanelim();

include("header.php"); 

if($_GET["delete"] != "") {
	$new->EmailSil($_GET["delete"]);
	$alert = 6;
}

if($_POST) {
	if($_GET["add"] == "new") {
		if($_POST["name"] == "" or $_POST["password"] == "" or $_POST["kota"] == "") {
			$alert = 1;
		} else if(strlen($_POST["password"]) < 8) {
			$alert = 3;
		} else {
			$new->EmailEkle($_POST["name"],$_POST["password"],$_POST["kota"],$_POST["yonlendir"]);
			$alert = 4;
		}
	}
	if($_GET["edit"] != "") {
		if($_POST["name"] == "") {
			$alert = 2;
		} else if($_POST["password"] != "" and strlen($_POST["password"]) < 8) {
			$alert = 3;
		} else {
			$email = $_POST['name'] . "@" . DOMAIN;
			$new->EmailGuncelle($email,$_POST["password"]);
			$alert = 8;
		}
	}
}
?>
                      <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">E-posta Yönetimi</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">E-posta Yönetimi</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                        		<div class="card-box">
<?php 
if(C_KULLANICI != "" and C_PAROLA != "" and C_PORT != "" and LIMIT != "" and DOMAIN != "" and HOST_IP != "") {
?>
                        			<div class="row">
			                        	<div class="col-sm-12">

			                        		 <a href="#add" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Yeni E-posta Adresi</a>
			                        	</div>
			                        </div>
                        			<div class="table-responsive">
									<?php 
									if($alert == 1) { 
										alert_error("Kullanıcı, kota ve parola kısımlarını boş bırakamazsınız. Lütfen tekrar deneyiniz.");
									} else if($alert == 2) {
										alert_error("E-posta adresi hatası oluştu. Lütfen tekrar deneyiniz.");
									} else if($alert == 3) {
										alert_error("Parolanız en az 8 karakterden oluşmalıdır. Lütfen tekrar deneyiniz.");
									} else if($alert == 4) {
										alert_success("E-posta adresi başarıyla oluşturuldu.");
									} else if($alert == 6) {
										alert_success("E-posta adresi başarıyla silindi.");
									} else if($alert == 8) {
										alert_success("Parola başarıyla güncellendi.");
									}
									?>

                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
													<th>E-posta</th>
													<th>Kota</th>
													<th>Kullanılan Alan</th>
													<th>İşlem</th>
											</thead>
											
                                            <tbody>
<?php
	$result = $new->Emailler();
	foreach($result as $rows)
			{
	$dstring = $rows->email;
	$find = DOMAIN;
	$search = strpos($dstring, $find);
	//print all
	if(strlen($rows->email)>5 and $search){
	$email_exp = explode("@", $rows->email);
	
	if($rows->diskquota != 0) {
		$oran = ceil($rows->diskusedpercent/$rows->diskquota);
	} else {
		$oran = 0;
	}
?>
                                                <tr>    
                                                    <td><?=$rows->email;?></td>
                                                    <td><?php if($rows->diskquota=="unlimited") { echo 'Limitsiz'; } else { echo floor($rows->diskquota).' MB'; } ?></td>
                                                    <td>
														<div class="progress progress-lg m-b-5">
															<div class="progress-bar progress-bar-<?php if($oran > 90) { echo "danger"; } else { echo "success"; } ?> wow animated progress-animated" role="progressbar" aria-valuenow="96" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($rows->diskquota=="unlimited") { echo "0%"; } else { echo $oran . "%"; }  ?>;">
																<?php if($rows->diskquota=="unlimited") { echo "0%"; } else { echo $oran . "%"; }  ?>
															</div>
														</div>
													</td>
                                                    <td style="width:120px">
													<div class="btn-group">
                                                    	<a href="#edit" title="Parola Değiştir" onClick="anlik('<?=$email_exp[0];?>');" class="btn btn-icon btn-warning waves-effect waves-light " data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-edit"></i></a>
                                                    	<a href="javascript:;" onclick="$.Notification.confirm('black','top center', 'Silmeye hazır!', '<?=$link;?>delete=<?=$rows->email;?>')" title="Sil" class="btn btn-icon btn-danger  waves-effect waves-light"><i class="md md-close"></i></a>
													</div>
                                                    </td>
                                                </tr>
			<?php }} ?>
                                            </tbody>
                                        </table>

                                    </div>
<?php } else {
	alert_error("Lütfen Modül Ayarlarınızı Eksiksiz Yapınız");
}
?>
                        		</div>
                                
                            </div> <!-- end col -->

                            
                        </div>
<!-- Modal -->
<div id="add" class="modal-demo">
	<button type="button" class="close" onclick="Custombox.close();">
		<span>&times;</span><span class="sr-only">Kapat</span>
	</button>
	<h4 class="custom-modal-title">E-posta Adresi Ekle</h4>
	<div class="custom-modal-text text-left">
		<form role="form" action="<?=$link;?>add=new" method="post">
			<div class="form-group">
				<label for="addname">Kullanıcı</label>
				<div class="input-group m-t-10">
					<input type="text" id="addname" required name="name" class="form-control">
					<span class="input-group-addon">@<?=DOMAIN;?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="addpassword">Parola</label>
				<div class="input-group m-t-10">
					<input type="text" id="addpassword" required data-parsley-minlength="8" name="password" class="form-control">
					<span class="input-group-btn">
					<button type="button" onclick="parola_uret('addpassword');" class="btn waves-effect waves-light btn-primary">Parola Üret</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label for="kota">Kota</label>
				<div class="input-group m-t-10">
					<input type="text" id="kota" required data-parsley-type="number" name="kota" class="form-control" value="<?php echo LIMIT;?>">
					<span class="input-group-addon">MB</span>
				</div>
				<br>
				<?php alert_info("Sınırsız kota için '0' yazmanız gerekmektedir.");?> 
			</div>
			<div class="form-group">
				<label for="yonlendir">Yönlendirilecek Adres</label>
				<input type="email" parsley-type="email" class="form-control" name="yonlendir" id="yonlendir">
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
	<h4 class="custom-modal-title">Parola Değiştir</h4>
	<div class="custom-modal-text text-left">
		<form role="form" action="<?=$link;?>edit=new" method="post">
			<div class="form-group">
				<label for="editname">Kullanıcı</label>
				<div class="input-group m-t-10">
					<input type="hidden" id="editnamehid" name="name">
					<input type="text" disabled id="editname" name="disabled" class="form-control">
					<span class="input-group-addon">@<?=DOMAIN;?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="password">Parola</label>
				<div class="input-group m-t-10">
					<input type="text" id="password" required data-parsley-minlength="8" name="password" class="form-control">
					<span class="input-group-btn">
					<button type="button" onclick="parola_uret('password');" class="btn waves-effect waves-light btn-primary">Parola Üret</button>
					</span>
				</div>
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
	
	function parola_uret(id) {
		var length = 8,
			charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
			retVal = "";
		for (var i = 0, n = charset.length; i < length; ++i) {
			retVal += charset.charAt(Math.floor(Math.random() * n));
		}
		$("#" + id).val(retVal);
	}
	
	function anlik(name){
		$("#editnamehid").val(name);
		$("#editname").val(name);
	} 
</script>
 <?php include("footer.php");?>