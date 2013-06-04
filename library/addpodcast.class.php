<?php
	class addPodcast{
	
		private $errors;
		
		private $podcast_publish;
		private $podcast_url;
		private $podcast_hash;
		
		private $hash_temp_loc;
		private $podcast_perm_name;
		private $podcast_perm_date;
		
	
		private function uploadErrorEncode($error){
		
			(array) $ret = array('errors' => array($error));
			return json_encode($ret);
			
		}
	
		public function __construct($podcast_new_title, $podcast_publish, $podcast_url, $podcast_hash){
			
			global $config_cms_setup;
			global $config_array;
			global $config_items;
			global $sessioninit;
		
			if(!$sessioninit::ses_auth_delete()){
				$this->__destruct();
			}
		
			$this->fileType =  substr(strrchr($podcast_url,'.'),1);
			
			$this->podcast_hash = $podcast_hash;
			$this->podcast_url = $podcast_url;
					
			if($this->podcast_hash != md5($this->podcast_url)):
				header("HTTP/1.1 403 Hashes Do Not Match");
				echo $this->uploadErrorEncode('ERROR');
				die();
			endif;

			$this->podcast_perm_date = date('Y-m-d', strtotime($podcast_publish));
			
			if($this->podcast_perm_date != $podcast_publish):
			
			endif;
			
			// Aquire Default Show Name
			$this->podcast_perm_name = (strlen($podcast_new_title) > 6) ? $config_cms_setup['podcast_title']. ' - ' . $podcast_new_title . '- (' . date('d-m-Y', strtotime($this->podcast_perm_date)) . ')' : $config_cms_setup['podcast_title'] . ' - (' . date('d-m-Y', strtotime($this->podcast_perm_date)) .')' ;
			$this->podcast_perm_name = $this->sanitizeInput($this->podcast_perm_name);
		
			// Get Root Of File.
			$this->hash_temp_loc = $config_array['document_root'] . $config_array['default_tmp_loc'] . $_POST['podcast_new_url_hash'].'.'.$this->fileType;
		
			$info = pathinfo($this->hash_temp_loc, PATHINFO_EXTENSION);

			if ($info == "mp3" && $config_items[0]['podcast_type'] == 'standard-audio'){ $this->addAudio(); }
			else if($info == "mp4" && $config_items[0]['podcast_type'] == 'standard-video') {	$this->addVideo(); }
			else{
				header("HTTP/1.1 400 Bad File Extension");
				echo $this->uploadErrorEncode('The Uploaded Item Does Not Match The Podcasts Media Type, Please Make Sure That You have Chossen and MP3 File If This Is An Audio Podcast Or An MP4 File For A Video Podcast');
				die();
			}
		}
		
		private function cleanInput($input) {

			$search = array(
				'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
				'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
				);

			$output = preg_replace($search, '', $input);
			
			return $output;
			
		}
		
		private function sanitizeInput($input){
		
			if (is_array($input)):
				foreach($input as $var=>$val):
					$output[$var] = sanitize($val);
				endforeach;
			else:
				if (get_magic_quotes_gpc()) { $input = stripslashes($input); }
				$output  = $this->cleanInput($input);
			
			endif;
			return $output;
		}
		
		public function addAudio(){
			// Import config assets
			global $config_cms_setup;
			global $sessioninit, $db_connect, $config_array;
			// Set File Extension
			$file_extension = '.mp3';
			if(file_exists($this->hash_temp_loc)):
				// Load In The getID3 Class
				$getID3 = new getID3;
				// Set Encoding To UTF-8
				$getID3->setOption(array('encoding'=> 'UTF-8'));
				// Set File Read Location
				$ThisFileInfo = $getID3->analyze($this->hash_temp_loc);
				// Set MP3 variables into a nice little array
				getid3_lib::CopyTagsToComments($ThisFileInfo);
				// Get The playtime of the MP3 From the ID3 class
				$mp3_file_playtime = gmdate("H:i:s", $ThisFileInfo['playtime_seconds']);        // playtime in minutes:seconds, formatted string
				$mp3_file_size = $ThisFileInfo['filesize'];
				// Initialize getID3 tag-writing module
				$tagwriter = new getid3_writetags;
				// Hash of file to be added
				$tagwriter->filename = $this->hash_temp_loc;
				// The ID3 Format Were going to use - For images you need ID3v2.3
				//$tagwriter->tagformats = array('id3v1', 'id3v2.3');
				$tagwriter->tagformats = array('id3v2.3');
				// set various options (optional)
				// These Options ARE BUGGY - I found out the hard way :p
				//$tagwriter->overwrite_tags = true;
				//$tagwriter->overwrite_tags = false;
				// Set tag specific encoding
				$tagwriter->tag_encoding = 'UTF-8';
				$tagwriter->remove_other_tags = true;
				// Setip the tag data array
				$TagData = array(
					'title'         => array($this->podcast_perm_name),
					'artist'        => array($config_cms_setup['podcast_owner_name']),
					'album'         => array($this->podcast_perm_name.' Podcast'),
					'year'          => array(date('Y', strtotime($this->podcast_perm_date) )),
					'genre'         => array($config_cms_setup['podcast_categories']),
					'comment'       => array($config_cms_setup['podcast_description']),
					'track'         => array('#'.$config_cms_setup['podcast_config_next_number'])
				);
				// Buffer in the binary data of the image file, the binary format is needed, the binary iformation is added to the MP£
				$handle = fopen($config_cms_setup['podcast_image'], "rb");
				$contents = stream_get_contents($handle);
				// Close PHP Stream
				fclose($handle);
				// Progress if stream is not not indicating binary data for image has been buffered
				if($contents):
					// Set API
					$APICdata = $contents;
					// Set the image width, height and mime type with php function GetImageSize
					list($APIC_width, $APIC_height, $APIC_imageTypeID) = GetImageSize($config_cms_setup['podcast_image']);
					//var_dump(GetImageSize($config_cms_setup['podcast_image']));
					// Compare images type to pre
					$imagetypes = array(1=>'gif', 2=>'jpeg', 3=>'png');
					// Bind image Binary Data To The MP3 File
					if (isset($imagetypes[$APIC_imageTypeID])):
						$TagData['attached_picture'][0]['data']          = $APICdata;
						$TagData['attached_picture'][0]['picturetypeid'] = 'Best Of The Bets';
						$TagData['attached_picture'][0]['description']   = 'Best Of The Bets Logo';
						$TagData['attached_picture'][0]['mime']          = 'image/'.$imagetypes[$APIC_imageTypeID];
					else:
						header("HTTP/1.1 400 Unable To Attach File");
						echo $this->uploadErrorEncode('Error Attaching Image To File');
						die();
					endif;
				else:	
					header("HTTP/1.1 400 No Image Specified");
					echo $this->uploadErrorEncode('Error No Image Specified To Attach To MP3 File');
					die();
					
				endif;
				$tagwriter->tag_data = $TagData;
				// Write Our Tags To The File
				if ($tagwriter->WriteTags()):
				else:
				
					header("HTTP/1.1 403 Unable To Find Bind Image");
					echo $this->uploadErrorEncode($tagwriter->errors);
					die();
					
				endif;
				// Get hash
				$hash_tmp = $this->hash_temp_loc;
				// Hash the file name again so that its name does not conflict with other files.
				$mp3_file_name = sha1(md5(rand().$hash_tmp)).$file_extension;
				$podcast_perm = $config_array['document_root'].$config_array['default_podcast_loc'].$mp3_file_name;
				// Copy The temp has to the new image Dir, if this fails then kill script
				if (!copy($hash_tmp, $podcast_perm)) {
					header("HTTP/1.1 403 Unable To Move Tmp File");
					echo $this->uploadErrorEncode('Unable To Move TMP File To Permanant Location');
					die();
				}
				// Unlike The Temporary File From The File System.
				unlink($hash_tmp);	
				// Add To Database
				$connectionDbAsset = $db_connect->pdoDirect();
				// Prepare The SQL QUERY WITH PDO 
				
				try{
				
					$category_asset = $connectionDbAsset->prepare("INSERT INTO `botb_podcast`.`podcast_shows` (`podcast_id`, 
																	`podcast_publish_date`, 
																	`podcast_title`,
																	`podcast_description`,
																	`podcast_asset_url`,
																	`podcast_link`, 
																	`podcast_length`, 
																	`podcast_tidy_length`, 
																	`podcast_category`, 
																	`podcast_tags`, 
																	`podcast_config_id`) 	
																	VALUES ( ?,?,?,?,?,?,?,?,?,?,? );");

					$category_asset->bindParam( 1 , $config_cms_setup['podcast_config_next_number']);
					$category_asset->bindParam( 2 , $this->podcast_perm_date );
					$category_asset->bindParam( 3 , $this->podcast_perm_name );
					$category_asset->bindParam( 4 , $config_cms_setup['podcast_description']);
					$category_asset->bindParam( 5 , $mp3_file_name );
					$category_asset->bindParam( 6 , $mp3_file_name );
					$category_asset->bindParam( 7 , $mp3_file_size );
					$category_asset->bindParam( 8 , $mp3_file_playtime );
					$category_asset->bindParam( 9 , $config_cms_setup['podcast_categories'] );
					$category_asset->bindParam( 10 , $config_cms_setup['podcast_keywords']);
					$category_asset->bindParam( 11 , $config_cms_setup['podcast_config_id']);			
					
					$category_asset->execute();
	
					} catch (Exception $e) {
						header("HTTP/1.1 500 PDO Parse Error !");
						echo "EXCEPTIONS";
						echo $e;
						return false;
					}
										
						if($category_asset->rowCount() != 1) {
							header("HTTP/1.1 403 Error Adding To Podcast Database");
							echo $this->uploadErrorEncode('Error Adding To Podcast Database');
							die();
						}
						else {
							header("HTTP/1.1 202 Added");
							die();
							die();
						}
			
			else:
				header("HTTP/1.1 403 Unable To Locate Upload File");
				echo $this->uploadErrorEncode('Unable To Locate Upload File');
				die();
			endif;

		}
		
		public function addVideo(){
			// Import config assets
			global $config_cms_setup;
			global $sessioninit, $db_connect, $config_array;
			// Set File Extension
			$file_extension = '.mp4';
			if(file_exists($this->hash_temp_loc)):
			
				// Get hash
				$hash_tmp = $this->hash_temp_loc;
				// Hash the file name again so that its name does not conflict with other files.
				$mp3_file_name = sha1(md5(rand().$hash_tmp)).$file_extension;
				$podcast_perm = $config_array['document_root'].$config_array['default_podcast_loc'].$mp3_file_name;
				// Copy The temp has to the new image Dir, if this fails then kill script
				if (!copy($hash_tmp, $podcast_perm)) {
					header("HTTP/1.1 403 Unable To Move Tmp File");
					echo $this->uploadErrorEncode('Unable To Move TMP File To Permanant Location');
					die();
				}
				// Unlike The Temporary File From The File System.
				unlink($hash_tmp);	
				// Add To Database
				$connectionDbAsset = $db_connect->pdoDirect();
				// Prepare The SQL QUERY WITH PDO 
				$mp3_file_size = 100;
				$mp3_file_playtime = 100;
				
				try{
				
					$category_asset = $connectionDbAsset->prepare("INSERT INTO `botb_podcast`.`podcast_shows` (`podcast_id`, 
																	`podcast_publish_date`, 
																	`podcast_title`,
																	`podcast_description`,
																	`podcast_asset_url`,
																	`podcast_link`, 
																	`podcast_length`, 
																	`podcast_tidy_length`, 
																	`podcast_category`, 
																	`podcast_tags`, 
																	`podcast_config_id`) 	
																	VALUES ( ?,?,?,?,?,?,?,?,?,?,? );");

					$category_asset->bindParam( 1 , $config_cms_setup['podcast_config_next_number']);
					$category_asset->bindParam( 2 , $this->podcast_perm_date );
					$category_asset->bindParam( 3 , $this->podcast_perm_name );
					$category_asset->bindParam( 4 , $config_cms_setup['podcast_description']);
					$category_asset->bindParam( 5 , $mp3_file_name );
					$category_asset->bindParam( 6 , $mp3_file_name );
					$category_asset->bindParam( 7 , $mp3_file_size );
					$category_asset->bindParam( 8 , $mp3_file_playtime );
					$category_asset->bindParam( 9 , $config_cms_setup['podcast_categories'] );
					$category_asset->bindParam( 10 , $config_cms_setup['podcast_keywords']);
					$category_asset->bindParam( 11 , $config_cms_setup['podcast_config_id']);			
					
					$category_asset->execute();
	
					} catch (Exception $e) {
						header("HTTP/1.1 500 PDO Parse Error !");
						echo "EXCEPTIONS";
						echo $e;
						return false;
					}
										
						if($category_asset->rowCount() != 1) {
							header("HTTP/1.1 403 Error Adding To Podcast Database");
							echo $this->uploadErrorEncode('Error Adding To Podcast Database');
							die();
						}
						else {
							header("HTTP/1.1 202 Added");
							die();
							die();
						}
			
			else:
				header("HTTP/1.1 403 Unable To Locate Upload File");
				echo $this->uploadErrorEncode('Unable To Locate Upload File');
				die();
			endif;
			
		}
		
		
		public function addBrightCoveVideo(){
		
			header("HTTP/1.1 403 Unable To Locate Upload File");
			echo $this->uploadErrorEncode('Method Not Yet Implemented - Depricated');
			die();
		
		}
	
	}