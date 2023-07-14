<?php
//Install Information
$install_modul_name = "Haberler";
$install_modul_icon = "ti-book";
$table = "haberler";

$install_sql = "
CREATE TABLE `" . $table . "` (
  `id` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `aciklama` text COLLATE utf8_unicode_ci NOT NULL,
  `kapak` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `" . $table . "` ADD PRIMARY KEY (`id`);

ALTER TABLE `" . $table . "` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";
$uninstall_sql = "RENAME TABLE " . $table . " TO b" . time() . "_" . $table . ";";
?>