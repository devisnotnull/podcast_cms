<?php 

	require_once('config.php');
	
	class createPodcast{
	
		private $update_podcast_id;
		private $update_podcast_link;
		private $update_podcast_summary;
		private $update_owner_name;
		private $update_owner_email;
		private $update_image_hash;
		private $update_podcast_image;
		private $update_podcast_keywors;
		private $update_podcast_categories;
		private $db_asset;
		private $session_asset;
		private $hash_temp;
		private $image_height_main;
		private $image_width_main;
		private $image_file_extension;
		private $make_dir;
		private $move_to_dir;
	
		
		/*
		* 	@function 			__construct 
		* 	@description 		Take In all info for new podcast via array
		* 	@params 			
		* 	@return 			return bool;
		*/
		public function __construct($podcastNew){
			
			global $sessioninit, $db_connect, $config_array, $config_items;
			// Auth
			if(!$sessioninit::ses_auth_delete()){
				$this->__destruct();
			}
			
			// Set Vars
			$this->update_podcast_id = 			$config_items[0]['podcast_config_id'];
			$this->update_podcast_link = 		(!empty($podcastNew['podcast_update_related_link'])) ?	$podcastNew['podcast_update_related_link'] 	: false;
			$this->update_podcast_summary = 	(!empty($podcastNew['podcast_update_summary'])) 	?	$podcastNew['podcast_update_summary'] 		: false;
			$this->update_owner_name = 			(!empty($podcastNew['podcast_update_owner_name'])) 	? 	$podcastNew['podcast_update_owner_name'] 	: false;
			$this->update_owner_email = 		(!empty($podcastNew['podcast_update_owner_email'])) ? 	$podcastNew['podcast_update_owner_email'] 	: false;
			$this->update_podcast_image = 		(!empty($podcastNew['podcast_update_image'])) 		? 	$podcastNew['podcast_update_image'] 		: false;
			$this->update_podcast_image_hash = 	(!empty($podcastNew['podcast_update_image_hash'])) 	? 	$podcastNew['podcast_update_image_hash'] 	: false;
			$this->update_podcast_keywords = 	(!empty($podcastNew['podcast_update_keywords'])) 	? 	$podcastNew['podcast_update_keywords'] 		: false;
			$this->update_podcast_categories = 	(!empty($podcastNew['podcast_update_categories'])) 	? 	$podcastNew['podcast_update_categories'] 	: false;
				
			// CHECK THE LINKS THAT HAS BEEN SENT AND INSERT IT INTO THE DB
			if($this->update_podcast_link != false):
				// Validate That The URL Is valid 
				if(!$this->validateURL($this->update_podcast_link)):
					header("HTTP/1.1 400 The URL is Not Valid");
					echo $this->uploadErrorEncode('Either The links you have provided is dead or not avaliable to the general public');
					die();
				else:
					if($this->dbMask('podcast_link', $this->update_podcast_link) === false):
						header("HTTP/1.1 400 Unable To Add Link");
						echo $this->uploadErrorEncode('Nothing To Update');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Related Links Has Been Updated !');
					endif;
				endif;
			endif;
			
			// CHECK THE NEW SUMMARY THAT HAS BEEN SENT AND INSERT IT INTO THE DATABASE
			if($this->update_podcast_summary != false):
				//	Validate podcast subtitle
				if(!(strlen($this->update_podcast_summary) > 20)):
					header("HTTP/1.1 400 Provided Subtitle is bad");
					echo $this->uploadErrorEncode('The subtitle is not long enough - Minimum 20 Words');
					die();
				else:
					// DB ACCESS
					if($this->dbMask('podcast_subtitle', $this->update_podcast_summary) === false):
						header("HTTP/1.1 400 Unable To Add Summary To Database");
						echo $this->uploadErrorEncode('Unable To Update Podcast Summary');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Summary Updated');
					endif;
					
				endif;
			endif;
		
			
			// CHECK THE UPDATED OWNERS NAME THAT HAS BEEN SEND AND UPDATE TO DB
			if($this->update_owner_name != false):
			//	validate podcast owners name 
				if(!(strlen($this->update_owner_name) > 5)):
					header("HTTP/1.1 400 Provided Subtitle is bad");
					echo $this->uploadErrorEncode('Your Name Is To Short - Minimum 5 words');
					die();
				else:
					// DB ACCESS
					if($this->dbMask('podcast_owner_name', $this->update_owner_name) === false):
						header("HTTP/1.1 400 Unable To Update Podcast Owners Name");
						echo $this->uploadErrorEncode('Unable To Update Podcast Owners Name');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Owner Name Has Been Updated');
					endif;
				endif;
					
			endif;
			
			// CHECK THE UPDATED EMAIL ADDRESS THAT HAS BEEN SENT AND ADD IT TO THE DB
			if($this->update_owner_email != false):
				// Regex the email adresss to make sure its correct
				if(!($this->emailRegex($this->update_owner_email))):
					header("HTTP/1.1 400 Invalid Email");
					echo $this->uploadErrorEncode('That Is Not a valid email address');
					die();
				else:
					// DB ACCESS
					if($this->dbMask('podcast_owner_email', $this->update_owner_email) === false):
						header("HTTP/1.1 400 Unable To Update Owner Email Address !");
						echo $this->uploadErrorEncode('Unable To Update Owner Email Address !');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Owner Email Address Has Been Updated');
					endif;
					
				endif;
			endif;
			
			// CHECK THAT THE IMAGE AND HASH HAS BEEN SENT FROM THE CLIENT, IF THEY MATCH ADD NEW IMAGE TO THE DB THEN SEND THE IMAGE TO THE DEFAULT IMAGE LOCATION
			if($this->update_podcast_image != false  && $this->update_podcast_image_hash != false):
				// Regex the email adresss to make sure its correct
				if(!($this->checkImage($this->update_podcast_image,$this->update_podcast_image_hash))):
					header("HTTP/1.1 400 Image Processing Error");
					echo $this->uploadErrorEncode('Unable To Process Image');
					die();
				
				else:
					// Work Out Where We Are Going To Save all of the users files
					$this->make_dir = $config_array['document_root'].$config_array['default_image_loc'].$config_items[0]['podcast_config_id'].'/';
					// Set the  new image dir that will be used 
					$this->move_to_dir =  $this->make_dir .'/'.$config_items[0]['podcast_config_id'].'_'.$this->image_width_main.'_'.$this->image_height_main.'.'.$this->image_file_extension;
					// Make the name that will be used for the external podcast call
					$dbImageNew = $config_items[0]['podcast_config_id'].'_'.$this->image_width_main.'_'.$this->image_height_main.'.'.$this->image_file_extension;
					
					try{
						// DELETE ALL PREVIOUS IMAGES FROM THE DIRECTORY 
						$files = glob($this->make_dir."*"); // get all file names
							// Iterate the entire dir and remove all of the files !! - note that this will only work in a directory that is owned by the web serviced group of apache user - php is part of the apahe user group.
							foreach($files as $file): // iterate files
							  if(is_file($file))
								unlink($file); // delete file
							endforeach;
						// Copy Temp Hash
						copy($this->hash_temp, $this->move_to_dir);
						//Unlink The Temp Hash
						unlink($this->hash_temp);
						
					}catch(Exception $e){
						header("HTTP/1.1 500 UNABLE TO PROCESS IMAGE");
						echo $this->uploadErrorEncode('Unable To Upload New Image ! Error was -'.$e);
						die();
					}
					
					// DB ACCESS
					if($this->dbMask('podcast_image', $dbImageNew) === false):
						header("HTTP/1.1 400 Unable To Update Podcast Owners Name");
						echo $this->uploadErrorEncode('Unable To Update Podcast Owners Name');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Owner Name Has Been Updated');
					endif;
					
					
				endif;	

			endif;
				
			// CHECK UPDATED KEYWOK=RDS IF THEY HAVE BEEN SENT THEN ADD THEM TO THE DB
			if($this->update_podcast_keywords != false):
				// Regex the email adresss to make sure its correct
				if(!strlen($this->update_podcast_keywords) > 5):
					header("HTTP/1.1 400 Keywords To Long");
					echo $this->uploadErrorEncode('Keywords not long enough');
					die();
				else:
					// DB ACCESS
					if($this->dbMask('podcast_keywords', $this->update_podcast_keywords) === false):
						header("HTTP/1.1 400 Unable To Add Summary To Database");
						echo $this->uploadErrorEncode('Unable To Update Podcast Summary');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Summary Updated');
					endif;
					
				endif;
					
			endif;
			
			// CHECK TO SEE IF A NEW CATEGORY HAS BEEN SENT, IF IT IS VALID ADD TO THE DB
			if($this->update_podcast_categories != false):
				// Regex the email adresss to make sure its correct
				if(($this->checkCategory($this->update_podcast_categories))):
					header("HTTP/1.1 400 Invalid Category");
					echo $this->uploadErrorEncode('Invalid Category');
					die();
				else:
					// DB ACCESS
					if($this->dbMask('podcast_categories', $this->update_podcast_summary) === false || $this->dbMask('podcast_description', $this->update_podcast_summary) === false || $this->dbMask('podcast_summary', $this->update_podcast_summary) === false):
						header("HTTP/1.1 400 Unable To Add Summary To Database");
						echo $this->uploadErrorEncode('Unable To Update Podcast Summary');
						die();
					else:
						echo $this->uploadSucessEncode('Podcast Summary Updated');
					endif;
						
				endif;
				
			endif;

	

		}
		
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
		* 	@function 			uploadSucessEncode 
		* 	@description 		Json Encode An output
		* 	@params 			$error
		* 	@return 			return Json Encoded Error
		*/
	 	private function uploadSucessEncode($error){
		
			(array) $ret = array('Success' => array($error));
			return json_encode($ret);
			
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
		* 	@function 			dbMask 
		* 	@description 		Database Update
		* 	@params 			$input
		* 	@return 			return $output;
		*/
		private function dbMask($rowToAlter, $value){
			global $db_connect;
			try{
				$connectionDbAsset = $db_connect->pdoDirect();
				// Prepare The SQL QUERY WITH PDO 
				$category_asset = $connectionDbAsset->prepare("SELECT `$rowToAlter` FROM `podcast_config` WHERE `podcast_config_id`=?");
				$category_asset->bindParam( 1 , $this->update_podcast_id); 
				// EXECUTE PDO
				$category_asset->execute();
				$returnDB = $category_asset->fetch( PDO::FETCH_ASSOC );
				// Check that this is diffrent data
				if($returnDB[$rowToAlter] == $value) return true;
				// Prepare The SQL QUERY WITH PDO 
				$category_asset = $connectionDbAsset->prepare("UPDATE `podcast_config` SET `$rowToAlter`=? WHERE `podcast_config_id`=?");
				// BIND PARAMS TO PDO
				$category_asset->bindParam( 1 , $value);
				$category_asset->bindParam( 2 , $this->update_podcast_id); 
				// EXECUTE PDO
				$category_asset->execute();
				echo $category_asset->rowCount();
				if($category_asset->rowCount() > 0) return true;
				else return false;
			}
			catch (Exception $e) {
				header("HTTP/1.1 500 PDO Parse Error !");
				echo "Unable to add $rowToAlter to $value";
				echo $e;
				return false;
			}

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
				
				if($width < 2000 && $height < 2000 && $width > 500 && $height > 500 && ($height % 10) == 0 && ($width % 10) == 0):
				
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
			
			echo $url;
			
			$ch = curl_init(); // Start Curl and place in container VAR
			$opts = array(CURLOPT_RETURNTRANSFER => true, // We dont want output just header infomation
			CURLOPT_URL => $url,				// Set The URL
			CURLOPT_NOBODY => true,			 	// do a HEAD request only
			CURLOPT_TIMEOUT => $timeout);  		// set timeout
			curl_setopt_array($ch, $opts); 
			curl_exec($ch); 					// Execute CURL 
			$http_responce = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch); 					// Get RID OF THE CURRRLLLL, THROW IT DOWN THE WELLLLL
			echo $http_responce;
			$valid_url = array(200,300,301,302,303,304,305,306,307);
			
			foreach($valid_url as $url):
			
				if($url === $http_responce) return true;
			
			endforeach;
			
			return false;
			
		}
	 
	}


?>