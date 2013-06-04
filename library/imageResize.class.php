<?php
	

/* 

	GMG IMAGE RESIZE CLASS
	vesrsion V1
	Created by alex brown C=

*/
	
	class flagResize{
	
		private $imageBaseUrl;
		private $imgUrl;
		private $oldHeight;
		private $oldWidth;
		private $oldImgType;
		private $userImage;
		private $baseHttpUrl;
		private $newHeight;
		private $newWidth;
		
		
		/*
		* 	@function 			__construct		Constructor
		* 	@description 		Takes The ID of a show that you wish to grab images from.
		* 	@params 			showToGet
		* 	@return 			return bool;
		*/
		public function __construct($showToGet){
		
			
			global $config_array;
		
			// CHECK IF THE ID OF THE SHOW EXISTS
			$db_connect = database_instance::__getInstance();
			$podcast_account = $db_connect->rowCount("SELECT podcast_config_id FROM podcast_config WHERE podcast_config_id = '{$showToGet}';");
			
			if($podcast_account != false):
			
				$db_connect = database_instance::__getInstance();
				$podcast_account = $db_connect->query("SELECT podcast_config_id, podcast_image FROM podcast_config WHERE podcast_config_id = '{$showToGet}';");
				
				if(isset($podcast_account[0]['podcast_image'])):
				
					$imageInternalURL = $config_array['document_root'].$config_array['default_image_loc'].$podcast_account[0]['podcast_config_id'].FS.$podcast_account[0]['podcast_image'];
					$this->baseHttpUrl = $config_array['serverAddress'].$config_array['imageAddress'];
					$this->userImage = $config_array['serverAddress'].$config_array['imageAddress'].$podcast_account[0]['podcast_config_id'].FS.$podcast_account[0]['podcast_config_id'].'_';
					$this->imageBaseUrl = $config_array['document_root'].$config_array['default_image_loc'].$podcast_account[0]['podcast_config_id'].FS.$podcast_account[0]['podcast_config_id'].'_';
					if(!file_exists($imageInternalURL)):
						$this->imgUrl = false;
					else:
						$this->imgUrl = $imageInternalURL;
					endif;
					
				endif;
				
			endif;
			
			$returnVar = ($this->imgUrl == false) ? false : true;

			return $returnVar;
		}
		
		
		/*
		* 	@function 			setOldMesure 
		* 	@description 		Get the mesurements of the master image to refrence when resizing and set in class vars
		* 	@params 			None
		* 	@return 			none;
		*/
		public function setOldMesure(){
		
			list($width, $height, $type, $attr) = getimagesize($this->imgUrl);
			
			$this->oldWidth = $width;
			$this->oldHeight = $height;
			

		}
		
		/*
		* 	@function 			setNewPixel 
		* 	@description 		function to be used when you want to rezise using seperate pixel counts, this can be anysize, but the picture ratio is not guarenteed.
		*						Max size of 2000 height of width
		* 	@params 			$newWidthPix & $newHeightPix
		* 	@return 			bool;
		*/
		public function setNewPixel($newWidthPix, $newHeightPix){
		
			if($newWidthPix > 2000 || $newHeightPix > 2000 || ($newWidthPix % 10) != 0 || ($newHeightPix % 10) != 0 ) return false;
			
			$this->newWidth = $newWidthPix;
			$this->newHeight = $newHeightPix;
			
			return true;
		}
		
		
		/*
		* 	@function 			setNewPercent 
		* 	@description 		function to be used when you want to rezise using seperate percentage, will maintain aspect ratio and image consistency.
		* 	@params 			$newPercent
		* 	@return 			return bool;
		*/
		public function setNewPercent($newPercent){
		
			if(!is_int($newPercent) || $newPercent > 150) return false;
			
			$this->newWidth = ($this->oldWidth * ($newPercent / 100));
			$this->newHeight = ($this->oldHeight * ($newPercent / 100)) ;
	
			$maxheight = $this->newHeight;
			$maxwidth = $this->newWidth;
	
			if ($this->oldWidth > $this->oldHeight) {

				// LANDSCAPE
				$this->newWidth = $maxwidth;
				$this->newHeight = round($this->oldHeight * ($maxwidth / $this->oldWidth));
				
				if ($this->newHeight > $maxheight) {

					$this->newHeight = $maxheight;
					$this->newWidth = round($this->oldWidth * ($maxheight / $this->oldHeight));
					
				}

			}else {

			// PORTRAIT
			
				$this->newHeight = $maxheight;
				$this->newWidth = round($this->oldWidth * ($maxheight / $this->oldHeight));
				
				if ($this->newWidth > $maxwidth) {
				
					$this->newWidth = $maxwidth;
					$this->newHeight = round($this->oldHeight * ($maxwidth / $this->oldWidth));
					
				}
			}

			
			return true;
		}
		
		/*
		* 	@function 			checkImageExists 
		* 	@description 		Checks to see if an image has alredy been renederd in the required size and if so returns true.
		* 	@params 			
		* 	@return 			return bool;
		*/
		private function checkImageExists(){
		
			if(file_exists($this->imageBaseUrl.$this->newWidth.'_'.$this->newHeight.'.png') && ( time() - filectime($this->imageBaseUrl.$this->newWidth.'_'.$this->newHeight.'.png') ) < 86400) return true;
			else return false;
			
		}
		
		/*
		* 	@function 			renderNewImage 
		* 	@description 		Takes the resize params and renders and saves the image to the image Dir of that podcast
		* 	@params 			
		* 	@return 			
		*/
		public function renderNewImage(){
		
			if($this->checkImageExists()) return $this->imageBaseUrl.$this->newWidth.'_'.$this->newHeight.'.png';
			
			$tmpimg =  imagecreatetruecolor((int) $this->newWidth, (int) $this->newHeight );
		
			imagealphablending($tmpimg, false);
			imagesavealpha($tmpimg, true);
			
			$makeimg = imagecreatefrompng($this->imgUrl);
			imagealphablending($makeimg, true);
			
			// Copy and resize old image into new image.
			imagecopyresampled ($tmpimg, $makeimg, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->oldWidth, $this->oldHeight );
			// Save thumbnail into a file.
			if(imagepng( $tmpimg, $this->imageBaseUrl.$this->newWidth.'_'.$this->newHeight.'.png')):
				// release the memory
				imagedestroy($makeimg);
				return $this->userImage.$this->newWidth.'_'.$this->newHeight.'.png';
			else:
				return $this->baseHttpUrl.'error-404.png';
			endif;
			
	
		
		}
		
		/*
		* 	@function 			displayNewImage 
		* 	@description 		Trys to locate picture, if found redirects to image, else 404 image
		* 	@params 			
		* 	@return 			
		*/
		public function displayNewImage(){
		
			if($this->checkImageExists()):
				
				$varloc = $this->userImage.$this->newWidth.'_'.$this->newHeight.'.png';
				header("Location: {$varloc}");
			else:
				$goto = $this->renderNewImage();
				header("Location: {$goto}");
			endif;
			
		
			
		}
		
		
		/*
		* 	@function 			__destruct 
		* 	@description 		kill the class
		* 	@params 			
		* 	@return 			
		*/
		public function __destruct(){
		}
	
	}

?>