<?php
//Function Page

function mdtod($tarih) 
{
$yeni_tarih = date_format(date_create_from_format('Y-m-d', $tarih), 'd/m/Y');
return $yeni_tarih;
}

function mdttodt($tarih) 
{
$yeni_tarih = date_format(date_create_from_format('Y-m-d H:i:s', $tarih), 'd/m/Y H:i');
return $yeni_tarih;
}

function dtomd($tarih) 
{
$yeni_tarih = date_format(date_create_from_format('d/m/Y', $tarih), 'Y-m-d');
return $yeni_tarih;
}

function seo($baslik){
   $baslik = str_replace(array("&quot;","&#39;"), NULL, $baslik);
		$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
		$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
		$perma = strtolower(str_replace($bul, $yap, $baslik));
		$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
		$perma = trim(preg_replace('/\s+/',' ', $perma));
		$perma = str_replace(' ', '-', $perma);
		return $perma;
}
    
function uzanti($file)
{
    $ext = pathinfo($file);
    return $ext['extension'];
}

function alert_error($text) {
	$text = '<div class="alert alert-danger">
				<strong>Hata!</strong> ' . $text . '
			</div>';
	echo $text;
}

function alert_success($text) {
	$text = '<div class="alert alert-success">
				<strong>Başarılı!</strong> ' . $text . '
			</div>';
	echo $text;
}

function alert_warning($text) {
	$text = '<div class="alert alert-warning">
				<strong>Uyarı!</strong> ' . $text . '
			</div>';
	echo $text;
}

function alert_info($text) {
	$text = '<div class="alert alert-info">
				<strong>Bilgi!</strong> ' . $text . '
			</div>';
	echo $text;
}
?>