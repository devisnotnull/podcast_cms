<?php

	require_once(dirname( dirname( dirname(__FILE__) )).'/library/configAlter.php');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'):
		
		$updatePodcastArray['podcast_update_related_link'] 	= 	(isset($_POST['podcast_update_related_link']) 	? $_POST['podcast_update_related_link'] 	: false );
		$updatePodcastArray['podcast_update_summary']		= 	(isset($_POST['podcast_update_subtitle']) 		? $_POST['podcast_update_subtitle'] 			: false );
		$updatePodcastArray['podcast_update_owner_name'] 	= 	(isset($_POST['podcast_update_owner_name'])		? $_POST['podcast_update_owner_name'] 		: false );
		$updatePodcastArray['podcast_update_owner_email'] 	= 	(isset($_POST['podcast_update_owner_email']) 	? $_POST['podcast_update_owner_email'] 		: false );
		$updatePodcastArray['podcast_update_image'] 		= 	(isset($_POST['podcast_update_image']) 			? $_POST['podcast_update_image'] 			: false );
		$updatePodcastArray['podcast_update_image_hash'] 		= 	(isset($_POST['podcast_update_image_hash']) 	? $_POST['podcast_update_image_hash'] 		: false );
		$updatePodcastArray['podcast_update_keywords'] 		= 	(isset($_POST['podcast_update_keywords']) 		? $_POST['podcast_update_keywords'] 		: false );
	
		$createNewPodcast = new createPodcast($updatePodcastArray);

	else:
		header("HTTP/1.1 403 NO A POST REQUEST");
		die();
	endif;
	
?>