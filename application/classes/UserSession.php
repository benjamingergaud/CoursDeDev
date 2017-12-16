<?php

class UserSession {

	function __construct() {
		if(session_status() == PHP_SESSION_NONE ){
			session_start();

		}
	}

	function create($user_id, $email, $fullName,$adminStatus){

		$_SESSION['user'] = [
			'isLogged' => true,
			'user_id' => $user_id,
			'email' => $email,
			'full_name' => $fullName,
			'isAdminLogged'=>$adminStatus
		];
	}

	function destroy(){
		$_SESSION = [];
		session_destroy();
	}

	function isLogged(){
		if(!array_key_exists('user', $_SESSION) OR
			!array_key_exists('isLogged', $_SESSION['user']) OR
			!$_SESSION['user']['isLogged'] )
			return false;
		return true;
	}
	function isAdminLogged(){
		if(!array_key_exists('user', $_SESSION) OR
			!array_key_exists('isAdminLogged', $_SESSION['user']) OR
			!$_SESSION['user']['isAdminLogged'] )
			return false;
		return true;
	}

	function get_email() {
		return $_SESSION['user']['email'];
	}

	function getFullName(){
		return $_SESSION['user']['full_name'];
	}

	function get_user_id() {
		return $_SESSION['user']['user_id'];
	}



}
