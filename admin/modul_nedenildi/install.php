<?php
//Install Information
$install_modul_name = "Numaralarla Biz";
$install_modul_icon = "ti-check";
$table = "num";

$install_sql = "";
$uninstall_sql = "RENAME TABLE " . $table . " TO b" . time() . "_" . $table . ";";
?>