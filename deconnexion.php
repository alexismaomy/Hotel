<?php
	require_once('session.php');
	require_once('class.client.php');
	$client_logout = new CLIENT();
	
	if($client_logout->is_loggedin()!="")
	{
		$client_logout->redirect('home.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$client_logout->doLogout();
		$client_logout->redirect('index.php');
	}
