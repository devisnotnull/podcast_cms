<?php 

	/*****

		GMG PODCAST MANAGEMENT
		vesrsion V1
		Requires PDO DB Class
		ALTERED FOR GMG PODCAST CMS
		Index Page

	*****/

	// Location Of Core File
	
	date_default_timezone_set('Europe/London');
	
	function tmp_csv_output($podcast_name){
	
		$the_week = date("W");
		$timestamp =  date('Y-m-d H:i:s');
		$list = array($_SERVER);
		array_push($list, $podcast_name);
		$fp = fopen('/home/nginx-html/logs/podcast-xml-download.log', 'a');

		foreach ($list as $fields) {
			fputcsv($fp, $fields);
		}
		fclose($fp);
	}
	
	// APC INTERGRATION
	if (apc_fetch($_GET['podcastname'])):
	
		print $domobj = apc_fetch($_GET['podcastname']);
		
	else:
	
		require(dirname( dirname( dirname(__FILE__) ) ).'/library/database.class.php');
		require(dirname( dirname( dirname(__FILE__) ) ).'/library/session.class.php');
		require(dirname( dirname( dirname(__FILE__) ) ).'/library/vars.php');
		
		$sessioninit = session::__getInstance();
		$db_connect = database_instance::__getInstance();
		
		$clean_exec = &$db_connect::pdoDirect();
		$prep = $clean_exec->prepare('SELECT * FROM podcast_config WHERE podcast_podcast_loc = :podcastloc' , array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$prep->execute(array(':podcastloc' => $_GET['podcastname']));

		
		if($prep->rowCount() === 1):
		
			tmp_csv_output($_GET['podcastname']);
		
			$podcast_description = $prep->fetchAll();
			$podcast_description = $podcast_description[0];
			
			$podcast_id = $podcast_description['podcast_config_id'];
			
			$clean_exec = &$db_connect::pdoDirect();
			$prep = $clean_exec->prepare('SELECT * FROM podcast_shows WHERE podcast_config_id = :configid' , array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$prep->execute(array(':configid' => $podcast_id));
			$podcast_items = $prep->fetchAll();

				// Set header to XML
				header("Content-type: text/xml;");
				
				// This Prototype will use the PHP DomDocument To Assemble to podcast RSS feed
				$dom = new DomDocument('1.0', 'utf-8');
				
				// Declare As RSS Document
				$allgames = $dom->createElement('rss');
				$allgames->setAttribute('version', '2.0');
				// Set the rss
				$allgames->setAttribute('xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd');
				$allgames->setAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom' );

				$channel = $dom->createElement('channel');
			
				$channel_title = 					$dom->createElement('title', $podcast_description['podcast_title']);
				$channel_link = 					$dom->createElement('link', $podcast_description['podcast_link']);
				$channel_lang = 					$dom->createElement('language',$podcast_description['podcast_language']);
				$channel_copyright = 				$dom->createElement('copyright',$podcast_description['podcast_owner_name']);
				$channel_itunes_author = 			$dom->createElement('itunes:author',$podcast_description['podcast_owner_name']);
				$channel_itunes_subtitle = 			$dom->createElement('itunes:subtitle',$podcast_description['podcast_subtitle']);
				$channel_itunes_author =			$dom->createElement('itunes:author',$podcast_description['podcast_owner_name']);
				$channel_itunes_summary =			$dom->createElement('itunes:summary',$podcast_description['podcast_summary']);
				$channel_description =				$dom->createElement('description',$podcast_description['podcast_description']);
				$channel_itunes_owner	 = 			$dom->createElement('itunes:owner');
				
					$channel_itunes_name = $dom->createElement('itunes:name', $podcast_description['podcast_owner_name']);
					$channel_itunes_email = $dom->createElement('itunes:email',$podcast_description['podcast_owner_email']);
					//	Sub Of Owner
					$channel_itunes_owner->appendChild($channel_itunes_name);
					$channel_itunes_owner->appendChild($channel_itunes_email);
					//	Append To Owner
					
				$channel_itunes_image = $dom->createElement('itunes:image');
					$channel_itunes_image->setAttribute('href', $config_array['serverAddress'].'podcast-img-flags/'.$podcast_description['podcast_config_id'].'/'.$podcast_description['podcast_image']);
				//	Podcast Image
				
				$channel_itunes_category	= 	$dom->createElement('itunes:category');
					$channel_itunes_category->setAttribute('text', $podcast_description['podcast_categories']);
				//	Podcast Categorys
				$channel_itunes_keywords	=	$dom->createElement('itunes:keywords', $podcast_description['podcast_keywords']);
				//	Podcast Keywords
				
				$channel->appendChild($channel_title);
				$channel->appendChild($channel_link);
				$channel->appendChild($channel_lang);
				$channel->appendChild($channel_copyright);
				$channel->appendChild($channel_itunes_author);
				$channel->appendChild($channel_itunes_subtitle);
				$channel->appendChild($channel_itunes_summary);
				$channel->appendChild($channel_description);
				$channel->appendChild($channel_itunes_owner);
				$channel->appendChild($channel_itunes_image);
				
				$channel->appendChild($channel_itunes_category);
				$channel->appendChild($channel_itunes_keywords);
				
				$allgames->appendChild($channel);

				foreach($podcast_items as $podcast_item):	
			
					$item = $dom->createElement('item');	
						
						$item_title				=			$dom->createElement('title', $podcast_item['podcast_title']);
						$item_itunes_author		=			$dom->createElement('itunes:author', $podcast_description['podcast_owner_name']);
						$item_description		=			$dom->createElement('description',"<![CDATA[ {$podcast_item['podcast_title']} ]]>");
						$item_subtitle			=			$dom->createElement('itunes:subtitle', $podcast_item['podcast_description']);
						$item_summary			=			$dom->createElement('itunes:summary', $podcast_item['podcast_description']);
						
							$item_enclosure			=			$dom->createElement('enclosure');
							$item_enclosure->setAttribute('url', $config_array['serverAddress'].'podcasts/'.$podcast_item['podcast_link']);
							
							if($podcast_item['podcast_type'] ==  'standard-audio'):
								$item_enclosure->setAttribute('type','audio/mp3');
							endif;
							
							if($podcast_item['podcast_type'] ==  'standard-video'):
								$item_enclosure->setAttribute('type','video/mp4');
							endif;
							
							$item_enclosure->setAttribute('length', $podcast_item['podcast_length']);
						
						$item_link				=			$dom->createElement('link',		$podcast_description['podcast_link']);
						$item_guid				=			$dom->createElement('guid', 	$config_array['serverAddress'].'podcasts/'.$podcast_item['podcast_link']);
						$item_pubdate			=			$dom->createElement('pubDate',	$podcast_item['podcast_publish_date']);
						$item_category			=			$dom->createElement('category',	$podcast_item['podcast_category']);
						$item_duration			=			$dom->createElement('itunes:duration', $podcast_item['podcast_tidy_length']);
						$item_keywords			=			$dom->createElement('itunes:keywords',	$podcast_item['podcast_tags']);
						
					$item->appendChild($item_title);
					$item->appendChild($item_itunes_author);
					$item->appendChild($item_description);
					$item->appendChild($item_subtitle);
					$item->appendChild($item_summary);
					$item->appendChild($item_enclosure);
					$item->appendChild($item_link);	
					$item->appendChild($item_guid);	
					$item->appendChild($item_pubdate);	
					$item->appendChild($item_category);	
					$item->appendChild($item_duration);			
			
					$channel->appendChild($item);
					
				endforeach;	
				
			$dom->appendChild($allgames);
			// ADD TO APC STACK
			apc_add($podcast_description['podcast_title'], $dom, 120);
			
			print $dom->saveXML();
			
		else:
			die("Podcast Not Found");
		endif;
	
	endif;
?>