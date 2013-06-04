<?php 

					

class router {


	public function __construct(){
	
		if($this->check_logged());
		else{  }
	
	}
	
	public function check_logged(){
	
		if($sessioninit::ses_check_login()) return true;
		else return false;
		
	}
	
	public function check_route_exists(){
	
	}
	
	public function route_template($template_name){
	
		global $config_array;
		
		
	
	}


}



?>