<?php

	/*		
	**		GMG Heavenbet Podcast Script
	**		Created By Alex
	**		V1.0
	**		28/02/2013
	*/
	
	require_once('../library/vars.php');
	
	// Permanent redirection
	header("HTTP/1.1 301 Moved Permanently");
	
	$redirect = $config_array['serverAddress'].$config_array['podcastFeedAddress'].'?podcastname=Best_Of_The_Bets_Show';
	
	header('Location: '.$redirect ) ;
		
	exit();
	
?>