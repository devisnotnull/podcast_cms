	<?php

		$sessioninit = session::__getInstance();
		$sessioninit::ses_logout();

		header('Location: /login');
		
	?>