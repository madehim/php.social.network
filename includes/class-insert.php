<?php
	require_once('class-db.php');
	
	if ( !class_exists('INSERT') ) {
		class INSERT {
			public function update_user($user_id, $postdata) {
				global $db;
				
				$table = 's_users';
				
				$query = "
								UPDATE $table
								SET user_email='$postdata[user_email]', user_pass='$postdata[user_pass]', user_nicename='$postdata[user_nicename]', user_info='$postdata[user_info]'
								WHERE ID=$user_id
							";

				return $db->update($query);
			}
			
			
			public function add_user($user_email, $user_pass, $user_nicename){
				global $db;
				
				$table = 's_users';
				
				$query = "
							INSERT INTO $table (user_email, user_pass, user_nicename)
							VALUES ('$user_email', '$user_pass', '$user_nicename')
							";
					
				return $db->insert($query);
			}
			
			public function add_friend($user_id, $friend_id) {
				global $db;
				
				$table = 's_friends';
				
				$query = "
								INSERT INTO $table (user_id, friend_id)
								VALUES ('$user_id', '$friend_id')
							";
				
				return $db->insert($query);
				
			}
			
			public function remove_friend($user_id, $friend_id) {
				global $db;
				
				$table = 's_friends';
				
				$query = "
								DELETE FROM $table 
								WHERE user_id in ('$user_id', '$friend_id')
								AND friend_id in ('$friend_id', '$user_id')
							";
				
				return $db->insert($query);
				
			}
			
			public function add_subscriber($user_id, $sub_id){
				global $db;
				
				$table = 's_subscribers';
				
				$query = "
								INSERT INTO $table (user_id, sub_id)
								VALUES ('$user_id', '$sub_id')
							";
				
				return $db->insert($query);
			}
			
			public function remove_subscriber($user_id, $sub_id){
				global $db;
				
				$table = 's_subscribers';
				
				$query = "
								DELETE FROM $table 
								WHERE user_id in ('$user_id', '$sub_id')
								AND sub_id in ('$sub_id', '$user_id')
							";
				
				return $db->insert($query);
			}
			
			
			public function add_status($user_id, $status_message) {
				global $db;
				
				$table = 's_status';
				
				$query = "
								INSERT INTO $table (user_id, status_time, status_content)
								VALUES ($user_id, NOW(), '$status_message')
							";
				
				return $db->insert($query);
			}
			
			public function add_status_like($user_id, $status_id) {
				global $db;
				
				$table = 's_status_like';
				
				
				$query = "
								INSERT INTO $table (status_id, user_id)
								VALUES ('$status_id', '$user_id')
							";
				
				return $db->insert($query);
				
			}
			
			public function remove_status_like($user_id, $status_id) {
				global $db;
				
				$table = 's_status_like';
				
				
				$query = "
								DELETE FROM $table
								WHERE user_id = '$user_id'
								AND status_id = '$status_id'
							";
				
				return $db->insert($query);
				
			}
			
			public function send_message($message_sender_id, $message_recipient_id, $message_subject, $message_content) {
				global $db;
				
				$table = 's_messages';
				
				$query = "
								INSERT INTO $table (message_time, message_sender_id, message_recipient_id, message_subject, message_content)
								VALUES (NOW(), '$_POST[message_sender_id]', '$_POST[message_recipient_id]', '$message_subject', '$message_content')
							";
				
				return $db->insert($query);
			}
		}
	}
	
	$insert = new INSERT;
?>