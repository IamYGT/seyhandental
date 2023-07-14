<?php
$session_value = "515df1g5df1gs5132343f5as5ew48e48w";
error_reporting(0);
class dbcon{
    
    public $veritabani = "seyhandental_db"; //veritabanı adı
    public $host="localhost"; 
    public $hesap="seyhandental_db"; //kullanıcı adı
    public $sifre="2C)WE9344a4@"; //sifre
    public $baglan;
    public $bilgial = array();
    
    function __construct()
    {
        try{
           
              $this->baglan = new PDO("mysql:host=$this->host;dbname=$this->veritabani",$this->hesap,$this->sifre);
              $this->baglan->exec("SET NAMES UTF8 COLLATE utf8_unicode_ci");
        }catch(PDOException $e){
              echo $e->getMessage();
        }
     
    }
	
    function VeriOkuTek($tablo,$alan,$sartalan,$sartkarsilik)
    {       
            $dondur =NULL;
            $yenisorgu = "SELECT $alan FROM $tablo WHERE $sartalan=?";
            $stuncek = $this->baglan->prepare($yenisorgu);
            $stuncek->execute(array($sartkarsilik));
            $dondur = $stuncek->fetch(PDO::FETCH_OBJ);
            return $dondur->{$alan} ;
    }
	function VeriOkuRastgele($tablo,$alan,$istenmeyen = false){
		do{
		$dondur = NULL;
		$yenisorgu = "SELECT url FROM referanslar ORDER BY RAND() LIMIT 1";
		$stuncek = $this->baglan->prepare($yenisorgu);
		$stuncek->execute(array($sartkarsilik));
		$dondur = $stuncek->fetch(PDO::FETCH_OBJ);
		if($istenmeyen != $dondur->{$alan}){
			$istenmeyen = false;
		}
		}while($istenmeyen);
		return $dondur->{$alan};
	}
     function ayarlar($alan,$sartkarsilik)
    {       
            $dondur =NULL;
            $yenisorgu = "SELECT $alan FROM general_settings WHERE url=?";
            $stuncek = $this->baglan->prepare($yenisorgu);
            $stuncek->execute(array($sartkarsilik));
            $dondur = $stuncek->fetch(PDO::FETCH_OBJ);
            return $dondur->{$alan};
         
    }

    function BasiSonu($tablo,$alan,$sartalan,$sartkarsilik,$order,$ordertur)
    {       
            $dondur =NULL;
            $yenisorgu = "SELECT $alan FROM $tablo WHERE $sartalan=? ORDER BY $order $ordertur LIMIT 1";
            $stuncek = $this->baglan->prepare($yenisorgu);
            $stuncek->execute(array($sartkarsilik));
            $dondur = $stuncek->fetch(PDO::FETCH_OBJ);
            return $dondur->{$alan};
         
    }
	
    function VeriOkuCoklu($tablo,$sartalan = array(), $sartkarsilik=array(),$order = "",$ordertur ="",$limit=""){
        
         if(count($sartalan)==0){
            $this->bilgial=null;
            if($order!="" AND $limit==""){
				$yenisorgu = "SELECT * FROM $tablo ORDER BY $order $ordertur";
            }elseif($order!="" AND $limit!=""){
				$yenisorgu = "SELECT * FROM $tablo ORDER BY $order $ordertur LIMIT $limit";    
            }
            elseif($order=="" AND $limit==""){
				$yenisorgu = "SELECT * FROM $tablo";
            }
                $alancek = $this->baglan->query("$yenisorgu");
				
                    while($row = $alancek->fetch(PDO::FETCH_OBJ)){
                        $this->bilgial[] = $row;
                    }
         }else{
                $this->bilgial=null;
                $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal."=? AND ";
            }
                $kes = trim(substr($birlestir,0,-4));
                if($order!="" AND $limit==""){
                    $yenisorgu = "SELECT * FROM $tablo"." WHERE $kes ORDER BY $order $ordertur";
                }elseif($order!="" AND $limit!=""){
                    $yenisorgu = "SELECT * FROM $tablo"." WHERE $kes ORDER BY $order $ordertur LIMIT $limit";
                }elseif($order=="" AND $limit=="") {
                    $yenisorgu = "SELECT * FROM $tablo"." WHERE $kes";
                }

                $alancek = $this->baglan->prepare("$yenisorgu");
                $alancek->execute($sartkarsilik);
                    while($row = $alancek->fetch(PDO::FETCH_OBJ)){
                        $this->bilgial[] = $row;
                    }
         }
    }
    
     function veriEkle($tablo,$sartalan = array(), $sartkarsilik=array()){
        $sayi=0;
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal.",";
            }
                $kes = trim(substr($birlestir,0,-1));
              
        
        $ekleme=$this->baglan->prepare("INSERT INTO $tablo VALUES ($kes)");
        $ekleme->execute($sartkarsilik);  
        if($ekleme){
            $sayi=1;
        }else{
            $sayi=0;
        }
        
        return $sayi;
    }
    
        function veriGuncelle($tablo,$sartalan = array(), $sartkarsilik=array(),$where){
        $sayi=0;
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal."=?,";
            }
                $kes = trim(substr($birlestir,0,-1));
              
        
        $ekleme=$this->baglan->prepare("UPDATE $tablo SET $kes WHERE $where=?");
        $ekleme->execute($sartkarsilik);  
        if($ekleme){
            $sayi=1;
        }else{
            $sayi=0;
        }
        
        return $sayi;
    }
    
     function veriGuncelleCoklu($tablo,$sartalan = array(), $sartkarsilik=array(),$where=array()){
        $sayi=0;
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal."=?,";
            }
                $kes = trim(substr($birlestir,0,-1));
              
          $wherealan ="";
                foreach($where as $sartal){
                $wherealan .= $sartal."=? AND";
            }
                $keswhere = trim(substr($wherealan,0,-4));
              
        
        $ekleme=$this->baglan->prepare("UPDATE $tablo SET $kes WHERE $keswhere");
        $ekleme->execute($sartkarsilik);  
        if($ekleme){
            $sayi=1;
        }else{
            $sayi=0;
        }
        
        return $sayi;
    }
    
    function veriSil($tablo,$sartalan = array(), $sartkarsilik=array()){
        $sayi = 0;
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal."=? AND ";
            }
        $kes = trim(substr($birlestir,0,-4));
        
        $silme=$this->baglan->prepare("DELETE FROM $tablo WHERE $kes");
        $silme->execute($sartkarsilik);
        
        if($silme){
            $sayi=1;
        }else{
            $sayi=0;
        }
    }
	
    function veriSaydir($tablo,$sartalan = array(), $sartkarsilik=array()){
        $sayi=0;
        if(count($sartalan)==0){
        $sorgu = $this->baglan->prepare("SELECT * FROM $tablo");
        $sorgu->execute($sartkarsilik);
        $sayi = $sorgu->rowCount();
        
        }else{
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal."=? AND ";
            }
        $kes = trim(substr($birlestir,0,-4));
        
        $sorgu = $this->baglan->prepare("SELECT * FROM $tablo WHERE $kes");
        $sorgu->execute($sartkarsilik);
        $sayi = $sorgu->rowCount();
      
        }
        return $sayi;
        
    }
    
     function veriEkleSayiAl($tablo,$sartalan = array(), $sartkarsilik=array()){
        $sayi=0;
        $birlestir ="";
                foreach($sartalan as $sartal){
                $birlestir .= $sartal.",";
            }
                $kes = trim(substr($birlestir,0,-1));
              
              
        
        $ekleme=$this->baglan->prepare("INSERT INTO $tablo VALUES ($kes)");
        $ekleme->execute($sartkarsilik);  
        $sayi = $this->baglan->lastInsertId();
        
        return $sayi;
    }
    
    
    
    
     function VeriOkuMulti($sorgu) {
        $this->bilgial = null;
        $statement = $this->baglan->query("$sorgu",PDO::FETCH_OBJ);
        $statement->nextRowset();
        $rowset = $statement->fetchAll();
        
        foreach($rowset as $row) {
            $this->bilgial[]=$row;
        }
    }
    
    function VeriOkuCokluSorgu($sorgu){
      $this->bilgial=null;
        foreach($this->baglan->query("$sorgu",PDO::FETCH_OBJ) as $row){
            
           $this->bilgial[]=$row;
        }
    }
    function veriSaydirSorgu($sorgu,$sart = array()){
               
        $sayi=0;
        
        $sorgu = $this->baglan->prepare("$sorgu");
        $sorgu->execute($sart);
        $sayi = $sorgu->rowCount();
        
        return $sayi;
    }

function __destruct(){
    $this->baglan=null; 
}
  
}
//$veri= new veritabaniislem();
//
//// Clasın içerisinden şarta bağlı tek veri okumak için kullanıyoruz
//$veriyaz = $veri->VeriOkuTek("SELECT bilgiBASLIK FROM bilgi WHERE bilgiID=?",2,"bilgiBASLIK");
//// Tek Veriyi Yazdırıyoruz
//echo $veriyaz."<BR>";
//
//// Clasın içerisinden herhangi bir şart olmaksızın topku veri okuyoruz
//$bilgi= $veri->VeriOkuCoklu("SELECT * FROM bilgi");
//// Okudupumuz veriyi bilgial değişkenine atıyoruz
//$bilgial= $veri->bilgial;
//
//// bilgial değişkenini forech döngüsüne atıyoruz
//foreach($bilgial as $bilgiler){
//    echo $bilgiler->bilgiID."<BR>";
//    echo $bilgiler->bilgiBASLIK."<BR>";
//    
//}
//
//// Bilgi Ekleme Başlıyor Aynı Zamanda Düzenleme Metodudur.
//
//
//$degisken = array('BilgidirYeni',"Bilgi Açıklaması Yeni","Bilginin İçeriği Yeni","Bilgi Dipnotu Yeni","Bilgi-Url-Yeni");
//
//$veriekle = $veri->veriEkle("INSERT INTO bilgi VALUES(NULL,?,?,?,NOW(),?,?)",$degisken);
//if($veriekle==1){
//    echo "Veri Eklendi";
//}else{
//    echo"Veri Eklenemedi";
//}
//
////Bilgi Silme Başlıyor
//$bilgisildegisken=array("2");
//$verisil = $veri->veriSil("DELETE FROM bilgi WHERE bilgiID=?",$bilgisildegisken);
//if($verisil){
//    echo"Veri Silindi";
//}else{
//    echo"Veri Silinemedi";
//}

?>