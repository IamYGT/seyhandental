<?php 
include("include/top.php");
include("header.php"); 

?>                      <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Posta Kutusu</h4>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Ana Sayfa</a></li>
                                    <li class="active">Posta Kutusu</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
								<div class="embed-responsive embed-responsive-4by3">
								  <iframe class="embed-responsive-item" src="<?=$db->ayarlar("value", $module_on_ek . "_adres");?>"></iframe>
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

<script type="text/javascript">
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