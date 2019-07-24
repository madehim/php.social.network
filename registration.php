<?php
	session_start();
	if ($_SESSION['login'] != "ok"){
		require_once('includes/class-query.php');
		require_once('includes/class-insert.php');
		
		$user_mail = trim($_POST['user_email']);
		$user_mail = strip_tags($user_mail);
		$user_mail = htmlspecialchars($user_mail);
		
		$user = $query->load_user_object_by_mail($user_mail);
		
		if ($user == "No user found")
		{
			$exp = 0;
			
			$user_pass = trim($_POST['user_pass']);
			$user_pass = strip_tags($user_pass);
			$user_pass = htmlspecialchars($user_pass);
			
			if(empty($user_pass)){
				$exp = 1;
			}
			
			$user_nicename = trim($_POST['user_nicename']);
			$user_nicename = strip_tags($user_nicename);
			$user_nicename = htmlspecialchars($user_nicename);
			
			if(empty($user_nicename) || $user_nicename == "'"){
				$exp = 2;
			}
			
			switch($exp){
				case 0:
					$insert->add_user($user_mail, $user_pass, $user_nicename);
					$_SESSION['registration'] = "Регистрация прошла успешно";
					header('Location: http://localhost/social ');
				break;
				case 1:
					$_SESSION['registration'] = "Недопустимый пароль";
					header('Location: http://localhost/social ');
				break;
				case 2:
					$_SESSION['registration'] = "Недопустимое имя";
					header('Location: http://localhost/social ');
				break;
			}
		}
		else
		{
			$_SESSION['registration'] = "Данная почта уже использована для регистрации";
			header('Location: http://localhost/social ');
		}
	}
	else{
		header('Location: http://localhost/social ');
	}
	
?>