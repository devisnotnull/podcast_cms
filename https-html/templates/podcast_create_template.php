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

	
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Modal header</h3>
		</div>
		<div class="modal-body">
			<p>One fine body…</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn btn-primary">Save changes</button>
		</div>
	</div>

	
	<div class="row">
		<div class="span12">
			<div class="page-header">
			<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"  ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
			  <h1>Create New Podcast <small> - This Will Create A Completely New Podcast</small></h1>
			</div>
		</div>
	</div>

	<form>
	
		<div class="row row-pad-config-tem">
			<div class="span3">New User For Podcast</div>
			<div class="span7"><input type="text" placeholder="Username Youll Use To Login" class="span9" name="podcast_new_user_name" id="podcast_new_user_name"></div>
		</div>
		
		
		<div class="row row-pad-config-tem">
			<div class="span3">Password<div><small>Must Contain One Capital, Number And Special Char e.g _@#</small></div></div>
			<div class="span3"><input type="password" placeholder="Password" class="span3" name="podcast_new_password" id="podcast_new_password"></div>
			<div class="span3">Re-enter Password</div>
			<div class="span3"><input type="password" placeholder="Password" class="span3" name="podcast_new_password_confirm" id="podcast_new_password_confirm"></div>
		</div>
		
		
		
		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Show Name</div>
			<div class="span7"><input type="text" placeholder="The Name Of The New Podcast" class="span9" id="podcast_new_name" name="podcast_new_name"></div>
		</div>

		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Show Related Link</div>
			<div class="span9"><input type="text" placeholder="The Website That The Podcast Will Relate To" class="span9" id="podcast_new_related_link" name="podcast_new_related_link"></div>
		</div>

		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Type</div>
			<div class="span9">
				<select class="span9" id="podcast_new_media_type" name="podcast_new_media_type">
					<option value="standard-audio">Standard Audio</option>
					<option value="standard-video">Standard Video</option>
				</select>
			</div>
		</div>
		
		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Default Language</div>
			<div class="span9">
				<select class="span9" id="podcast_new_language" name="podcast_new_language">	
					<option value="en-gb">English</option>
				</select>
			</div>
		</div>

		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Subtitle</div>
			<div class="span9"><textarea class="span9" style="height:130px" id="podcast_new_subtitle" name="podcast_new_subtitle"></textarea></div>
		</div>

		
		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Owner Name</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_owner_name'] ?>" class="span9" id="podcast_new_owner_name" name="podcast_new_owner_name"></div>
		</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Owner Email</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_owner_email'] ?>" class="span9" id="podcast_new_owner_email" name="podcast_new_owner_email"></div>
		</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Image</div>
			<div class="span9">
			
				<div id="queue"></div>
				<input id="image_new_upload" name="image_new_upload" type="file" multiple="true"></div>
				
				<input type="hidden" name="podcast_new_image">
				<input type="hidden" name="podcast_new_image_hash">
				
			</div>	
		
			<div class="row row-pad-config-tem">
			<div class="span3">Podcast Keywords - Comma Seperated</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_keywords'] ?>" class="span9" id="podcast_new_keywords" name="podcast_new_keywords"></div>
		</div>	
		
		<div class="row row-pad-config-tem">
			<div class="span3">Podcast Categories - Comma Seperated</div>
			<div class="span9"><input type="text" placeholder="<?php echo $config_cms_setup['podcast_categories'] ?>" class="span9" id="podcast_new_categories" name="podcast_new_categories"></div>
		</div>	
		
		<div class="row" style="margin-top:20px;">
			<button type="button" class="btn span12" id="create-new-podcast-check">Generate New Podcast</button>
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
							);
		$config_ar = json_encode($ret);
		?>
		// Set Global Vars
		var global_vars_php = JSON.stringify(<?php echo $config_ar; ?>);
		global_vars_php = jQuery.parseJSON(global_vars_php);
		console.log(global_vars_php);
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
		// Add Strip tag function to String Prototype
		String.prototype.compareStrings = function(idToCompare){
			// Compare Steings In Password
			if(this == $(idToCompare).val()){ 
				$('#podcast_new_password').css('background', '#FFFFFF');	
				$('#podcast_new_password_confirm').css('background', '#FFFFFF');
			}
			else{
				$('#podcast_new_password').css('background', '#FF9D85'); 
				$('#podcast_new_password_confirm').css('background', '#FF9D85'); 
			}
		};
		// Form Checking function , will
		function form_check_podcast(){
			// Clear The Form just in case there is old data
			$('#lightbox_new > .inner').html('');
			// Set all the varibales that are going to be used.
			var podcast_new_user_name, podcast_new_password, podcast_new_name, podcast_new_related_link, podcast_new_media_type, podcast_new_language, podcast_new_subtitle,
			podcast_new_owner_name, podcast_new_owner_email, podcast_new_image, podcast_new_image_hash, podcast_new_keywords, podcast_new_categories, errors_var = [];
			// Strip out nasty characters, and get the values from the form.
			podcast_new_user_name = $('input[name=podcast_new_user_name]').val().stripHTML();
			podcast_new_password =	$('input[name=podcast_new_password]').val().stripHTML();
			podcast_new_name =	$('input[name=podcast_new_name]').val().stripHTML();
			podcast_new_related_link =	$('input[name=podcast_new_related_link]').val().stripHTML();
			podcast_new_media_type =	$('#podcast_new_media_type').val();
			podcast_new_language =	$('#podcast_new_language').val();
			podcast_new_subtitle =	$('#podcast_new_subtitle').val().stripHTML();
			podcast_new_owner_name =	$('input[name=podcast_new_owner_name]').val().stripHTML();
			podcast_new_owner_email =	$('input[name=podcast_new_owner_email]').val().stripHTML();
			podcast_new_image =	$('input[name=podcast_new_image]').val().stripHTML();
			podcast_new_image_hash = hex_md5(podcast_new_image);
			podcast_new_keywords =	$('input[name=podcast_new_keywords]').val().stripHTML();
			podcast_new_categories =	$('input[name=podcast_new_categories]').val().stripHTML();
			// Remove the progress bar !
			window.scrollTo(0, 0);
			$('#progress_main_bar').remove();
				// Perorm some validation, all the information is checked propely on the server, this is just for user facing purposes.
				if(podcast_new_user_name.length < 7 || validatePass(podcast_new_password) == false ){
					alert('Your Username Is Not Long Enough Or Your Password Is Not Complex - Must Be AT LEAST 8 Characters and have at least one special character ( _ @ # )');
					return false;
				}
				if(typeof podcast_new_name === 'undefined' || podcast_new_name.length < 6 )	{
					alert('The Name You have Chosen in not valid!');
					return false;
				}
				if(typeof podcast_new_related_link === 'undefined' || podcast_new_related_link.length < 6 ){
					alert('You Need To Enter A Valid Link For The Podcast !'); 
					return false;
				}
				if(typeof podcast_new_subtitle === 'undefined' || podcast_new_subtitle.length < 20 ){
					alert('This Podcast Requires A Subtitle, this is the description Used on itunes!'); 
					return false;
				}
				if(typeof podcast_new_owner_name === 'undefined' || podcast_new_owner_name.length < 6 ){
					alert('Please Enter The Author of the show !');
					return false;
				}
				if(typeof podcast_new_owner_email === 'undefined' || podcast_new_owner_email.length < 6 ){
					alert('A Contact Email Is Needed!');
					return false;
				}
				if(typeof podcast_new_image === 'undefined' || podcast_new_image.length < 6 ){
					alert('You need To Select an image for the podcast!'); 
					return false;
				}
				if(typeof podcast_new_keywords === 'undefined' || podcast_new_keywords.length < 6 ){
					alert('Keywords Are Needed For itunes to show the show in Apple Search !'); 
					return false;
				}
				if(typeof podcast_new_categories === 'undefined' || podcast_new_categories.length < 2 ){
					alert('A category Is needed to refrence the podcast with apple!'); 
					return false;
				}
				// SHow The Lghtbox
				$('.fade-out').fadeTo('slow',0.2);
				$('#lightbox_new').css('display','block');
				$('#lightbox_new').fadeTo('slow',1);
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Username Required To Login To Podcast</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_user_name + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">The Name Of The New Podcast</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_name + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Links That Podcast Will Refrence In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_related_link + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">The Media Type Of The Podcast - Audio / Video</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_media_type + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Default Language</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_language + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcasts Subtitle, Description</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_subtitle + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Owner Of The POdcast As Shown In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_owner_name + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Owner Email Address In Itunes</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_owner_email + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Name Of The Image To Use</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_image + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Keywords For The Podcast</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_keywords + '</div>');
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Category</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_categories + '</div>');
				// Add the Confirm and delete buttons
				$('#lightbox_new > .inner').append('<button type="button" class="btn btn-danger danger-submit" id="new_podcast_confirm_submit">Add New Podcast</button>');
				$('#lightbox_new > .inner').append('<button type="button" class="btn danger-submit" id="new_podcast_confirm_cancel">Cancel</button>');
				// Bind the Submit buttons click function
				$('#new_podcast_confirm_submit').bind('click' , function(){	
					// Send the AJAX call to the server with all the information to be checked
					$.ajax({
						url: "<?php $config_array['server_root'] ?>upload/createNewPodcast.php",
						type: 'POST',
						data: { podcast_new_user_name : podcast_new_user_name , podcast_new_password : podcast_new_password, podcast_new_name : podcast_new_name, 
						podcast_new_related_link : podcast_new_related_link, podcast_new_media_type : podcast_new_media_type, podcast_new_language : podcast_new_language,
						podcast_new_subtitle : podcast_new_subtitle ,podcast_new_owner_name : podcast_new_owner_name, podcast_new_owner_email : podcast_new_owner_email,
						podcast_new_image : podcast_new_image, podcast_new_image_hash : podcast_new_image_hash, podcast_new_keywords : podcast_new_keywords, 
						podcast_new_categories : podcast_new_categories },
						success: function(data, textStatus, request){
							alert('Sucess, The Podcast Has Been Added, You Will Now Be Redirected To Podcast Mainpage !');
							window.location = "/viewall";
						},
						error: function(data){
							var jsonReturn = jQuery.parseJSON(data.responseText);
							alert("Sorry There Was An Error, Please Check Your Input \n SERVER RESPONCE : " + jsonReturn.errors[0]);
							$('#new_podcast_confirm_submit').unbind('click');
							$('.fade-out').fadeTo('slow',1);
							$('#lightbox_new').fadeTo('slow',0);
							$('#lightbox_new').css('display','none');
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
			$('#create-new-podcast-check').bind('click' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			
			// Bind the podcast Create Button
			$('#create-new-podcast-check').bind('submit' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			// Password Checking, Bind on focus out, will inform user if there passwords dont match
			$('#podcast_new_password_confirm').bind('focusout', function(){
				$(this).val().stripHTML().compareStrings('#podcast_new_password');
			})
			
			// Password Checking, Bind on focus out, will inform user if there passwords dont match
			$('#podcast_new_password').bind('focusout', function(){
				$(this).val().stripHTML().compareStrings('#podcast_new_password_confirm');
			})
			
			<?php $timestamp = time();?>
			// bind the uploadify plugin to the File upload HTML Asset
			$('#image_new_upload').uploadify({
			
					'formData'     : {
						'timestamp' : '<?php echo $timestamp;?>',
						'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
					},
					'width'    			: 		600,
					'buttonText' 		: 		'Click Here To Select Podcast - Must Be An Image',
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
						alert(file.name + "Was Sucessfully Uploaded")
						$('input[name=podcast_new_image]').val(file.name);
						$('input[name=podcast_new_image_hash]').val(hex_md5(file.name));
			
					},
					'onUploadError' : function(file, errorCode, errorMsg, errorString) {
						alert('ERROR UPLOADING FILE - Check That File You Are Uploading Is An Image');
					},
					'onSelectError' : function(file) {
						alert('Error Adding File To The Que');
					},
					'onCancel' : function(file) {
						alert('File Upload Cancelled');
					},

			});
			
			
		});
				

	</script>