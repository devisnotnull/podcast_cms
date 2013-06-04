<?php 
	
	/***** Template Builder ***/
	
	
	if($sessioninit::ses_check_login()){
		if($_SERVER['REQUEST_URI'] == '/ajax/updatepodcast') $template_create = new templatebuilder('noBuild');
		else $template_create = new templatebuilder();
		$template_create->template_header($config_array['document_root'].$config_array['default_header_loc']);
		$template_create->template_template($config_array['document_root'].$config_array['default_template_loc'].$_SERVER['REQUEST_URI']);
		$template_create->template_footer($config_array['document_root'].$config_array['default_footer_loc']);
		$template_create->template_build();
	}
	else{
		$template_create = new templatebuilder();	
		$template_create->template_header($config_array['document_root'].$config_array['default_header_loc']);
		$template_create->template_template($config_array['document_root'].$config_array['default_template_loc'].'/login');
		$template_create->template_footer($config_array['document_root'].$config_array['default_footer_loc']);
		$template_create->template_build();
	}

?>