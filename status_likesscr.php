<?php
	require_once('includes/class-query.php');
	require_once('includes/class-insert.php');
	
	session_start();
	include 'includes/session.php';
	
	
	$temp = $query->check_user_status_like($_SESSION['userid'], $_POST['status_id']);
	
	if ($temp == 0){
		$insert->add_status_like($_SESSION['userid'], $_POST['status_id']);
	} else {
		$insert->remove_status_like($_SESSION['userid'], $_POST['status_id']);
	}
	
	header('Location: http://localhost/social/feed-view.php');
?>