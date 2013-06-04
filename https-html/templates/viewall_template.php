<?php 

	$isNavHomeActive = true;
	$db_connect = database_instance::__getInstance();
	$podcast_items = $db_connect->query("SELECT * FROM podcast_shows WHERE podcast_config_id = {$config_cms_setup['podcast_config_id']} ORDER BY podcast_publish_date DESC");
	$db_connect->rowCount();
	
?>

	<div class="row">
	
		<div class="span9">
			<div class="page-header">
				<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10"  ?>" style="height:40px; float:left; margin-right:20px; border-radius:5px;"/>
				<h1><?php echo $config_cms_setup['podcast_title'] ?></h1>
			</div>
		</div>
		
		<div class="span3" class="height:inherit; text-align:right;">
			<div class="btn-group" style="float:right;">
				<a class="btn dropdown-toggle" data-toggle="dropdown">Order On Itunes - Date DESC <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
				<!-- dropdown menu links -->
				</ul>
			</div>
		</div>
		
	</div>
	
	<div class="row" style="margin-bottom:10px;">

		<?php if($podcast_items): ?>
		
			<?php foreach($podcast_items as $podcast) : ?>

				<div class="span2" style="margin-bottom:15px; border-radius:5px;">
				
					<div style="position:relative;  border-radius:5px; margin-bottom:-8px margin-left:-3px; margin-right:-3px; box-shadow: 0px 5px #000000;">
					
						<img src="<?php echo $config_array['serverAddress'].$config_array['imageAddress']."imgrender.php?podcast_id={$config_cms_setup['podcast_config_id']}&percent_width=10" ?>" style="border-radius:inherit; min-height:150px;"/>
						<div style="position:absolute; top:0px; left:0px; background:#000000; color:#FFFFFF; margin:5px; opacity:0.8; font-weight:bold; padding:5px;"><?php echo $podcast['podcast_title'] ?></div>
						<div style="position:absolute; bottom:0px; left:0px; background:#000000; color:#FFFFFF; margin:5px; opacity:0.8;font-weight:bold;  padding:5px;"><?php echo $podcast['podcast_publish_date'] ?></div>
						
					</div>
						
					<div style="border:1px solid #CCC; padding:15px 0 10px 15px; font-weight:bold; font-size:0.8em ;  border-radius:5px;">
					<!-- Podcast Options Button -->
						<div class="btn-group">
						  <button class="btn dropdown-toggle btn-danger" data-toggle="dropdown">
							Edit Podcast
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu">
							<!-- dropdown menu links -->
							<li><a href="<?php echo $config_array['server_root'] ?>config">Edit</a></li>
							
						  </ul>
						</div>
					<!-- END Podcast Options Button -->						
					</div>
					
				</div>
			
			<?php endforeach; ?>
			
		<?php else:  ?>
		
			<div class="span12">
				<h1>There Are No Podcasts !</h1>
			</div>
			
		<?php endif; ?>
		
		
	</div>
