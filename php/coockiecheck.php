<?php
	session_start();					
	
	if(empty($_SESSION['userId']) || empty($_SESSION['userName'])
		|| !isset($_SESSION['userId']) || !isset($_SESSION['userName'])){
		
		if(!isset($_COOKIE['userId']) || !isset($_COOKIE['userName'])){
			header("Location: ../pages/login.php");
		} else {
			$_SESSION['userId'] = $_COOKIE['userId'];
			$_SESSION['userName'] = $_COOKIE['userName'];
			$_SESSION['userPicture'] = $_COOKIE['userPicture'];
		}
	}
	$userId = $_SESSION['userId'];
	$userName = $_SESSION['userName'];	
	$userPicture = $_SESSION['userPicture'];
?>