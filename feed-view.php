<?php
	session_start();
	include 'includes/session.php';
	require_once('includes/class-query.php');
	require_once('includes/class-insert.php');
	
	$logged_user_id = $_SESSION['userid'];
	
	if ( !empty ( $_POST ) ) {
		$status_message = trim($_POST['status_content']);
		$status_message = strip_tags($status_message);
		$status_message = htmlspecialchars($status_message);
		
		
		if (!empty($status_message)){
			$add_status = $insert->add_status($logged_user_id, $status_message);
		}
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://localhost/social/feed-view.php");
		exit();
	}
	
	$user = $query->load_user_object($logged_user_id);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>View Feed</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
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
							<li role="presentation" class="active"><a href="feed-view.php">View Feed</a></li>
							<li role="presentation"><a href="profile-edit.php">Edit Profile</a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-offset-2 col-sm-4 " >
						<h1 class="text-center">Post Status</h1>
						<form method="post">
							<input name="status_time" type="hidden" value="<?php echo time() ?>" />
							<label for="status_content">What's on your mind?</label>
							<textarea name="status_content" style="resize:none" class="form-control" rows="5"></textarea>
							<p>
								<input type="submit" class="btn btn-primary pull-right" value="Post" />
							</p>
						</form>
					</div>
				</div>
			</div>
			<div class="row center-block">
				<div class="col-sm-offset-3 col-sm-6">
					<h1 class="text-center">View Feed</h1>
					<?php $query->do_news_feed($logged_user_id); ?>
				</div>
			</div>
		</div>
	</body>
</html>