<?php
session_start();
ob_start(); 

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	header('Content-Type: text/html; charset=utf-8');

	include("include/static.php");
	include("include/function.php");
	include("include/db.php");
	include("class.upload.php");

	$db = new dbcon();
	
	if(!isset($_SESSION[$session_value])) {
		header("Location: login.php");
	} else if($db->VeriSaydir("managers", array("id"), array($_SESSION[$session_value])) == 0) {
		unset($_SESSION[$session_value]);
		header("Location: login.php");
	}
	
	$link = "index.php?page=" . $page . "&";
?>