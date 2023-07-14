<?php
//Install Information
$install_modul_name = "E-posta Yönetimi";
$install_modul_icon = "ti-email";
$install_sql = "
INSERT INTO `general_settings` (`id`, `name`, `url`, `value`, `type`, `options`, `forced`) VALUES
(NULL, 'E-posta Domain Adresi', 'modul_email_domain', '" . $_SERVER["HTTP_HOST"] . "', 'text', '', 1),
(NULL, 'E-posta Hosting IP', 'modul_email_ip', '" . gethostbyname($_SERVER["HTTP_HOST"]) . "', 'text', '', 1),
(NULL, 'CPANEL Kullanıcı Adı', 'modul_email_kullanici', '', 'text', '', 1),
(NULL, 'CPANEL Parola', 'modul_email_parola', '', 'text', '', 1),
(NULL, 'CPANEL Port', 'modul_email_port', '', 'text', '', 1),
(NULL, 'Varsayılan E-posta Kotası', 'modul_email_kota', '100', 'text', '', 1);
";
$uninstall_sql = "
DELETE FROM `general_settings` WHERE url = 'modul_email_domain';
DELETE FROM `general_settings` WHERE url = 'modul_email_ip';
DELETE FROM `general_settings` WHERE url = 'modul_email_kullanici';
DELETE FROM `general_settings` WHERE url = 'modul_email_parola';
DELETE FROM `general_settings` WHERE url = 'modul_email_port';
DELETE FROM `general_settings` WHERE url = 'modul_email_kota';
";
?>