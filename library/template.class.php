<?php 

					

class templatebuilder {

	private $defaultheader; 
	private $defaultcontent;
	private $defaultfooter;
	private $requiretem;

	public function __construct($reqbuild = 'yesBuild'){
		
		if($reqbuild == 'noBuild') $reqbuild == false;
		
	}
	
	public function template_header($defaultheader){
	
		$this->defaultheader = $defaultheader;
	}
	
	public function template_template($defaultcontent){
	
		$this->defaultcontent = $defaultcontent.'_template.php';

	}
	
	public function template_footer($defaultfooter){
	
		$this->defaultfooter = $defaultfooter;
	}
	
	private function template_check(){
	
		if(file_exists($this->defaultheader) && file_exists($this->defaultcontent) &&  file_exists($this->defaultfooter)) return true;
		
		else{
			header("HTTP/1.0 404 Not Found");
			die("Sorry Bad Request");
		}	
		
	}
	
	public function template_build(){
	
		header("HTTP/1.0 200 OK");
		
		global $config_array;
		global $config_cms_setup;
		global $sessioninit;
		global $config_items;
		
		$this->template_check();
		
		ob_start();
		require_once($this->defaultheader);
		require_once($this->defaultcontent);
		require_once($this->defaultfooter);
		ob_flush();
	
	}
	
	public function route_template($template_name){
	
		global $config_array;
		
	
	}


}



?>