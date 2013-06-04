<?php 
		if(isset($_POST['username']) && isset($_POST['userpassword'])){
			if($sessioninit::ses_login( $_POST['username'] , $_POST['userpassword'] )){
				unset($_SESSION['authattempt']);
				header('Location: /login');
			}
		}
?>
	
	<?php if(!$sessioninit::ses_check_login()): ?>
	
	<form class="form-signin" action="/login" method="post" enctype="application/x-www-form-urlencoded" name="user_login">
	
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="Your Username" name="username">
        <input type="password" class="input-block-level" placeholder="Your Userpassword" name="userpassword">

        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
		
      </form>
	  
	<?php else: ?>
	
		<h2>Welcome Back - <?php echo $sessioninit::ses_get_username() ?></h2>
		
	<?php endif; ?>  
	