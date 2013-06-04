<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Heavenbet Podcast Managment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="<?php echo $config_array['server_root'] ?>public/css/bootstrap.min.css" rel="stylesheet">
	
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="../assets/js/html5shiv.js"></script>
		<![endif]-->

	<!-- INC JQUERY TO ALLOW FOR INTERMIN DOC READIES -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	
	
	<style>
		.container{ position:relative !important; }
		#lightbox_new{
			opacity:0;
			display:none;
			box-shadow:#000000 0px 0px 15px;
			z-index:9999;
			overflow:scroll;
			position:absolute;
			top:0;
			left:0;
			width:940px;
			background:#FFFFFF;
			border-radius:5px; 
			border:#DDDDDD 1px solid;
		}
		#lightbox_new > .close{
			position:absolute;
			top:10px;
			right:10px;
			font-weight:bold;
			font-size:1.3em;
			color:red;
		}
		#lightbox_new > .inner{
			padding:25px;
			line-height:1.5em;
		}
		
		.fade-out{
			opacity:1;
		}
		
		.podcast_main_sub_img{
			margin-bottom:30px;
		}
		
		.podcast_main_sub_cat{
			padding:3px 0 3px 3px;
			border-top:1px solid #003366;
			font-size:0.9em;
			
			background-color:#CCFFCC;
		}
		
		.add-new-podcast-item{
			font-size:1em;
			margin-bottom:5px;
			
		}
		
		.podcast-new-item-label{
			border-bottom:1px solid #CCC;
			font-weight:bold;
			margin-bottom:15px;
			
		}
		.danger-submit{
			margin-top:20px;
			margin-bottom:5px;
			margin-right:20px;
			padding:20px;
		}

		.label{
			min-height:auto !important;
			background:#003366;
			padding:7px;
		}
	</style>
	
	
  </head>

  <body>
 

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/viewall"><img src="<?php echo $config_array['server_root'] ?>public/img/podcast-favi.png" style="margin-top:-4px;" /> Heavenbet Podcast CMS</a>
          <div class="nav-collapse in collapse" style="height: auto;">
            <ul class="nav">
			
			<?php if($sessioninit::ses_check_login()): ?>
			
				<li class="<?php if(isset($isNavHomeActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>viewall">View All</a></li>
				<li class="<?php if(isset($isNavNewActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>new">Add New</a></li>
				<li class="<?php if(isset($isNavConfigActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>config">Config</a></li>
			 
				<?php if($sessioninit::ses_auth_root() == 100): ?>

				  <li class="dropdown">
			
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Advanced Options<b class="caret"></b></a>
						
						<ul class="dropdown-menu">
				
							<li class="<?php if(isset($isNavNewPodcastActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>podcast_create">Create New Podcast</a></li>
							<li class="<?php if(isset($isNavNewPodcastActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>all_podcasts">All Podcasts</a></li>
							<li class="<?php if(isset($isNavNewPodcastActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>all_users">All Users</a></li>
							<li class="<?php if(isset($isNavNewPodcastActive)) echo 'active' ?>"><a href="<?php echo $config_array['server_root'] ?>stats">Stats</a></li>
						</ul>
					</li>
				<?php endif; ?>

				
			  <li style="font-size:0.8em;"><a href="logout"> Logout - Welcome Back <?php echo $_SESSION['username'] ?></a></li>
			  
			 <?php endif; ?>
			 
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<div class="container">
	
	
	<div id="lightbox_new" style="display:none;">
	
		<div class="close">
			X
		</div>
		
			<div class="page-header" style="margin:25px 25px 0 25px;">
			
			  <h1><img src ="<?php echo $config_array['server_root'] ?>public/img/podcast-icon-large.png" style="float:left; height:40px; margin-right:15px;" /><div id="podcast-lightbox-main-message">Podcast Management Console</div><small id="podcast-lightbox-secondary-message"></small></h1>
			  
			</div>
		
		<div class="inner">
			
			<div id="progress_main_bar"><img src="<?php echo $config_array['server_root'] ?>public/img/loading.gif" style="height:70%;"/></div>
		
		</div>
		
	</div>
		
    