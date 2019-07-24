<?php
	require_once('includes/class-query.php');
	
	//ob_start();
	
	$user_mail = trim($_POST['user_email']);
	$user_mail = strip_tags($user_mail);
	$user_mail = htmlspecialchars($user_mail);
	$user = $query->load_user_object_by_mail($user_mail);
	
	$user_pass = trim($_POST['user_pass']);
	$user_pass = strip_tags($user_pass);
	$user_pass = htmlspecialchars($user_pass);
	
	session_start();
	if (isset($user))
	{
		if ($user->user_pass == $user_pass)
		{
			
			$_SESSION['login'] = "ok";
			$_SESSION['userid'] = $user->ID;
			
			header('Location: http://localhost/social/messages-inbox.php ');
		}
	}
	
	if ($_SESSION['login'] != "ok")
	{
		$_SESSION['login'] = "Ошибка аутентификации";
		header('Location: http://localhost/social');
	}
	
	//ob_flush();
?>