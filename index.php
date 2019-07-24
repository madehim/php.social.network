<?php
		session_start();
		require_once('includes/class-query.php');
		?>
<!DOCTYPE html>

<html>
	<head>
		
		<title>Home</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		
	</head>
	<body>
		<?php 
		if (isset($_SESSION['registration']))
		{
			if ($_SESSION['registration'] != "Регистрация прошла успешно") {
				?>  <div class="alert alert-danger" role="alert"><?php  echo $_SESSION['registration']; ?> </div>  <?php 
			}
			else
			{
				?>  <div class="alert alert-success" role="alert"><?php  echo $_SESSION['registration']; ?> </div>  <?php 
			}
			unset($_SESSION['registration']);
		}
		
		
		
		if (empty($_SESSION['login']) || ($_SESSION['login'] != "ok")) {
			if ($_SESSION['login'] == "Ошибка аутентификации"){
				?>  <div class="alert alert-danger" role="alert"><?php echo $_SESSION['login']; ?> </div>  <?php 
				unset($_SESSION['login']);
			}
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form method="post" action = "registration.php" class="form-horizontal">
							<h1 class="text-center"> Registration </h1>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="user_email">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="user_pass">
								</div>
							</div>
							<div class="form-group">
								<label for="nicenamelb" class="col-sm-3 control-label">Name</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="nicenamelb" placeholder="Name" name="user_nicename">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-default">Registration</button>
								</div>
							</div>
					</form>
				</div>
				<div class="col-sm-4 col-sm-offset-3">
					<form method="post" action = "login.php" class="form-horizontal">
							<h1 class="text-center">Login</h1>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="user_email">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="user_pass">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-default">Login</button>
								</div>
							</div>
					</form>
				</div>	
			</div>
		</div>
		<?php
		}
		else
		{
			if ($_SESSION['login'] == "ok")
			{
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Brand</a>
				</div>
				
				<ul class="nav navbar-nav">
					<li><a href="/social">Home</a></li>
					<li><a href="friends-directory.php">Member Directory</a></li>
				</ul>
				<form method="post" action="includes/session-end.php" class="navbar-form navbar-right">
					<button type="submit" class="btn btn-default"> Logout </button>
				</form>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
				<form method="post" action="search.php" class="navbar-form navbar-right" >
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name="search_string">
						<button type="submit" class="btn btn-default">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
					</div>
				</form>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<div class="jumbotron">
						<h2 class="text-center">Hello, <?php $temp = $query->load_user_object($_SESSION['userid']); echo $temp->user_nicename;?>! </h2>
						<p class="text-success text-center"><a href="profile-view.php">View Profile</a></p>
						<p class="text-success text-center"><a href="friends-list.php">Friends List</a></p>
						<p class="text-success text-center"><a href="messages-inbox.php">Messages</a></p>
						<p class="text-success text-center"><a href="feed-view.php">View Feed</a></p>
						<p class="text-success text-center"><a href="profile-edit.php">Edit Profile</a></p>
						<p class="text-success text-center"><a href="searchscr.php">Search</a></p>
						<p class="text-success text-center"><a href="friends-directory.php">Member Directory</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php 
			}
			
		}
		
		?>
	</body>
</html>