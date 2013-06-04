<?php

	// ALL INCLUDES RELATIVE TO THE CORE FILE	
	require_once('vars.php');
	require_once('database.class.php');
	require_once('session.class.php');
	require_once('template.class.php');
	require_once('router.class.php');
	require_once('imageResize.class.php');
	
	// SET UK TIME ZONE
	date_default_timezone_set('GMT');
	
	// START THE SESSION
	$sessioninit = session::__getInstance();
	$db_connect = database_instance::__getInstance();
	
	if($sessioninit::ses_check_login() || isset($_POST['allowImageMain'])){
	
	
		// GET THE HIGHEST NUMBERED EPISODE
		$db_connect = database_instance::__getInstance();
		$podcast_number = $db_connect->query("SELECT MAX(podcast_id) FROM podcast_shows WHERE podcast_config_id = (SELECT user_account_assoc FROM podcast_users WHERE user_name = '{$sessioninit::ses_get_username()}')");
		$podcast_number = $podcast_number[0]['MAX(podcast_id)'];
	
		// GET THE CURRENT ITEMS CONFIG INFORMATION
		$db_connect = database_instance::__getInstance();
		$config_items = $db_connect->query("SELECT * FROM podcast_config WHERE podcast_config_id = (SELECT user_account_assoc FROM podcast_users WHERE user_name = '{$sessioninit::ses_get_username()}')");
		// COUNT FOR NEXT EPISODE
		$config_cms_setup = $config_items[0];
		$config_cms_setup['podcast_config_next_number'] = $podcast_number + 1;
		
		// SETUP IMAGES FOR THE PODCAST
		$config_cms_setup['podcast_image_def'] =  $config_cms_setup['podcast_image'];
		$config_cms_setup['podcast_image'] 		= $config_array['serverAddress'].$config_array['imageAddress'].$config_cms_setup['podcast_config_id'].FS.$config_cms_setup['podcast_image'];
		$config_cms_setup['podcast_internal_image_loc']  = $config_array['document_root'].$config_array['default_image_loc'].$config_cms_setup['podcast_config_id'].$config_cms_setup['podcast_image_def'];
	
	}
?>