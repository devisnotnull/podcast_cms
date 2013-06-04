<?php

	/*
	*	Uploadify
	*	Copyright (c) 2012 Reactive Apps, Ronnie Garcia.
	*	Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>.
	* 	Altered For Use By Alex Of Gaming Media Group.
	*	V2 - 07-03-3013  :) Booo-yaaa-caaaa-shaaa.
	*/

	// 	Define a destination.
	//	CORS Restriction to be enforeced in access control origin.

	// CORE CONFIG
	require_once('config.php');
	
	// ID3 Tag Editor Core fILE
	require_once('getid3/getid3.php');
		

	class uploadHandle{

	
		private $targetFolder;
		private $errorSet;
		private $errorCode;
		private $tempFile;
		private $targetFile;
		
		
		public function __construct(){
		
			global $config_array;
			header("HTTP/1.1 400 No Image Specified");
			$this->targetFolder = $config_array['document_root'].$config_array['default_tmp_loc'];
			
					// If There Are No Files Then We Throw An Error Header
			if(!empty($_FILES)):
				
				$this->tempFile = $_FILES['Filedata']['tmp_name'];
				$targetPath = $this->targetFolder;
				$this->targetFile = rtrim($targetPath,'/') . '/' . md5($_FILES['Filedata']['name']);
				
				// Validate the file type
				$fileTypes = array('mp3','jpg','png','mp4'); // File extensions
				$fileParts = pathinfo($_FILES['Filedata']['name']);
				
				if(in_array($fileParts['extension'],$fileTypes)):
				
					if($fileParts['extension'] == 'png') $this->uploadImage();
					if($fileParts['extension'] == 'jpg') $this->uploadImage();
					if($fileParts['extension'] == 'mp3') $this->uploadAudio();
					if($fileParts['extension'] == 'mp4') $this->uploadVideo();
					
				endif;
				
				if(!in_array($fileParts['extension'],$fileTypes)):
				
					header("HTTP/1.1 400 Unable To Move File");
					$this->errorCode = 400;
					$this->errorSet = false;
					return false;
					
				endif;
			
			else:
				header("HTTP/1.1 401 No Such File");
				$this->errorCode = 400;
				$this->errorSet = false;
				return false;
			
			endif;
		
		}
		
		private function uploadImage(){
			echo "IMAGE";
			if(move_uploaded_file($this->tempFile,$this->targetFile.'.png')):
				header("HTTP/1.1 205 Created");
				return true;
			else: 
				header("HTTP/1.1 400 Unable To Move File");
				return false;
			endif;
		}
		
		private function uploadVideo(){
			echo "VIDEO";
			if(move_uploaded_file($this->tempFile,$this->targetFile.'.mp4')):
				header("HTTP/1.1 205 Created");
				return true;
			else: 
				header("HTTP/1.1 400 Unable To Move File");
				return false;
			endif;
			
		}
		
		private function uploadAudio(){
			echo "AUDIO";
			if(move_uploaded_file($this->tempFile,$this->targetFile.'.mp3')):
				header("HTTP/1.1 205 Created");
				return true;
			else: 
				header("HTTP/1.1 400 Unable To Move File");
				return false;
			endif;
		
		}


	}