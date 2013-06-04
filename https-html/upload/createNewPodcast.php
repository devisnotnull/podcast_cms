<?php

	require_once(dirname( dirname( dirname(__FILE__) )).'/library/createPodcast.php');
	
	

	if($_SERVER['REQUEST_METHOD'] == 'POST'):
		
		if(isset($_POST['podcast_new_user_name'],$_POST['podcast_new_password'],$_POST['podcast_new_name'],$_POST['podcast_new_related_link'],$_POST['podcast_new_media_type'],
					$_POST['podcast_new_language'],$_POST['podcast_new_subtitle'],$_POST['podcast_new_owner_name'],
					$_POST['podcast_new_owner_email'],$_POST['podcast_new_image'],$_POST['podcast_new_image_hash'],$_POST['podcast_new_keywords'],$_POST['podcast_new_categories'])):

					$newPodcastArray = array('podcast_new_user_name' => $_POST['podcast_new_user_name'],'podcast_new_password'	=>	$_POST['podcast_new_password'],
					'podcast_new_name'			=>	$_POST['podcast_new_name'],			'podcast_new_related_link'	=>	$_POST['podcast_new_related_link'],
					'podcast_new_media_type'	=> 	$_POST['podcast_new_media_type'], 	'podcast_new_language'		=> $_POST['podcast_new_language'],
					'podcast_new_subtitle'		=>	$_POST['podcast_new_subtitle'],		'podcast_new_owner_name'	=>	$_POST['podcast_new_owner_name'],
					'podcast_new_owner_email'	=>	$_POST['podcast_new_owner_email'],	'podcast_new_image'			=>	$_POST['podcast_new_image'],
					'podcast_new_image_hash'			=>	$_POST['podcast_new_image_hash'],
					'podcast_new_keywords'		=>	$_POST['podcast_new_keywords'],		'podcast_new_categories'	=>	$_POST['podcast_new_categories']);
			
					$createNewPodcast = new createPodcast($newPodcastArray);
		
		else:
		
			header("HTTP/1.1 403 Malformed Post Request");
			die();
		
		endif;
		

	else:
	
		header("HTTP/1.1 403 NO A POST REQUEST");
		die();
	
	endif;
	
	?>