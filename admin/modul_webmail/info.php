<?php
//Install Information
$install_modul_name = "Posta Kutusu";
$install_modul_icon = "ti-comment-alt";
$install_sql = "
INSERT INTO `general_settings` (`id`, `name`, `url`, `value`, `type`, `options`, `forced`) VALUES
(NULL, 'Posta Kutusu Adresi', 'modul_webmail_adres', 'http://webmail." . $_SERVER["HTTP_HOST"] . "', 'text', '', 1);
";
$uninstall_sql = "
DELETE FROM `general_settings` WHERE url = 'modul_webmail_adres';
";
?>