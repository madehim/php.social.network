<?php
	require_once('includes/class-query.php');
	
	session_start();
	include 'includes/session.php';
	
	$search_string = trim($_POST['search_string']);
	$search_string = strip_tags($search_string);
	$search_string = htmlspecialchars($search_string);
	
	$exp = 0;
	
	if (empty($search_string)){
		$exp = 1;
	}
	
	if ($search_string == "'"){
		$exp = 2;
	}
	
	
	
	switch($exp){
		case 0:
			$result = $query->search_by_nicename($search_string);
			$_SESSION['search_res'] = $result;
		break;
		case 1:
			$_SESSION['search_res'] = "Empty search string";
		break;
		case 2:
			$_SESSION['search_res'] = "Incorrect search string";
		break;
	}
	
	header('Location: http://localhost/social/search.php');
?>