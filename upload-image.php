<?php
	require_once('includes/class-insert.php');
	
	session_start();
	include 'includes/session.php';
	
	if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$_POST['profile_id'].".jpg");
		 $_SESSION['image_upload'] = "Success";
      }
	  else{
		$_SESSION['image_upload'] = $errors;
	  }
   }
	
	header('Location: http://localhost/social/profile-edit.php');
?>