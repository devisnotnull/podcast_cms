<?php 

	$sessioninit = session::__getInstance();
	if(!$sessioninit::ses_auth_root()) die("Not Authorised");

	$isNavHomeActive = true;
	$db_connect = database_instance::__getInstance();
	$podcast_items = $db_connect->query("SELECT * FROM podcast_config");
	
	
?>

	<div class="row">
	
		<div class="span9">
			<div class="page-header">
				<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"  ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
				<h1>All Available Podcasts</h1>
			</div>
		</div>
		
	</div>
	
	<?php if($podcast_items): ?>
	
	
			<div class="row" style="margin-bottom:10px !important; padding-bottom:10px !important; border-bottom:2px solid #EEE;">
			
				<div class="span2"></div>
				<div class="span3"><h3>Podcast Name</h3></div>
				<div class="span3"><h3>External URL</h3></div>
				<div class="span4"><h3>Podcast Link</h3></div>
			
			</div>

		<?php foreach($podcast_items as $podcast) : ?>
	
			<div class="row" style="margin-bottom:10px !important; padding-bottom:10px !important; border-bottom:2px solid #EEE;">
			
				<div class="span2"><img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$podcast['podcast_config_id']}&percent_width=10"  ?>" style="min-height:100px;" /></div>
				<div class="span3"><?php echo $podcast['podcast_title'] ?></div>
				<div class="span3"><?php echo $podcast['podcast_link'] ?></div>
				<div class="span4"><a href="<?php echo $config_array['serverAddress'] ?>podcasts-out/?podcastname=<?php echo $podcast['podcast_podcast_loc'] ?>"><?php echo $podcast['podcast_podcast_loc'] ?></a></div>
			
			</div>
		
		<?php endforeach; ?>
		
	<?php else:  ?>
	
		<div class="span12">
		
			<h1>There Are No Podcasts !</h1>
			
		</div>
		
	<?php endif; ?>
		
	
