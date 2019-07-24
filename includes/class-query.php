<?php
	require_once('class-db.php');

	if ( !class_exists('QUERY') ) {
		class QUERY {
			public function load_user_object($user_id) {
				global $db;
				
				$table = 's_users';
				
				$query = "
								SELECT * FROM $table
								WHERE ID = $user_id
							";
				
				$obj = $db->select($query);
				
				if ( !$obj ) {
					return "No user found";
				}
				
				return $obj[0];
			}
			
			public function load_user_object_by_mail($user_email){
				global $db;
				
				$table = 's_users';
			
				$query = "
								SELECT * FROM $table
								WHERE user_email = '$user_email'
							";
				
				$user = $db->select($query);
				
				if ( !$user ){
					return "No user found";
				}
				
				return $user[0];
			
			}
			
			public function load_all_user_objects() {
				global $db;
				
				$table = 's_users';
				
				$query = "
								SELECT * FROM $table
							";
				
				$obj = $db->select($query);
				
				if ( !$obj ) {
					return "No user found";
				}
				
				return $obj;
			}
			
			public function search_by_nicename($nicename) {
				global $db;
				
				$table = 's_users';
				
				$query = "
							SELECT * FROM $table
							WHERE user_nicename = '$nicename'
							";
				
				$search = $db->select($query);
				
				if (!$search) {
					return "No user found";
				}
				
				return $search;
			}
			
			public function get_friends_count($user_id) {
				$temp = $this->get_friends($user_id);
				$result = count($temp);
				return $result;
			}
			
			public function get_subs_count($user_id) {
				$temp = $this->get_own_subscribe($user_id);
				$result = count($temp);
				return $result;
			}
			
			public function get_subscribe_count($user_id) {
				$temp = $this->get_subscribe($user_id);
				$result = count($temp);
				return $result;
			}
			
			
			
			public function get_friends($user_id) {
				global $db;
				
				$table = 's_friends';
				
				$query = "
								SELECT ID, friend_id FROM $table
								WHERE user_id = '$user_id'
							";
				
				$friends = $db->select($query);
				if ($friends)
				{
				foreach ( $friends as $friend ) {
					$friend_ids[] = $friend->friend_id;
				}
				}
				return $friend_ids;
			}
			
			public function get_own_subscribe($user_id){
				global $db;
				
				$table = 's_subscribers';
				
				
				$query = "
							SELECT * FROM $table
							WHERE user_id = '$user_id'
							";
							
				$subscribers = $db->select($query);
				
				if ($subscribers)
				{
				foreach ( $subscribers as $sub ) {
					$subscribers_ids[] = $sub->sub_id;
				}
				}
				return $subscribers_ids;
			}
			
			public function get_subscribe($user_id){
				global $db;
				
				$table = 's_subscribers';
				
				
				$query = "
							SELECT * FROM $table
							WHERE sub_id = '$user_id'
							";
							
				$subscribers = $db->select($query);
				
				if ($subscribers)
				{
				foreach ( $subscribers as $sub ) {
					$subscribers_ids[] = $sub->user_id;
				}
				}
				return $subscribers_ids;
			}
			
			
			public function get_status_objects($user_id) {
				global $db;
				
				$table = 's_status';
				
				$friend_ids = $this->get_friends($user_id);
				
				if ( !empty ( $friend_ids ) ) {
					array_push($friend_ids, $user_id);
				} else {
					$friend_ids = array($user_id);
				}
				
				$accepted_ids = implode(', ', $friend_ids);
				
				$query = "
								SELECT * FROM $table
								WHERE user_id IN ($accepted_ids)
								ORDER BY status_time DESC
							";
				
				$status_objects = $db->select($query);
				
				return $status_objects;
			}
			
			public function get_status_likes($status_id) {
				global $db;
				
				$table = 's_status_like';
				
				$query = "
								SELECT * FROM $table
								WHERE status_id = '$status_id'
							";
				
				$temp = $db->select($query);
				
				$result = count($temp);
				
				return $result;
			}
			
			public function check_user_status_like($user_id, $status_id) {
				global $db;
				
				$table = 's_status_like';
				
				$query = "
							SELECT * FROM $table	
							WHERE status_id = '$status_id'
							AND user_id = '$user_id'
							";
				
				$result = $db->select($query);
				
				if (empty($result)) {
					$result = 0;
				} else {
					$result = 1;
				}
				
				return $result;
			}
			
			
			
			public function get_message_objects($user_id) {
				global $db;
				
				$table = 's_messages';
				
				$query = "
								SELECT * FROM $table
								WHERE message_recipient_id = '$user_id' 
								OR message_sender_id = '$user_id'
								ORDER BY message_time DESC
							";
				
				$messages = $db->select($query);
								
				return $messages;
			}
			
			public function do_user_directory() {
				$users = $this->load_all_user_objects();
				if ($users)
				{	
					?> <div class="panel-group"><?php
					foreach ( $users as $user ) { ?>
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4><a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h4>
							</div>
							<div class="panel-body">
								<p><?php echo $user->user_email; ?></p>
							</div>
						</div>
					<?php
					}
				?> </div> <?php
				}
			}
			
			public function do_sub_list($user_id){
				$subscribers = $this->get_own_subscribe($user_id);
				if ($subscribers)
				{
					?> <div class="panel-group"> <?php
					foreach( $subscribers as $sub ){
						$user = $this->load_user_object($sub)
						?>
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3><a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h3>
								</div>
								<div class="panel-body">
									<p><?php echo $user->user_email; ?></p>
								</div>
							</div>
						<?php
					}
					?> </div><?php
				}
				
			}
			
			public function do_sub_list_other($user_id){
				$subscribers = $this->get_subscribe($user_id);
				if ($subscribers)
				{
					?> <div class="panel-group"> <?php
					foreach( $subscribers as $sub ){
						$user = $this->load_user_object($sub)
						?>
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3><a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h3>
								</div>
								<div class="panel-body">
									<p><?php echo $user->user_email; ?></p>
								</div>
							</div>
						<?php
					}
					?> </div><?php
				}
				
			}
			
			public function do_friends_list($friends_array) {
				if ($friends_array)
				{
				foreach ( $friends_array as $friend_id ) {
					$users[] = $this->load_user_object($friend_id);
				}			
				?> <div class="panel-group"> <?php
				foreach ( $users as $user ) { ?>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3><a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h3>
						</div>
						<div class="panel-body">
							<p><?php echo $user->user_email; ?></p>
						</div>
					</div>
				<?php
				}
				?> </div><?php
				}
			}
			
			public function do_news_feed($user_id) {
				$status_objects = $this->get_status_objects($user_id);
					if($status_objects)
					{
					?> <div class="panel-group"> <?php
					foreach ( $status_objects as $status ) {?>
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="pull-right">
									<?php echo $status->status_time;?>
								</div>
								<?php $user = $this->load_user_object($status->user_id); ?>
								<h4><a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h4>
							</div>
							<div class="panel-body">
								<form method="post" action="status_likesscr.php">
									<input name="status_id" type="hidden" value="<?php echo $status->ID; ?>" />
									<p><?php echo $status->status_content; ?></p>
									<div class="pull-right">
										<p class="text-right"> <?php echo $this->get_status_likes($status->ID);?> </p>
										<?php $truefalse = $this->check_user_status_like($user_id, $status->ID);
										if ($truefalse == 0){?>
											<button class="btn" type="submit"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
										<?php } else {?>
											<button class="btn" type="submit"><span class="glyphicon glyphicon-thumbs-up" style="color:blue"></span> </button>
										<?php }?>
									</div>
								</form>
							</div>
						</div>
					<?php
					}
					?> </div><?php
				}
			}
			
			public function do_inbox($user_id) {
				$message_objects = $this->get_message_objects($user_id);
					if($message_objects)
					{
					?> <div class="panel-group"> <?php
					foreach ( $message_objects as $message ) {?>
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="pull-right">
									<?php echo $message->message_time?>
								</div>
								<?php 
									if ($user_id != $message->message_sender_id){
									$user = $this->load_user_object($message->message_sender_id); 
									?>
										<h4>From: <a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h4>
									<?php
									}
									else
									{
										$user = $this->load_user_object($message->message_recipient_id); 
									?>
										<h4>To: <a href="/social/profile-view.php?uid=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a></h4>
									<?php
									}
								?>
							</div>
							<div class="panel-body">
								<h4>Subject: <?php echo $message->message_subject; ?></h4>		
							</div>
							<div class="panel-footer">
								<p><?php echo $message->message_content; ?></p>
							</div>
						</div>
					<?php
					}
					?> </div><?php
				}
			}
			
			
		}
	}
	
	$query = new QUERY;
?>