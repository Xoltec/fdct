<?php
	
	require 'global.php';
	
	if(isset($_SESSION['b_username']) && isset($_SESSION['b_password'])){
		session_destroy();
		header('Location: index.php');
	}
	
?>