	<?php 

		/*****

			GMG PODCAST MANAGEMENT
			vesrsion V1
			Requires PDO DB Class
			ALTERED FOR GMG PODCAST CMS
			Delete Page.

		*****/
		
	?>


	<script src="<?php echo $config_array['server_root']; ?>public/js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="<?php echo $config_array['server_root']; ?>public/js/md5.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $config_array['server_root']; ?>public/css/uploadify.css">
	
	
	
	<div class="row fade-out" style="margin-bottom:10px;">
	
		<div class="span12">
			<div class="page-header">
				<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10" ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
			  <h1>Add New Podcast <small> - Please Fill In The Form Below</small></h1>
			</div>
		</div>
		
		<div class="span3">
			<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=20" ?>" class="podcast_main_sub_img" style="min-width:100%;"/>
			
			<div>
				<div class="label label-info">Podcast Primary Title</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_title'] ?></div>
			</div>
			
			<div>
				<div class="label label-info">Podcast Link</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_link'] ?></div>
			</div>
			
			<div>
				<div class="label label-info">Default Keywords</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_keywords'] ?></div>
			</div>
			
			<div>
				<div class="label label-info">Default Categories</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_categories'] ?></div>
			</div>
			
			<div>
				<div class="label label-info">Registered Owner</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_owner_name'] ?></div>
			</div>
			
			<div>
				<div class="label label-info">Registered Email</div>
				<div class="podcast_main_sub_cat"><?php echo $config_cms_setup['podcast_owner_email'] ?></div>
			</div>
			
		</div>
		
		<div class="span9">
		
			<form name="podcast_new_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			
				
				<label for="podcast_new_title" class="podcast-new-item-label"><b>Podcast Title</b> - <small> * Leave Blank If You Just Want The Standard Title</small></label>
					<input type="text" name="title_main" class="span3" placeholder="<?php echo $config_cms_setup['podcast_title'] ?>" readonly>
					<input type="text" name="podcast_new_title" class="span5">
					<input type="text" name="podcast_new_title_date" id="podcast_new_title_date" class="span1" style="width:75px"; readonly>
					
				<label for="podcast_new_url" class="podcast-new-item-label"><b>File Upload</b> - <small> 200 MB Maximum File Upload - <b> Remember This Podcast Is A <?php echo $config_items[0]['podcast_type'] ?></b></small></label>
					<div id="queue"></div>
					<input id="file_upload" name="file_upload" type="file" multiple="true">
					<input type="hidden" name="podcast_new_url">
					<input type="hidden" name="podcast_new_url_hash">
					
				<label for="podcast_new_publish" class="podcast-new-item-label"><b>Publish Date</b> - <small></small></label>
				
					<select class="span2" id="podcast_new_date_year">
					
							<option value="2012">2012</option>
							<option value="2013">2013</option>
						  <option value="2014">2014</option>
						  <option value="2015">2015</option>
						  <option value="2016">2016</option>
						  <option value="2017">2017</option>
					  
					</select>
					
					<select class="span2" id="podcast_new_date_month">
					
					  <option value="01">Jan</option>
					  <option value="02">Feb</option>
					  <option value="03">Mar</option>
					  <option value="04">Apr</option>
					  <option value="05">May</option>
					  <option value="06">Jun</option>
					  <option value="07">Jul</option>
					  <option value="08">Aug</option>
					  <option value="09">Sep</option>
					  <option value="10">Oct</option>
					  <option value="11">Nov</option>
					  <option value="12">Dec</option>
					  
					</select>
					
					<select class="span2" id="podcast_new_date_day">
					
					  <option value="01">01</option>
					  <option value="02">02</option>
					  <option value="03">03</option>
					  <option value="04">04</option>
					  <option value="05">05</option>
					  <option value="06">06</option>
					  <option value="07">07</option>
					  <option value="08">08</option>
					  <option value="09">09</option>
					  <option value="10">10</option>
					  <option value="11">11</option>
					  <option value="12">12</option>
					  <option value="13">13</option>
					  <option value="14">14</option>
					  <option value="15">15</option>
					  <option value="16">16</option>
					  <option value="17">17</option>
					  <option value="18">18</option>
					  <option value="19">19</option>
					  <option value="20">20</option>
					  <option value="21">21</option>
					  <option value="22">22</option>
					  <option value="23">23</option>
					  <option value="24">24</option>
					  <option value="25">25</option>
					  <option value="26">26</option>
					  <option value="27">27</option>
					  <option value="28">28</option>
					  <option value="29">29</option>
					  <option value="30">30</option>
					  <option value="31">31</option>

					</select>
					

					  <label class="checkbox" style="margin:10px 0 20px 0;">
						<input type="checkbox" id="bind-todays-date-radio" name="bind-todays-date-radio">Click Here To Use Todays Date 
					  </label>
					
				<label for="podcast_new_keywords" class="podcast-new-item-label"><b>Podcast Specific Keywords</b> - <small>*Leave Empty To User Global Keywords</small></label>
					<input type="text" name="podcast_new_keywords" class="span9">
					
				<button class="btn span9" id="new-podcast-submit-button" style="margin-left:0 !important;">Submit New Podcast</button>

			</form>
		
		</div>
	

	</div>
	
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
		// Add Strip tag function to String Prototype
		String.prototype.stripHTML = function(){
			// What a tag looks like
			var matchTag = /<(?:.|\s)*?>/g;
			// Replace the tag
			return this.replace(matchTag, "");
		};
	
		// Check the input and generate confirmation form.
		function form_check_podcast(){

			// Remove all content from the global light box.
			$('#lightbox_new > .inner').html('');
			// Set Vars.
			var podcast_new_title, podcast_url, podcast_new_publish, podcast_new_keywords;
			// JS Validation, this is just to ensure that what the user sees is related to the server, once submitted the data is sanitised anyway.
			podcast_new_title = $('input[name=podcast_new_title]').val();
			podcast_url = $('input[name=podcast_new_url]').val();
			podcast_new_publish = $('input[name=podcast_new_publish]').val();
			podcast_new_keywords = $('input[name=podcast_new_keywords]').val();
			// move progress bar
			$('#progress_main_bar').remove();
			// If a title for the podcast has not been set then we will use the recursive name
			if(!podcast_new_title) podcast_new_title = '';
			// Is no local keywords are set then we will use the global
			if(!podcast_new_keywords) podcast_new_keywords = global_vars_php['global_podcast_keywords'];
			// Set the time and date that the podcast should have.
			var js_date_picker = new Date($('#podcast_new_date_year').val() ,$('#podcast_new_date_month').val() - 1, $('#podcast_new_date_day').val());
			// Check that the date given has been convereted into a valid JS date object
			if(Object.prototype.toString.call(js_date_picker) == '[object Date]'){
				
			}
			else return false;
			// Now we know that the date object can be partially trusetd we will pass it into the submit variable.
			podcast_new_publish = $('#podcast_new_date_year').val() + '-' + $('#podcast_new_date_month').val()  + '-' + $('#podcast_new_date_day').val();
			// if there is not a specific name given for this opdcast them we simply user the Iterator 
			if(!podcast_url){
				// If not all of the variable have been submitted then we simply Call an error and return false;
				alert("You Need To Attach A File To Upload!");
				return false;
			}
			if(!podcast_new_publish || podcast_new_publish == '2012-01-01'){
				// If not all of the variable have been submitted then we simply Call an error and return false;
				alert("You Have Not Entered A Valid Date!");
				return false;
			}
			
				$('.fade-out').fadeTo('slow',0.2);
				$('#lightbox_new').css('display','block');
				$('#lightbox_new').fadeTo('slow',1);
				$('#lightbox_new > .inner').html();
				// Contruct WYSIWYG View for data submit
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Title</div>');
				
				if(typeof podcast_new_title === 'undefined'){
					$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php.global_podcast_title + ' #0' + global_vars_php['global_podcast_next_number'] + '</div>');
				}
				else{
					$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_title + '</div>');
				}
				// The File name of the mp3 that has already been uploaded to the temp folder.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast MP3 File Name</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_url + '</div>');
				// The Selected Publish Date
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Publish Date</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_language'] + '</div>');
				// the Selected Podcast Language.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Language</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + podcast_new_publish + '</div>');
				// The Global podcast subtitles.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Subtitle</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_subtitle'] + '</div>');
				// The Global podcast Summary.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Summary</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_summary'] + '</div>');
				// The Global podcast Description.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Description</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_description'] + '</div>');
				// The Global Podcast User email.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Owner Email</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_owner_email'] + '</div>');
				// The Global podcast keyword selection
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Keywords</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_keywords'] + '</div>');
				// The Global Podcast Categories.
				$('#lightbox_new > .inner').append('<div class="podcast-new-item-label">Podcast Categories</div>');
				$('#lightbox_new > .inner').append('<div class="add-new-podcast-item">' + global_vars_php['global_podcast_categories'] + '</div>');
				// Hash the MP3 File name to be uploaded, this is simply another methods of authenticating the file name, this will be used in conjunction
				// with a number of other measrues the find the file, and the name is alwayaed hashed to prevent teh user from finding there file easily.
				var url_hash = hex_md5(podcast_url);
				window.scrollTo(0, 0);
				// Add Submit buttons to the page
				$('#lightbox_new > .inner').append('<button type="button" class="btn btn-danger danger-submit" id="new_podcast_confirm_submit">Add New Podcast</button>');
				$('#lightbox_new > .inner').append('<button type="button" class="btn danger-submit" id="new_podcast_confirm_cancel">Cancel</button>');
				// jQuery Bind event click to the submit button, prevent event bubbeling.
				$('#new_podcast_confirm_submit').bind('click' , function(){	
					// AJAX call to the add podcast script.
					$.ajax({
						url: "<?php $config_array['server_root'] ?>upload/addpodcast.php",
						type: 'POST',
						data: { podcast_new_title : podcast_new_title , podcast_new_url : podcast_url, podcast_new_url_hash: url_hash , podcast_new_publish : podcast_new_publish },
						success: function(data, textStatus, request){
							// If the upload is sucessful them alert this to the user and reload to the view all page
							alert('Sucess, The Podcast Has Been Added, You Will Now Be Redirected To The Home Page !');
							window.location = "/viewall";
						},
						error: function(data, textStatus, request){
							// If there was an error then restore to the home page
							alert("Error Uploading Podcast | " + data.responseText);
							$('#new_podcast_confirm_submit').unbind('click');
							$('.fade-out').fadeTo('slow',1);
							$('#lightbox_new').fadeTo('slow',0);
							$('#lightbox_new').css('display','none');
						}
					});
				});
				// Bind The Cancel Button, This will remove the form from view.
				$('#new_podcast_confirm_cancel').bind('click' , function(){	
					$(this).unbind('click');
					$('#new_podcast_confirm_submit').unbind('click');
					$('.fade-out').fadeTo('slow',1);
					$('#lightbox_new').fadeTo('slow',0);
					$('#lightbox_new').css('display','none');
				})
		}
		
		
		$(function() {
			
			$('#podcast_new_title_date').attr('placeholder', $('#podcast_new_date_day').val()  + '-' + $('#podcast_new_date_month').val() + '-' + $('#podcast_new_date_year').val());
			// Bind click to Lightbox close button.
			$('#lightbox_new > .close').bind('click' , function(event){	
				$('.fade-out').fadeTo('slow',1);
				$('#lightbox_new').fadeTo('slow',0);
				$('#lightbox_new').css('display','none');
			})
			// Bind click to podcast primary submit button.
			$('#new-podcast-submit-button').bind('click' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			// Bind submit to podcast primary submit button, just incase this method is given prefrence in a browser.
			$('#new-podcast-submit-button').bind('submit' , function(event){
				form_check_podcast();
				event.preventDefault();
				return false;
			})
			
			// Password Checking, Bind on focus out, will inform user if there passwords dont match
			$('#podcast_new_date_year').bind('focusout', function(){
				$('#podcast_new_title_date').attr('placeholder', $('#podcast_new_date_day').val()  + '-' + $('#podcast_new_date_month').val() + '-' + $('#podcast_new_date_year').val());
			})
			$('#podcast_new_date_day').bind('focusout', function(){
				$('#podcast_new_title_date').attr('placeholder', $('#podcast_new_date_day').val()  + '-' + $('#podcast_new_date_month').val() + '-' + $('#podcast_new_date_year').val());
			})
			$('#podcast_new_date_month').bind('focusout', function(){
				$('#podcast_new_title_date').attr('placeholder', $('#podcast_new_date_day').val()  + '-' + $('#podcast_new_date_month').val() + '-' + $('#podcast_new_date_year').val());
			})
			$('#bind-todays-date-radio').bind('click', function(){
				if(document.getElementById('bind-todays-date-radio').checked){
					$('#podcast_new_date_day').attr('readonly', 'readonly');
					$('#podcast_new_date_month').attr('readonly', 'readonly');
					$('#podcast_new_date_year').attr('readonly', 'readonly');
					$('#podcast_new_date_day').css('display', 'none');
					$('#podcast_new_date_month').css('display', 'none');
					$('#podcast_new_date_year').css('display', 'none');
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
					if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
					$("#podcast_new_date_day").val(dd);
					$("#podcast_new_date_month").val(mm);
					$("#podcast_new_date_year").val(yyyy);
					$('#podcast_new_title_date').attr('placeholder', dd  + '-' + mm + '-' + yyyy);
				}
				else{
					$('#podcast_new_date_day').removeAttr('readonly');
					$('#podcast_new_date_month').removeAttr('readonly');
					$('#podcast_new_date_year').removeAttr('readonly');
					$('#podcast_new_date_day').css('display', 'inline');
					$('#podcast_new_date_month').css('display', 'inline');
					$('#podcast_new_date_year').css('display', 'inline');
				}
			})
			
			<?php $timestamp = time();?>
			

			// Start uploadify jQuery plugin.
			$('#file_upload').uploadify({
			
					'formData'     : {
						'timestamp' : '<?php echo $timestamp;?>',
						'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
						'allowImageMain'	:	'yes'
					},
					'width'    			: 		700,
					'buttonText' 		: 		'Click Here To Select A Podcast From Your Computer',
					'progressData' 		: 		'speed',
					'removeCompleted' 	: 		false,
					'removeTimeout' 	: 		5,
					'fileSizeLimit' 	: 		'200MB',
					'method'   			: 		'post',
					'queueSizeLimit' 	: 		1,
					'fileTypeExts' 		:		'*.mp4; *.mp3;',
					'swf'      			: 		'<?php echo $config_array['server_root']; ?>public/flash/uploadify.swf',
					'uploader' 			: 		'<?php echo $config_array['server_root']; ?>upload/upload.php',
					'overrideEvents' 	: 		'',
					'onUploadSuccess' 	: function(file, data, response) {
						alert('The file ' + file.name + ' was successfully uploaded !');
						$('input[name=podcast_new_url]').val(file.name);
						$('input[name=podcast_new_url_hash]').val(hex_md5(file.name));
					},
					'onUploadError' : function(file, errorCode, errorMsg, errorString) {
						alert('ERROR - Unable To Upload File !');
					},
					'onSelectError' : function() {
						alert('ERROR - Unable To Add That File To The Que');
					},
					'onCancel' : function(file) {
						alert('File Was Removed From THe Que !');
					},

			});
			
		})
	
	</script>