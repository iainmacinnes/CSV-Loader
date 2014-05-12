<?php
class admin {
	
	var $setting = array();
	var $path;
	var $user;
	var $useraccess;
	var $window;
	
	function __construct(){
		$this->user = isset($_SERVER["REMOTE_USER"])?$_SERVER["REMOTE_USER"]:'';
		$this->window = 'open';
		$this->useraccess = $this->access($this->user);
		$this->setting['leftcolumn'] = '<!--<h3>Header</h3>
				<ul class="nav">
					<li><a href="#">Lorem Ipsum dollar</a></li>
					<li><a href="#">Dollar</a></li>
					<li><a href="#">Lorem dollar</a></li>
					<li><a href="#">Ipsum dollar</a></li>
					<li><a href="#">Lorem Ipsum dollar</a></li>
					<li class="last"><a href="#">Dollar Lorem Ipsum</a></li>
				</ul>
				<a href="#" class="link">Link here</a>
				<a href="#" class="link">Link here</a>-->';
		$this->setting['rightcolumn'] = '
				<!--<strong class="h">INFO</strong>
				<div class="box"></div>-->
				';
		$this->setting['search'] = '<!--<label>
				<input type="text" name="textfield" />
				</label>
				<label>
				<input type="submit" name="Submit" value="Search" />
				</label>  
				-->';
		$this->setting['breadcrumbs'] = '<!--<div class="breadcrumbs"><a href="#">Homepage</a> / <a href="#">Contents</a></div>-->';
		$this->setting['links'] = '<!--<a href="#" class="button">ADD NEW </a>-->';
		$this->setting['navigation'] = $this->navigation();
		$this->path = '/';
		
	}
		
	function admin_home(){
		$this->setting['section'] = "Admin";
		//$this->setting['dr'] = "dr.default.php";
		$this->setting['form'] = "";
		//$this->setting['formaction'] = "";
		return $this->setting;
	}
	###
	# RSC
	###
	function RSC(){
		if(!in_array('RSC',$this->useraccess)){
			return $this->admin_home();
		}
		$this->setting['section'] = "RSC LOAD";
		$this->setting['form'] = $this->get_include_contents($this->path . "/RSC/index.php");
		$this->setting['dr'] = "../RSC/imported.php";
		return $this->setting;
	}
	
	###
	# Application
	###
	function get_include_contents($filename){
		if (is_file($filename)){
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}
	
	function navigation(){
		$nav = '<li><span><span><a href="?">ADMIN</a></span></span></li>';
		if(in_array('RSC',$this->useraccess)){
			$nav .= '<li><span><span><a href="?action=RSC">RSC LOAD</a></span></span></li>';
		}
		return $nav;
	}
	
	function access($user){
		switch ($user) {
			case 'admin':
				$group = array('RSC','advantage','newsletter','contacts','phone','validate','guides','distribution', 'bulkorder', 'bulklist','musicpei','dataloader','campaign','parks');
				break;
			case 'RSC':
				$group = array('RSC','dataloader');
				break;
			default:
				$group = array();
		}
		return $group;
	}
}