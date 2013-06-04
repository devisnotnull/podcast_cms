<?php 

	/*****

		GMG PODCAST MANAGEMENT
		vesrsion V1
		Requires PDO DB Class
		ALTERED FOR GMG PODCAST CMS
		Delete Page.

	*****/
	
	require_once('/home/content/m/e/d/mediatpc/library/core.php');
	
	$isNavDeleteActive = true;
	
	$item_to_delete = (isset($_GET['podcast_id'])) ? $_GET['podcast_id'] : null ;

	if($item_to_delete) :
		$db_connect = database_instance::__getInstance();
		$podcast_to_delete = $db_connect->query("SELECT * FROM podcast_items WHERE podcast_id = $item_to_delete");
		$db_connect->rowCount();
	else:
		$item_to_delete = false;
	endif;
?>

	<!-- Include Our Header -->
	<?php require_once($config_array['default_header_loc']) ?>
	<!-- Include Our Header End -->
	
	
	<div class="row" style="margin-bottom:10px;">
	
		
		<?php if($item_to_delete == false || $podcast_to_delete == false) : ?>
		
			<div class="span12">
				<h1>Unable To Locate That Podcast</h1>
			</div>

		<?php endif; ?>

	</div>
	
	
	
	<!-- Include Our Footer -->
	<?php require_once($config_array['default_footer_loc']) ?>
	<!-- Include Our Footer End -->