<?php

	require_once(dirname( dirname( dirname(__FILE__) )).'/library/addpodcast.php');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'):
		
		if(isset($_POST['podcast_new_publish']) && isset($_POST['podcast_new_url']) && isset($_POST['podcast_new_url_hash'])):

			$podcast_title = (isset($_POST['podcast_new_title']) || strlen($_POST['podcast_new_title']) < 6 ) ? $_POST['podcast_new_title'] : false;
			
			$addPodcast = new addPodcast($podcast_title, $_POST['podcast_new_publish'], $_POST['podcast_new_url'], $_POST['podcast_new_url_hash']);
		
		else:
		
			header("HTTP/1.1 403 Malformed Post Request");
			die();
		
		endif;
		

	else:
	
		header("HTTP/1.1 403 NO A POST REQUEST");
		die();
	
	endif;
	
	?>