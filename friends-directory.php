<?php
	session_start();
	include 'includes/session.php';
	require_once('includes/class-query.php');
	
	$logged_user_id = $_SESSION['userid'];
	$user = $query->load_user_object($logged_user_id);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Members Directory</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
	</head>
	<body>
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
				
				<p class="navbar-text navbar-right">Signed in as <a href="/social/profile-view.php?uid=<?php echo $logged_user_id; ?>" class="navbar-link"><?php echo $user->user_nicename; ?></a></p>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
				<form method="post" action="searchscr.php" class="navbar-form navbar-right" >
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
			<div class="row" >
				<div class="col-sm-2">
					<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
						<ul class="nav nav-pills nav-stacked">
							<li role="presentation"><a href="profile-view.php">View Profile</a></li>
							<li role="presentation"><a href="friends-list.php">Friends List</a></li>
							<li role="presentation"><a href="messages-inbox.php">Messages</a></li>
							<li role="presentation"><a href="feed-view.php">View Feed</a></li>
							<li role="presentation"><a href="profile-edit.php">Edit Profile</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-6">
					<h1 class="text-center">Members Directory</h1>
					<?php $query->do_user_directory(); ?>
				</div>
			</div>
		</div>
	</body>
</html>