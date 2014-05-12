<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
(!isset($_SESSION['staging'])?$_SESSION['staging']=0:'');
require_once("../class/class.admin.php");
$my = new admin();
$_REQUEST['action'] = isset($_REQUEST['action'])?$_REQUEST['action']:'admin_home';
if(method_exists($my, $_REQUEST['action'])){
	call_user_func_array(array($my, '__construct'), ''); 
	$set = call_user_func_array(array($my, $_REQUEST['action']), '');
}else{
	call_user_func_array(array($my, '__construct'), ''); 
	$set = call_user_func_array(array($my, 'admin_home'), '');
};
header('P3P: CP="CAO PSA OUR"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xht	ml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style media="all" type="text/css">@import "main_admin.css";</style>
	<script type="text/javascript" src="webtoolkit.aim.js"></script>
	<script type="text/javascript" src="jquery-1.4.2.js"></script> 
	<script type="text/javascript" src="jquery.validate.js"></script> 
	<script language="javascript" type="text/javascript" src="calendarDateInput.js"></script>
	<script type="text/javascript">
		function startCallback() {
			// make something useful before submit (onStart)
			
			document.getElementById('nr').innerHTML = '<img src=loader.gif>';
			document.getElementById('r').innerHTML = 'message sent';
			return true;
		}
		function completeCallback(response) {
			// make something useful after (onComplete)
			document.getElementById('r').innerHTML = response;
			document.getElementById('nr').innerHTML = '';
			<?php if(isset($set['dr'])){ ?>
			loadXMLDoc("<?=$set['dr'];?>");
			<?php } ?>
		}
		var xmlhttp;
		function loadXMLDoc(url) {
			xmlhttp=null;
			if (window.XMLHttpRequest) {// code for IE7, Firefox, Opera, etc.
				xmlhttp=new XMLHttpRequest();
			} else if (window.ActiveXObject) {// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			if (xmlhttp!=null) {
				document.getElementById('nr').innerHTML="<img src=loader.gif>";
				xmlhttp.open("GET",url,false);
				xmlhttp.send(null);
				if(xmlhttp.readyState  == 4){
					if(xmlhttp.status  == 200){
						//document.getElementById('dr').innerHTML=xmlhttp.status;
						//document.getElementById('dr').innerHTML=xmlhttp.statusText;
						document.getElementById('dr').innerHTML=xmlhttp.responseText;
					}else{
						document.getElementById('dr').innerHTML="Error code " + xmlhttp.status;
					}
				}
				document.getElementById('nr').innerHTML = '';
			}else{
				alert("Your browser does not support XMLHTTP.");
			}
		}
		function onPageload(){	
			<?php if(isset($set['form'])){ ?>
			admin = document.getElementById('mainform');
			<?php if($set['section'] == 'Data Integration Monitor') { ?>
			admin.getElementsByTagName("form")[0].onsubmit=function(){return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})};
			<?php }else{ ?>
			admin.getElementsByTagName("form")[0].onsubmit=function(){disableForm(this);return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})};
			<?php } ?>
			<?php } ?>
			<?php if(isset($set['dr'])){ ?>
			loadXMLDoc("<?=$set['dr'];?>");
			<?php } ?>
		};
		function disableForm(theform) {
			for (i = 0; i < theform.length; i++) {
			var tempobj = theform.elements[i];
			if (tempobj.type.toLowerCase() == "submit")
				tempobj.disabled = true;
			}
		}
	</script>
<!-- JAVASCRIPT --> 
<script> 
//$(document).ready(function(){$("#bulkorder").validate();});
</script>
</head>
<body onload="onPageload();">
<div id="main">
	<div id="header">	
		<?=($_SERVER['PHP_AUTH_USER']=="admin"?'<a href="javascript://" onClick="staging();">+</a>':'')?>
		<!--<a href="index.html" class="logo"><img src="img/logo.gif" width="101" height="29" alt="" /></a> -->
		<ul id="top-navigation">
		<?=$set['navigation'];?>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<?=$set['leftcolumn'];?>
		</div>
		<div id="center-column">
			<div class="top-bar">
				<?=$set['links'];?>
				<h1><?=$set['section'];?></h1>
				<?=$set['breadcrumbs'];?>
			</div><br />
		  <div class="select-bar">
			<span class="button" id="nr"></span>
			<div id="mainform">
			<?=$set['form'];?>
			</div>
			<br>
			<span id="r"></span>
		    <?=$set['search'];?>
		  </div>
			<div id="dr" class="table">
			</div>
		</div>
		<div id="right-column">
			<?=$set['rightcolumn'];?>
	  </div>
	</div>
	<div id="footer"></div>
</div>

<script type="text/javascript">
function staging(){
	loadXMLDoc("/admin/staging.php");
	window.location.reload();
}
<?php
if($_SESSION['staging']==1){
?>
document.body.style.background = '#FFE6C5';
document.getElementById("header").innerHTML += '<h1>Development</h1>';
<?php
}
?>
</script>
</body>
</html>