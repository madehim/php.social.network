<?php
	session_start();
	include 'includes/session.php';
	require_once('includes/class-query.php');
	require_once('includes/class-insert.php');
	
	if ( !empty ( $_POST ) ) {
		if ( $_POST['type'] == 'add_sub' ) {
			$add_sub = $insert->add_subscriber($_POST['user_id'], $_POST['friend_id']);
		}
		
		if ( $_POST['type'] == 'add_friend'){
			$add_friend = $insert->add_friend($_POST['user_id'], $_POST['friend_id']);
			$add_friend = $insert->add_friend($_POST['friend_id'], $_POST['user_id']);
			$remove_sub = $insert->remove_subscriber($_POST['user_id'], $_POST['friend_id']);
		}
		
		if ($_POST['type'] == 'remove_sub' ) {
			$remove_sub = $insert->remove_subscriber($_POST['user_id'], $_POST['friend_id']);
		}
		
		if ( $_POST['type'] == 'remove_friend' ) {
			$remove_friend = $insert->remove_friend($_POST['user_id'], $_POST['friend_id']);
			$add_sub = $insert->add_subscriber($_POST['friend_id'], $_POST['user_id']);
		}
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://localhost/social/profile-view.php?uid=".$_POST['friend_id']);
		exit();
	}
	
	$logged_user_id = $_SESSION['userid'];
	
	if ( !empty ( $_GET['uid'] ) ) {
		$user_id = $_GET['uid'];
		$user = $query->load_user_object($user_id);
		
		if ( $logged_user_id == $user_id ) {
			$mine = true;
		}
	} else {
		$user = $query->load_user_object($logged_user_id);
		$mine = true;
	}

	$friends = $query->get_friends($logged_user_id);
	$subscribe = $query->get_own_subscribe($logged_user_id);
	$subs = $query->get_subscribe($logged_user_id);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
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
							<?php if ( !$mine ) {?>
								<li role="presentation"><a href="profile-view.php">View Profile</a></li>
							<?php } else { ?>
								<li role="presentation" class="active"><a href="profile-view.php">View Profile</a></li>
							<?php } ?>
							<li role="presentation"><a href="friends-list.php">Friends List</a></li>
							<li role="presentation"><a href="messages-inbox.php">Messages</a></li>
							<li role="presentation"><a href="feed-view.php">View Feed</a></li>
							<li role="presentation"><a href="profile-edit.php">Edit Profile</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-6">
					<h1>View Profile</h1>
					<?php 
						if ($mine) {$path = "images/".$logged_user_id.".jpg";}
						else {$path = "images/".$user_id.".jpg";}
						if (file_exists($path)) {
							 ?><img src="<?php echo $path; ?>" class="img-rounded"   width="250" height="350"> <?php
						}
					?>
					<p>Name: <?php echo $user->user_nicename; ?></p>
					<p>Email Address: <?php echo $user->user_email; ?></p>
					<p>Info: <?php echo $user->user_info; ?> </p>
					<?php if ( !$mine ) { ?>
						<?php if ( !isset($friends[0]) || !in_array($user_id, $friends) ) { 
							if ( !isset($subscribe[0]) || !in_array($user_id, $subscribe)){
								if ( !isset($subs[0]) || !in_array($user_id, $subs)) {
								?>
								<p>
									<form method="post">
										<input name="user_id" type="hidden" value="<?php echo $logged_user_id; ?>" />
										<input name="friend_id" type="hidden" value="<?php echo $user_id; ?>" />
										<input name="type" type="hidden" value="add_sub" />
										<input type="submit" class="btn btn-primary pull-right" value="Add as Friend" />
									</form>
								</p>
								<?php } else { ?>
								<p>
									<form method="post">
										<input name="user_id" type="hidden" value="<?php echo $logged_user_id; ?>" />
										<input name="friend_id" type="hidden" value="<?php echo $user_id; ?>" />
										<input name="type" type="hidden" value="add_friend" />
										<input type="submit" class="btn btn-primary pull-right" value="Add as Friend" />
									</form>
								</p>
								
							<?php 
							} } else {
							?>
							<p>
								<form method="post">
									<input name="user_id" type="hidden" value="<?php echo $logged_user_id; ?>" />
									<input name="friend_id" type="hidden" value="<?php echo $user_id; ?>" />
									<input name="type" type="hidden" value="remove_sub" />
									<input type="submit" class="btn btn-primary pull-right" value="Remove Subscribe" />
								</form>
							</p>	
							
						<?php } } else { ?>
							<p>
								<form method="post">
									<input name="user_id" type="hidden" value="<?php echo $logged_user_id; ?>" />
									<input name="friend_id" type="hidden" value="<?php echo $user_id; ?>" />
									<input name="type" type="hidden" value="remove_friend" />
									<input type="submit" class="btn btn-primary pull-right" value="Remove Friend" />
								</form>
							</p>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>