<?php 

	$isNavHomeActive = true;
	$db_connect = database_instance::__getInstance();
	$podcast_items = $db_connect->query("SELECT user_name, user_account_assoc, user_access_level FROM podcast_users");
	
	$sessioninit = session::__getInstance();
	if(!$sessioninit::ses_auth_root()) die("Not Authorised");
	
?>

	<div class="row">
	
		<div class="span9">
			<div class="page-header">
			<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"  ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
			<h1>All Available Podcasts <small> - Ordered By Signup Date</small></h1>
			<small>
			</div>
		</div>
		
	</div>
	
	
		<div class="row" style="margin-bottom:10px !important; padding-bottom:10px !important; border-bottom:2px solid #EEE;">
		
			<div class="span2"></div>
			<div class="span3"><h3>Username</h3></div>
			<div class="span3"><h3>Podcast Account</h3></div>
			<div class="span4"><h3>User Account type</h3></div>
		
		</div>
	
		<?php if($podcast_items): ?>
	
			<?php foreach($podcast_items as $podcast) : ?>
			
				<div class="row" style="margin-bottom:10px;">
				
					<div class="span2"><img src="<?php echo $config_array['server_root']; ?>public/img/user_def.jpg" /></div>
					<div class="span3"><?php echo $podcast['user_name'] ?></div>
					<div class="span3"><?php echo $podcast['user_account_assoc'] ?></div>
					<div class="span4"><?php echo $podcast['user_access_level'] ?></div>
				
				</div>
			
			<?php endforeach; ?>
			
		<?php else:  ?>
		
			<div class="span12">
				<h1>Fatal Error - No Users - Check Database Connection !</h1>
			</div>
			
		<?php endif; ?>
		
		
