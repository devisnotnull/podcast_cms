<?php 

	require_once('config.php');
	
	class createPodcast{
	
		private $new_podcast_user;
		private $new_podcast_password;
		private $new_podcast_name;
		private $new_podcast_link;
		private $new_podcast_type;
		private $new_podcast_language;
		private $new_podcast_subtitle;
		private $new_podcast_owner;
		private $new_podcast_email;
		private $new_podcast_image;
		private $new_podcast_keywors;
		private $new_podcast_categories;
		private $db_asset;
		private $session_asset;
		private $hash_temp;
		private $image_height_main;
		private $image_width_main;
		private $image_file_extension;
		private $make_dir;
		private $move_to_dir;
	 
	 
		/*
		* 	@function 			uploadErrorEncode 
		* 	@description 		Json Encode An output
		* 	@params 			$error
		* 	@return 			return Json Encoded Error
		*/
	 	private function uploadErrorEncode($error){
		
			(array) $ret = array('errors' => array($error));
			return json_encode($ret);
			
		}
		
		/*
		* 	@function 			__construct 
		* 	@description 		Take In all info for new podcast via array
		* 	@params 			
		* 	@return 			return bool;
		*/
		public function __construct($podcastNew){
			
			global $sessioninit, $db_connect, $config_array;
			
			
			if(!$sessioninit::ses_auth_delete()){
				$this->__destruct();
			}
	
			if(isset($podcastNew['podcast_new_user_name'],$podcastNew['podcast_new_password'],$podcastNew['podcast_new_name'],$podcastNew['podcast_new_related_link'],$podcastNew['podcast_new_media_type'],
					$podcastNew['podcast_new_language'],$podcastNew['podcast_new_subtitle'],$podcastNew['podcast_new_owner_name'],
					$podcastNew['podcast_new_owner_email'],$podcastNew['podcast_new_image'],$podcastNew['podcast_new_image_hash'],$podcastNew['podcast_new_keywords'],$podcastNew['podcast_new_categories'])):
					
					$this->new_podcast_user = $this->sanitizeInput($podcastNew['podcast_new_user_name']);
					$this->new_podcast_password = $this->sanitizeInput($podcastNew['podcast_new_password']);
					$this->new_podcast_name = $this->sanitizeInput($podcastNew['podcast_new_name']);
					$this->new_podcast_link = $this->sanitizeInput($podcastNew['podcast_new_related_link']);
					$this->new_podcast_type = $this->sanitizeInput($podcastNew['podcast_new_media_type']);
					$this->new_podcast_language = $this->sanitizeInput($podcastNew['podcast_new_language']);
					$this->new_podcast_subtitle = $this->sanitizeInput($podcastNew['podcast_new_subtitle']);
					$this->new_podcast_owner = $this->sanitizeInput($podcastNew['podcast_new_owner_name']);
					$this->new_podcast_email = $this->sanitizeInput($podcastNew['podcast_new_owner_email']);
					$this->new_podcast_image = $this->sanitizeInput($podcastNew['podcast_new_image']);
					$this->new_podcast_image_hash = $this->sanitizeInput($podcastNew['podcast_new_image_hash']);
					$this->new_podcast_keywords = $this->sanitizeInput($podcastNew['podcast_new_keywords']);
					$this->new_podcast_categories = $this->sanitizeInput($podcastNew['podcast_new_categories']);

			else:
				header("HTTP/1.1 403 Invalid Upload Data");
				echo $this->uploadErrorEncode('Either Invalid Data Was Uploaded Or Server Was Unable To Sanitise Inputs and Killed Process. Are You Sending Naughty Data !"');
				die();
				
			endif;
			
		
			
			// Check Username Exists
			if(!$this->checkUserName($this->new_podcast_user) || strlen($this->new_podcast_user) < 7):
				header("HTTP/1.1 400 Duplicate Usernamwe");
				echo $this->uploadErrorEncode('Duplicate Username');
				die();
			endif;
			
			// Check the Password Is Correct
			if(!$this->passRegex($this->new_podcast_password)):
				header("HTTP/1.1 400 Bad File Extension");
				echo $this->uploadErrorEncode('Your Password Is Not Complex Enough');
				die();
			endif;
			
			// Validate That The URL Is valid 
			if(!$this->validateURL($this->new_podcast_link)):
				header("HTTP/1.1 400 The URL is Not Valid");
				echo $this->uploadErrorEncode('Either The links you have provided is dead or not avaliable to the general public');
				die();
			endif;
			
			//	Validate podcast subtitle
			if(!(strlen($this->new_podcast_subtitle) > 20)):
				header("HTTP/1.1 400 Provided Subtitle is bad");
				echo $this->uploadErrorEncode('The subtitle is not long enough - Minimum 20 Words');
				die();
			endif;
			
			//	validate podcast owners name 
			if(!(strlen($this->new_podcast_owner) > 5)):
				header("HTTP/1.1 400 Provided Subtitle is bad");
				echo $this->uploadErrorEncode('Your Name Is To Short - Minimum 5 words');
				die();
			endif;
			
			// Regex the email adresss to make sure its correct
			if(!($this->emailRegex($this->new_podcast_email))):
				header("HTTP/1.1 400 Invalid Email");
				echo $this->uploadErrorEncode('That Is Not a valid email address');
				die();
			endif;
			
			// Regex the email adresss to make sure its correct
			if(!($this->checkImage($this->new_podcast_image,$this->new_podcast_image_hash))):
				header("HTTP/1.1 400 Image Processing Error");
				echo $this->uploadErrorEncode('Unable To Process Image');
				die();
			endif;
			
			// Regex the email adresss to make sure its correct
			if(!strlen($this->new_podcast_keywords) > 5):
				header("HTTP/1.1 400 Keywords To Long");
				echo $this->uploadErrorEncode('Keywords not long enough');
				die();
			endif;
			
			// Regex the email adresss to make sure its correct
			if(($this->checkCategory($this->new_podcast_categories))):
				header("HTTP/1.1 400 Invalid Category");
				echo $this->uploadErrorEncode('Invalid Category');
				die();
			endif;
			
			// Get Number For The Next Podcast 
			$index_num_asset = $db_connect->query('SELECT MAX(podcast_config_id) FROM podcast_config');
			$index_num_asset = $index_num_asset[0]['MAX(podcast_config_id)'];
			$index_num_asset = $index_num_asset + 1;
			// Work Out Where We Are Going To Save all of the users files
			$this->make_dir = $config_array['document_root'].$config_array['default_image_loc'].$index_num_asset.'/';
			$image_insert_name = $index_num_asset.'_'.$this->image_width_main.'_'.$this->image_height_main.'.'.$this->image_file_extension;
			$this->hash_temp;
			$this->move_to_dir =  $this->make_dir .'/'.$index_num_asset.'_'.$this->image_width_main.'_'.$this->image_height_main.'.'.$this->image_file_extension;
			// Make the name that will be used for the external podcast call
			$ident_url = str_replace(' ', '_', $this->new_podcast_name);
			// DATABASE ACESSSSSSSSSSSSSSSSSSSSSSS _ INSERT MORE PYLONS
			$connectionDbAsset = $db_connect->pdoDirect();
			// Prepare The SQL QUERY WITH PDO 
			$category_asset = $connectionDbAsset->prepare("INSERT INTO podcast_config 
															(`podcast_config_id`,
															`podcast_title`, 
															`podcast_link`, 
															`podcast_language`,
															`podcast_subtitle`, 
															`podcast_summary`, 
															`podcast_description`,
															`podcast_owner_name`, 
															`podcast_owner_email`, 
															`podcast_image`, 
															`podcast_keywords`, 
															`podcast_categories`, 
															`podcast_podcast_loc`,
															`podcast_type`) 
														VALUES ( :index_num_asset,
															:new_podcast_name, 
															:new_podcast_link,
															:new_podcast_language, 
															:new_podcast_subtitle, 
															:new_podcast_summary, 
															:new_podcast_description, 
															:new_podcast_owner, 
															:new_podcast_email, 
															:image_insert_name, 
															:new_podcast_keywords, 
															:new_podcast_categories, 
															:ident_url, 
															:new_podcast_type);");
			// Execute the pdo prepared statement !												
			$category_asset->execute( array(':index_num_asset' => $index_num_asset,
											':new_podcast_name' => $this->new_podcast_name, 
											':new_podcast_link' => $this->new_podcast_link,
											':new_podcast_language' => $this->new_podcast_language, 
											':new_podcast_subtitle' => $this->new_podcast_subtitle,
											':new_podcast_summary' => $this->new_podcast_subtitle,
											':new_podcast_description' => $this->new_podcast_subtitle,
											':new_podcast_owner' => $this->new_podcast_owner, 
											':new_podcast_email' => $this->new_podcast_email, 
											':image_insert_name' => $image_insert_name, 
											':new_podcast_keywords' => $this->new_podcast_keywords, 
											':new_podcast_categories' => $this->new_podcast_categories, 
											':ident_url' => $ident_url, 
											':new_podcast_type' => $this->new_podcast_type));
			
	
			
			// If One row was affected meaning that an insert has occured											
			if($category_asset->rowCount() == 1):
				// Now That The New Podcast Item Has Been Insereted We Add the user, crypt the pass word with the session function
				if($db_connect->execRowCount("INSERT INTO `botb_podcast`.`podcast_users` (`user_name`, `user_hash`, `user_account_assoc`, `user_access_level`) VALUES ('{$this->new_podcast_user}', '{$sessioninit::ses_crypto($this->new_podcast_password)}', '{$index_num_asset}', 'root');") != 1):
					// If this does not occure then we die And Delete From the db
					header("HTTP/1.1 400 Unable To Make User");
					$db_connect->execRowCount("DELETE FROM podcast_config WHERE podcast_config_id = '{$index_num_asset}'");
					echo $this->uploadErrorEncode('Unable To Make User"');
					die();
				endif;
				// Make the directory that the podcast assets will sit - chmod 755 so public can access it 
				if(mkdir($this->make_dir , 0777, true)):
					// Copy the hash encoded Image from the temp directory to the newly created one
					if (!copy($this->hash_temp, $this->move_to_dir)):
						header("HTTP/1.1 403 Unable To Move Tmp File");
						$db_connect->execRowCount("DELETE FROM podcast_users WHERE user_name = '{$this->new_podcast_user}'");
						$db_connect->execRowCount("DELETE FROM podcast_config WHERE podcast_config_id = '{$index_num_asset}'");
						rmdir($this->make_dir);
						echo $this->uploadErrorEncode('Unable To Move TMP File To Permanant Location');
						die();
					else:
						// If copy is good then we remove the temp from the file system.
						unlink($this->hash_temp);
					endif;
				else:	
					// IF the copy was good then cleanup all previous actions
					header("HTTP/1.1 400 Failed To Make Podcast DIR");					
					unlink($this->hash_temp);
					rmdir($this->make_dir);
					$db_connect->execRowCount("DELETE FROM podcast_users WHERE user_name = '{$this->new_podcast_user}'");
					$db_connect->execRowCount("DELETE FROM podcast_config WHERE podcast_config_id = '{$index_num_asset}'");
					echo $this->uploadErrorEncode('That Directory Already Exists , Cleanup complete!');
					die();
				endif;
			
			else:
				header("HTTP/1.1 400 Unable To Setup podcast");
				echo $this->uploadErrorEncode('Unable to setup podcast !');
				die();
			endif;

		}
	 
		/*
		* 	@function 			cleanInput 
		* 	@description 		Remove malitious HTML and JS tags
		* 	@params 			$input
		* 	@return 			return $output;
		*/
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
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function sanitizeInput($input){
			
			if (is_array($input)):
			
				foreach($input as $var=>$val):
					$output[$var] = sanitize($val);
				endforeach;
			
			else:
			
				if (get_magic_quotes_gpc()) { $input = stripslashes($input); }
				$output  = $this->cleanInput($input);
				$output = trim($output);
			endif;
			
			return $output;

		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function checkImage($imageName, $imageHash){
		
			global $config_cms_setup;
			global $config_array;
		
			if(md5($imageName) != $imageHash) return false;
		
			$fileType =  substr(strrchr($imageName,'.'),1);
			if($fileType != ('png') || $fileType != ('jpg') || $fileType != ('jpeg'))
			$this->hash_temp = $config_array['document_root'] . $config_array['default_tmp_loc'] . $imageHash.'.'.$fileType;
			
			if(file_exists($this->hash_temp)):
			
				list($width, $height, $type, $attr) = getimagesize($this->hash_temp);
				
				if($width < 2000 && $height < 2000 && $width > 500 && $height > 500  && ($height % 10) == 0 && ($width % 10) == 0):
				
					$this->image_width_main = $width;
					$this->image_height_main = $height;
					$this->image_file_extension = $fileType;
					return true;
					
				endif;
				
			endif;
			
			return false;
			
		
		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function passRegex($pass){
		
			return preg_match("/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$_%]).{8,30}$/", $pass);
			//return preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $pass);

		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function emailRegex($email){
		
			return (filter_var($email, FILTER_VALIDATE_EMAIL));
				
		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function checkCategory($cat){
		
			global $sessioninit, $db_connect;
			$category_asset = ($db_connect->rowCount("SELECT category_name FROM podcast_category_options WHERE category_name = '{$cat}';") === 1 ) ? false : true;
			return $category_asset;
		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function checkUserName($name){
		
			global $sessioninit, $db_connect;
			$user_name_asset = ($db_connect->rowCount("SELECT user_name FROM botb_podcast.podcast_users WHERE user_name = '{$name}'") === 1 ) ? false : true;
			return $user_name_asset;
		}
		
		
		/*
		* 	@function 			sanitizeInput 
		* 	@description 		Apply $this->cleanInput() plus apply SQL sanitation 
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function validateURL($url, $timeout = 10){
			
			$ch = curl_init(); // Start Curl and place in container VAR
			$opts = array(CURLOPT_RETURNTRANSFER => true, // We dont want output just header infomation
			CURLOPT_URL => $url,				// Set The URL
			CURLOPT_NOBODY => true,			 	// do a HEAD request only
			CURLOPT_TIMEOUT => $timeout);  		// set timeout
			curl_setopt_array($ch, $opts); 
			curl_exec($ch); 					// Execute CURL 
			$http_responce = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch); 					// Get RID OF THE CURRRLLLL, THROW IT DOWN THE WELLLLL
			
			$valid_url = array(200,300,301,302,303,304,305,306,307);
			
			foreach($valid_url as $url):
			
				if($url === $http_responce) return true;
			
			endforeach;
			
			return false;
			
		}
	 
	}


?>