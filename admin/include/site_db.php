<?php
	include("db.php");
	include("function.php");

	$db = new dbcon();

	$this_date = date("Y-m-d"); 
	$onlineSuresi=time()-(4*60*60);
	$ip=$_SERVER['REMOTE_ADDR'];
	
	if($db->VeriSaydir("hit", array("ip", "date"), array($ip, $this_date)) > 0){ 
		$al_id=$db->VeriOkuTek("hit", "id", array("ip", "date"), array($ip, $this_date));  
		$al_sayac=$db->VeriOkuTek("hit", "counter", array("ip", "date"), array($ip, $this_date));  
		$db->veriGuncelle("hit",array("counter"),array(($al_sayac+1),$al_id),"id");
	}else{
		$db->veriEkle("hit",array("NULL","?","?","?","?"),array($this_date,time(),1,$ip));
    } 
?>