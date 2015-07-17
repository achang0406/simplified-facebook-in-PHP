<?php
session_start();
require_once('new_connection.php');

//login
if(isset($_POST['action']) && $_POST['action']=='login')
{
	login($_POST);
	die();
} 
//sign up
if(isset($_POST['action']) && $_POST['action']=='sign_up')
{
	sign_up($_POST);
	die();
}
//post a message
if(isset($_POST['action']) && $_POST['action']=='message')
{
	message($_POST);
	die();
}
//delete a message
if(isset($_POST['action']) && $_POST['action']=='delete')
{
	delete($_POST);
	die();
}
//post a comment
if(isset($_POST['action']) && $_POST['action']=='comment')
{
	comment($_POST);
	die();
}
//logout
if(isset($_POST['action']) && $_POST['action']=='logout')
{
	session_destroy();
	header('location:index.php');
	die();
}

function login($post)
{
	//escape!
	// global $connection;
	// $esc_email=mysqli_real_escape_string($connection,$post['email']);
	// $esc_password=mysqli_real_escape_string($connection, $post['password']);
	// $query="SELECT * FROM users WHERE users.password='{$esc_password}' AND users.email='{$esc_email}'";

	//none escape!
	$query="SELECT * FROM users WHERE users.password='{$post['password']}' AND users.email='{$post['email']}'";

	$user=fetch($query);

	//validation Begins
	if(COUNT($user)>0)
	{
		foreach($user as $row)
		{
			$_SESSION['user']=$row;
		}
		header('location:the_wall.php');
		die();
	}
	//Validation Ends


	header('location:index.php');
	die();
}

function sign_up($post)
{
	echo 'sign_up';
	$_SESSION['errors']=array();
	//validation Begins
	if(empty($_POST['first_name']))
	{
		$_SESSION['errors']['first_name']=TRUE;
	}
	if(empty($_POST['last_name']))
	{
		$_SESSION['errors']['last_name']=TRUE;
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$_SESSION['errors']['email']=TRUE;
	}
	if(strlen($_POST['password'])<6)
	{
		$_SESSION['errors']['password']=TRUE;
		$_SESSION['errors']['confirm_password']=TRUE;
	}
	if($_POST['confirm_password'] != $_POST['password'])
	{
		$_SESSION['errors']['confirm_password']=TRUE;
	}


	if(!empty($_SESSION['errors'])){
		//error astrix
		$_SESSION['errors']['error']='<span>*</span>';
	} else {
		//Sign in successful!
		$query="INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['email']}', '{$post['password']}', NOW(), NOW())";
		run_mysql_query($query);
		$_SESSION['success']='New ninja created!';
		header('location:index.php');
		die();
	}
	//Validation Ends
	header('location:index.php');
	die();
}

function message($post)
{
	if(empty($post['message']))
	{
		header('location:the_wall.php');
		die();
	}

	$query="INSERT INTO messages (user_id, message, created_at, updated_at) VALUES ('{$_SESSION['user']['id']}', '{$post['message']}', NOW(), NOW())";
	run_mysql_query($query);
	// var_dump($_SESSION['user']);


	header('location:the_wall.php');
	die();
}

function delete($post)
{

	$query="DELETE FROM messages WHERE id='{$post['message_id']}' AND user_id='{$post['user_id']}'";

	run_mysql_query($query);
	header('location:the_wall.php');
	die();
}

function comment($post)
{
	if(empty($post['comment']))
	{
		header('location:the_wall.php');
		die();
	}
	$query="INSERT INTO comments (user_id, message_id, comment, created_at, updated_at) VALUES ('{$_SESSION['user']['id']}', '{$post['message_id']}', '{$post['comment']}', NOW(), NOW())";
	run_mysql_query($query);
	// var_dump($_SESSION['user']);


	header('location:the_wall.php');
	die();
}

?>