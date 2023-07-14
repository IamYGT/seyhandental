<?php 
	//post
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }
  //get
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }
  //send headers
  function send_to($direction)
  	{
      if (!headers_sent()) {
          header('Location: ' . $direction);
		  exit;
	  } else
          print '<script type="text/javascript">';
          print 'window.location.href="' . $direction . '";';
          print '</script>';
          print '<noscript>';
          print '<meta http-equiv="refresh" content="0;url=' . $direction . '" />';
          print '</noscript>';
  	}
	
	function appnotify(){
	print('<link type="text/css" rel="stylesheet" href="public/themes/default/css/ui.notify.css" />
	<script src="public/themes/default/js/jquery.notify.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function create( template, vars, opts ){
		return $container.notify("create", template, vars, opts);
	}
	$(function(){
		$container = $("#container").notify();
		create("withIcon");
	});
	</script>');
	 }
	 //msgs
	function success_msg($dmsg){
	print('<div id="content">
	<div id="container" style="display:none">
	<div id="withIcon" class="success-msg mbg">
	<a class="ui-notify-close ui-notify-cross" href="#">x</a>
	<div style="float:left;margin:0 10px 0 0"><img src="assets/img/accept.png" /></div>
	<h1>Success Message:</h1>
	<p>'.$dmsg.'</p>
	</div></div>
	');	
	}
	function error_msg($dmsg){
	print('<div id="content">
	<div id="container" style="display:none">
	<div id="withIcon" class="error-msg mbg">
	<a class="ui-notify-close ui-notify-cross" href="#">x</a>
	<div style="float:left;margin:0 10px 0 0"><img src="assets/img/deleteb.png" /></div>
	<h1>Error Message:</h1>
	<p>'.$dmsg.'</p>
	</div></div>
	');	
	}
	//editor
	function HezecomEditor($txteditor){
	print("<script> 
	$().ready(function() {
	  $('#".$txteditor."').elrte({
		height : 200,
		toolbar : 'complete',
	  });
	});
	</script>
	");	
	}
	//File
	function delete_files($folder){
	  if(is_file($folder))
	unlink($folder);
		}
	//dir
	function app_dir($folder=NULL){
	$base = str_replace($folder,'',dirname(__FILE__));
	return str_replace('\\','/',$base);
	}

?>
