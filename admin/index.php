<?php
$page = @$_GET["page"];
$alert = 0;
if(empty($page)) {
$page = "main";
}
if (file_exists($page . ".php")) {
	include($page . ".php");
} else if(file_exists($page . "/index.php")) {
	$module_dir = $page . "/";
	$module_on_ek = $page;
	if(isset($_GET["action"]) and $_GET["action"] != "") {
		$action = $_GET["action"];
		include($page . "/index.php");
	} else {
		include($page . "/index.php");
	}
} else {
	include("404.php");
}
?>