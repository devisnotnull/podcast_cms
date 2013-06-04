<?php 
	$sessioninit = session::__getInstance();
	if(!$sessioninit::ses_auth_root()) die("Not Authorised");
?>

	<h2>Total Number Of Podcast XML Downloads - Itunes Vists</h2>
	<?php
		$output = shell_exec('cat /home/nginx-html/logs/nginx/public/podcastxmlaccess.log | awk -F " " \'{a[$1]++ } END  { for (b in a) { print b, "\t", a[b] } }\'');
		echo "<pre>$output</pre>";
	?>
	<h2>Total Number Of Podcast Individual Item Downloads</h2>
	<?php
		$output = shell_exec('cat /home/nginx-html/logs/nginx/public/podcastfileaccess.log | awk -F " " \'{a[$1]++ } END  { for (b in a) { print b, "\t", a[b] } }\'');
		echo "<pre>$output</pre>";
	?>
	
	<h2>Total Server Bandwidth</h2>
	<img src="https://secure.leaseweb.com/api/network/graph/datatraffic?aid=51b6a829-651d-48f2-9cae-535becfe4715&server_pack_id=143255" />
	

