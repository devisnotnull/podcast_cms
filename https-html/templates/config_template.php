<?php 

	if(!$sessioninit::ses_auth_root()){
	
		die("<h1>Your Account Does Not Have Alter/Delete Prvilieges !</h1>");
		
	}
	
?>
	<script src="<?php echo $config_array['server_root']; ?>public/js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="<?php echo $config_array['server_root']; ?>public/js/md5.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $config_array['server_root']; ?>public/css/uploadify.css">
	
	<style>
	
		.row-pad-config-tem{
			margin-bottom:10px;
		}
		.row-pad-config-tem > .span3{
			border-bottom: 1px solid #CCC;
			font-weight: bold;
			margin-bottom: 15px;
		}

	</style>


	
	<div class="row">
		<div class="span12">
			<div class="page-header">
				<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"  ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
			  <h1>Podcast Config <small> - Update Your Podcast</small></h1>
			</div>
		</div>
	</div>

	<form>
	

		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Show Related Link</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_link'] ?>" class="span9" id="podcast_update_related_link" name="podcast_update_related_link"></div>
		</div>


		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Subtitle</div>
			<div class="span9"><textarea class="span9" style="height:130px" id="podcast_update_subtitle" placeholder="<?php echo $config_cms_setup['podcast_subtitle'] ?>" name="podcast_update_subtitle"></textarea></div>
		</div>

		
		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Owner Name</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_owner_name'] ?>" class="span9" id="podcast_update_owner_name" name="podcast_update_owner_name"></div>
		</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Owner Email</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_owner_email'] ?>" class="span9" id="podcast_update_owner_email" name="podcast_update_owner_email"></div>
		</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Image</div>
			<div class="span9">
			
				<div id="queue"></div>
				<input id="image_new_upload" name="image_new_upload" type="file" multiple="true"></div>
				
				<input type="hidden" name="podcast_update_image">
				<input type="hidden" name="podcast_update_image_hash">
				
			</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Keywords - Comma Seperated</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_keywords'] ?>" class="span9" id="podcast_update_keywords" name="podcast_update_keywords"></div>
		</div>	
		
		
		<div class="row" style="margin-top:20px;">
			<button type="button" class="btn span12" id="update-podcast-check">Update Podcast Informatin</button>
		</div>
	
	</form>
	
	<script>
		<?php
		(array) $ret = array('global_podcast_title' 		=> $config_cms_setup['podcast_title'],
								'global_podcast_url'		=> $config_cms_setup['podcast_link'],
								'global_podcast_language' 	=> $config_cms_setup['podcast_language'],
								'global_podcast_subtitle' 	=> $config_cms_setup['podcast_subtitle'],
								'global_podcast_summary' 	=> $config_cms_setup['podcast_summary'],
								'global_podcast_description'	=> $config_cms_setup['podcast_description'],
								'global_podcast_owner_name'	=> $config_cms_setup['podcast_owner_name'],
								'global_podcast_owner_email'	=> $config_cms_setup['podcast_owner_email'],
								"global_podcast_image"		=> $config_cms_setup['podcast_image'] ,
								'global_podcast_keywords'	=> $config_cms_setup['podcast_keywords'],
								'global_podcast_categories' => $config_cms_setup['podcast_categories'],
								'global_podcast_next_number'	=> $config_cms_setup['podcast_config_next_number'],
								'global_podcast_image_url'		=>	$config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"
							);
		$config_ar = json_encode($ret);
		?>
		// Set Global Vars
		var global_vars_php = JSON.stringify(<?php echo $config_ar; ?>);
		global_vars_php = jQuery.parseJSON(global_vars_php);
		// Add Strip tag function to String Prototype
		function validatePass(passtocheck){
			// Regex The Rules
			if(passtocheck.length < 4) return false;
			var validpattern = new RegExp('^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$_%]).{8,30}$');
			if (passtocheck.match(validpattern))	return true;
			else return false;				
		};
		// Add Strip tag function to String Prototype
		String.prototype.stripHTML = function(){
			// What a tag looks like
			var matchTag = /<(?:.|\s)*?>/g;
			if(this != this.replace(matchTag, "")) alert("You Cannot User <>/* This Will Simply Be Removed");
			return this.replace(matchTag, "");
		};
		// Form Checking function , will
		function form_check_podcast(){
			// Clear The Form just in case there is old data
			$('#lightbox_new > .inner').html('');
			// Set all the varibales that are going to be used.
			var podcast_update_related_link, podcast_update_subtitle, podcast_update_owner_name, podcast_update_owner_email, podcast_update_image, podcast_update_image_hash, podcast_update_keywords, podcast_update_categories, errors_var = [];
			var podcast_update_related_link_dis, podcast_update_subtitle_dis, podcast_update_owner_name_dis, podcast_update_owner_email_dis, podcast_update_image_dis, podcast_update_image_hash_dis, podcast_update_keywords_dis, podcast_update_categories_dis;
			// Strip out nasty characters, and get the values from the form.
			podcast_update_related_link =	$('input[name=podcast_update_related_link]').val().stripHTML();
			podcast_update_subtitle =	$('#podcast_update_subtitle').val().stripHTML();
			podcast_update_owner_name =	$('input[name=podcast_update_owner_name]').val().stripHTML();
			podcast_update_owner_email =	$('input[name=podcast_update_owner_email]').val().stripHTML();
			podcast_update_image =	$('input[name=podcast_update_image]').val().stripHTML();
			if ( podcast_update_image ) podcast_update_image_hash = hex_md5(podcast_update_image);
			podcast_update_keywords =	$('input[name=podcast_update_keywords]').val().stripHTML();
			// Remove the progress bar !
			$('#progress_main_bar').remove();
				// Perorm some validation, all the information is checked propely on the server, this is just for user facing purposes.
				// SHow The Lghtbox
				$('.fade-out').fadeTo('slow',0.2);
				$('#lightbox_new').css('display','block');
				$('#lightbox_new').fadeTo('slow',1);
				// Work out what the new information for the podcast will , compare global vars to new local Ones.
				if(typeof podcast_update_related_link === 'undefined' || podcast_update_related_link.length < 6 ){
					podcast_update_related_link_dis = global_vars_php.global_podcast_url;
				}
				else podcast_update_related_link_dis = podcast_update_related_link;
				
				if(typeof podcast_update_subtitle === 'undefined' || podcast_update_subtitle.length < 20 ){
					podcast_update_subtitle_dis = global_vars_php.global_podcast_subtitle;
				}
				else podcast_update_subtitle_dis = podcast_update_subtitle;
				
				if(typeof podcast_update_owner_name === 'undefined' || podcast_update_owner_name.length < 6 ){
					podcast_update_owner_name_dis = global_vars_php.global_podcast_owner_name;
				}
				else podcast_update_owner_name_dis = podcast_update_owner_name;
				
				if(typeof podcast_update_owner_email === 'undefined' || podcast_update_owner_email.length < 6 ){
					podcast_update_owner_email_dis = global_vars_php.global_podcast_owner_email;
				}
				else podcast_update_owner_email_dis = podcast_update_owner_email;
				
				if(typeof podcast_update_image === 'undefined' || podcast_update_image.length < 6 ){
						podcast_update_image_dis = global_vars_php.global_podcast_image_url;
				}
				else podcast_update_image_dis = "/tmp/" + podcast_update_image_hash + ".png";
				
				if(typeof podcast_update_keywords === 'undefined' || podcast_update_keywords.length < 6 ){
						podcast_update_keywords_dis = global_vars_php.global_podcast_keywords;
				}
				else podcast_update_keywords_dis = podcast_update_keywords;
				
				//scroll to the top
				window.scrollTo(0, 0);
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Links That Podcast Will Refrence In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_update_related_link_dis + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcasts Subtitle, Description</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_update_subtitle_dis + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Owner Of The POdcast As Shown In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_update_owner_name_dis + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Owner Email Address In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_update_owner_email_dis + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Name Of The Image To Use</div>');
				$('#lightbox_new > .inner').append('<img src="' + podcast_update_image_dis + '" />');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Keywords For The Podcast</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_update_keywords_dis + '</div>');
				// Add the Confirm and delete buttons
				$('#lightbox_new > .inner').append('<button type="button" class="btn btn-danger danger-submit" id="new_podcast_confirm_submit">Add New Podcast</button>');
				$('#lightbox_new > .inner').append('<button type="button" class="btn danger-submit" id="new_podcast_confirm_cancel">Cancel</button>');
				// Bind the Submit buttons click function
				$('#new_podcast_confirm_submit').bind('click' , function(){	
					// Send the AJAX call to the server with all the information to be checked
					$.ajax({
						url: "<?php $config_array['server_root'] ?>upload/updatePodcast.php",
						type: 'POST',
						data: { podcast_update_related_link : podcast_update_related_link, 
						podcast_update_subtitle : podcast_update_subtitle ,podcast_update_owner_name : podcast_update_owner_name, podcast_update_owner_email : podcast_update_owner_email,
						podcast_update_image : podcast_update_image, podcast_update_image_hash : podcast_update_image_hash, podcast_update_keywords : podcast_update_keywords, 
						 },
						success: function(data, textStatus, request){
							alert('Sucess, The Podcast Has Been Added, You Will Now Be Redirected To Podcast Mainpage !');
							// SHow The Lghtbox
							$('.fade-out').fadeTo('slow',1);
							$('#lightbox_new').fadeTo('slow',0);
							$('#lightbox_new').css('display','none');
						},
						error: function(data){	
							alert("ERRROR" + data.responseText);
						}
					})
				})
				// Bind the cancel button
				$('#new_podcast_confirm_cancel').bind('click' , function(){	
					$(this).unbind('click');
					$('#new_podcast_confirm_submit').unbind('click');
					$('.fade-out').fadeTo('slow',1);
					$('#lightbox_new').fadeTo('slow',0);
					$('#lightbox_new').css('display','none');
				})
		}
		
		// Document Ready Function
		$(function() {
		
			// Bind the close lightbox button
			$('#lightbox_new > .close').bind('click' , function(event){	
				$('.fade-out').fadeTo('slow',1);
				$('#lightbox_new').fadeTo('slow',0);
				$('#lightbox_new').css('display','none');
			})
			
			// Bind the podcast Create Button
			$('#update-podcast-check').bind('click' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			
			// Bind the podcast Create Button
			$('#update-podcast-check').bind('submit' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			
			<?php $timestamp = time();?>
			// bind the uploadify plugin to the File upload HTML Asset
			$('#image_new_upload').uploadify({
			
					'formData'     : {
						'timestamp' : '<?php echo $timestamp;?>',
						'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
					},
					'width'    			: 		700,
					'buttonText' 		: 		'Click Here To Select Podcast - Must Be A PNG IMAGE',
					'progressData' 		: 		'speed',
					'removeCompleted' 	: 		false,
					'removeTimeout' 	: 		5,
					'fileSizeLimit' 	: 		'5MB',
					'method'   			: 		'post',
					'queueSizeLimit' 	: 		3,
					'fileTypeExts' 		:		'*.png;',
					'swf'      			: 		'<?php echo $config_array['server_root']; ?>public/flash/uploadify.swf',
					'uploader' 			: 		'<?php echo $config_array['server_root']; ?>upload/upload.php',
					'overrideEvents' 	: 		'',
					'onUploadSuccess' 	: function(file, data, response) {
						console.log(file, data, response);
						alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':');
						$('input[name=podcast_update_image]').val(file.name);
						$('input[name=podcast_update_image_hash]').val(hex_md5(file.name));
			
					},
					'onUploadError' : function(file, errorCode, errorMsg, errorString) {
						alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
					},
					'onSelectError' : function() {
						alert('The file ' + file.name + ' returned an error and was not added to the queue.');
					},
					'onCancel' : function(file) {
						alert('The file ' + file.name + ' Has Been Removed.');
					},

			});
			
			
		});
				

	</script>