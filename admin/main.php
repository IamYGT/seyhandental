<?php 
include("include/top.php");
include("header.php");
?>
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="page-title">Gösterge Paneli</h4>
                                <p class="text-muted page-title-alt">Memsidea İçerik Yönetim Sistemine Hoş Geldiniz!</p>
                            </div>
                            <div class="col-sm-3">
								<a class="btn btn-info waves-effect waves-light" href="javascript:;" onclick="$.Notification.notify('info','right middle', 'Tekil ve Çoğul Hit Nedir?', '<strong>Tekil Hit Nedir?</strong><br>Tekil hit, sitenize farklı IP lerden gelen ziyaretçilerin sayısıdır. Örneğin, bir ziyaretçi aynı gün içerisinde sitenize birden fazla giriyorsa tekil hitiniz bir artar.<br><br><strong>Çoğul Hit Nedir?</strong><br>Çoğul hit ise yine aynı günde ziyaretçinin siteyi ziyaret etme sayısıdır. Örnek verecek olursak bir ziyaretçi sitenize 10 kere girerse çoğul hitinize 10 eklenir.')"><span class="btn-label"><i class="glyphicon glyphicon-question-sign"></i></span> Tekil ve Çoğul Hit Nedir?</a>
							</div>
                        </div>

						

<?php
	$buay = date("m");
	$buyil = date("Y");
	
	$a_gunler = "";
	$a_tekil = "";
	$c_tekil = $db->veriSaydirSorgu("SELECT id FROM hit WHERE EXTRACT(MONTH FROM date) = '$buay' and EXTRACT(YEAR FROM date) = '$buyil' ORDER BY date ASC");
	$d_tekil = $db->veriSaydirSorgu("SELECT id FROM hit WHERE EXTRACT(YEAR FROM date) = '$buyil' ORDER BY date ASC");
	$a_cogul = "";
	$c_cogul = "";

	if($db->veriSaydirSorgu("SELECT id FROM hit WHERE EXTRACT(MONTH FROM date) = '$buay' and EXTRACT(YEAR FROM date) = '$buyil' ORDER BY date ASC") > 0) {
	$bilgi= $db->VeriOkuCokluSorgu("SELECT date, EXTRACT(DAY FROM date) as sadecegun FROM hit WHERE EXTRACT(MONTH FROM date) = '$buay' and EXTRACT(YEAR FROM date) = '$buyil' ORDER BY date ASC");
	$bilgial= $db->bilgial;
	foreach($bilgial as $rows){
		$a_gunler .= $rows->sadecegun . ",";
		$a_tekil .= $db->veriSaydirSorgu("SELECT id FROM hit WHERE date = '" . $rows->date . "'") . ",";
		$bilgi2= $db->VeriOkuCokluSorgu("SELECT SUM(counter) as cogul FROM hit WHERE date = '" . $rows->date . "'");
		$bilgial2= $db->bilgial;
		foreach($bilgial2 as $row){
			$a_cogul .= $row->cogul . ",";
			$c_cogul = $c_cogul + $row->cogul;
		}
	}}
	
	$a_gunler = rtrim($a_gunler,",");
	$a_tekil = rtrim($a_tekil,",");
	$a_cogul = rtrim($a_cogul,",");
 
	$b_tekil = $db->VeriSaydir("hit", array("date"), array(date("Y-m-d")));
	if($b_tekil > 0) {
	$bilgi= $db->VeriOkuCokluSorgu("SELECT SUM(counter) as cogul FROM hit WHERE date = '" . date("Y-m-d") . "'");
	$bilgial= $db->bilgial;
	foreach($bilgial as $rows){
		$b_cogul = $rows->cogul;
	}} else {
		$b_cogul = 0;
	}
?>
						<div class="row">
							<div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-info">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b><?=$d_tekil;?></b></h4>
											   <p class="text-muted m-b-0 m-t-0">Yıllık Tekil Hit</p>
											</div>


										</div>
									</div>
								</div>
							</div>

                            <div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-custom">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b><?=$c_tekil;?>/<?=$c_cogul;?></b></h4>
											   <p class="text-muted m-b-0 m-t-0">Bu Ayki Tekil/Çoğul Hit</p>
											</div>
                                            <div class="table-detail text-right">
                                                <span data-plugin="peity-pie" data-colors="#5fbeaa,#ebeff2" data-width="50" data-height="45"><?=$c_tekil;?>/<?=$c_cogul;?></span>
                                            </div>

										</div>
									</div>
								</div>
							</div>

                            <div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-danger">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b><?=$b_tekil;?>/<?=$b_cogul;?></b></h4>
											   <p class="text-muted m-b-0 m-t-0">Bugünkü Tekil/Çoğul Hit</p>
											</div>
                                            <div class="table-detail text-right">
                                                <span data-plugin="peity-donut" data-colors="#f05050,#ebeff2" data-width="50" data-height="45"><?=$b_tekil;?>/<?=$b_cogul;?></span>
                                            </div>

										</div>
									</div>
								</div>
							</div>
						</div>

                        <div class="row">

                            <div class="col-lg-12">
                        		<div class="card-box">
                        			<h4 class="text-dark header-title m-t-0">Bu Ayki Tekil - Çoğul Ziyaretçi Grafiği</h4>

                                    <div id="gunluk-tekil-cogul"></div>


                        		</div>

                            </div>

                            <!-- col -->
                        </div>
                        <!-- end row -->
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

<script src="assets/plugins/peity/jquery.peity.min.js"></script>

<!-- jQuery  -->
<script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

<script type="text/javascript" src="assets/plugins/d3/d3.min.js"></script>
<script type="text/javascript" src="assets/plugins/c3/c3.min.js"></script>

<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>

<script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

<script src="assets/pages/jquery.dashboard.js"></script>

<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.counter').counterUp({
			delay: 100,
			time: 1200
		});

		$(".knob").knob();

	});
	
!function($) {
    "use strict";

    var ChartC3 = function() {};

    ChartC3.prototype.init = function () {
        //stacked chart
        c3.generate({
            bindto: '#gunluk-tekil-cogul',
            data: {
				x: 'x',
                columns: [
					['x', <?=$a_gunler;?>],
                    ['Tekil', <?=$a_tekil;?>],
                    ['Çoğul', <?=$a_cogul;?>]
                ],
                types: {
                    data1: 'area',
                    data2: 'area'
                    // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                },
                colors: {
                    data1: '#5fbeaa',
                    data2: '#5d9cec',
                }
            }
        });
    },
    $.ChartC3 = new ChartC3, $.ChartC3.Constructor = ChartC3

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.ChartC3.init()
}(window.jQuery);

</script>

<script src="assets/plugins/notifyjs/dist/notify.min.js"></script>
<script src="assets/plugins/notifications/notify-metro.js"></script>

<?php include("footer.php");?>