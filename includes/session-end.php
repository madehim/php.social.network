<?php
	session_start();
	if ($_SESSION['login'] == true)
	{
		unset($_SESSION['login']);
		unset($_SESSION['userid']);
		unset($_SESSION);
		header('Location: http://localhost/social ');
	}
?>