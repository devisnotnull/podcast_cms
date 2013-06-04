<?php

	require_once(dirname( dirname( dirname(__FILE__) )).'/library/config.php');
	require_once(dirname( dirname( dirname(__FILE__) )).'/library/imageResize.class.php');
	
	if(isset($_GET['podcast_id'])):

		if(isset($_GET['percent_width'])):
			
			$flagResize = new flagResize((int) $_GET['podcast_id']);
			$flagResize->setOldMesure();
			$flagResize->setNewPercent((int) $_GET['percent_width']);
			$flagResize->displayNewImage();
			die();
		else:
		
			$flagResize = new flagResize($_GET['podcast_id']);
			$flagResize->setOldMesure();
			$flagResize->setNewPercent(50);
			$flagResize->displayNewImage();
			die();
			
		endif;
		
	else: 
	
		$goto = $config_array['serverAddress'].$config_array['imageAddress'].'error-404.png';
		header("Location: {$goto}");
		die();
	
	endif;
	
?>