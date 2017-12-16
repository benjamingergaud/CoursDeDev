<?php
	class registerController{
		function init(){
			try{
				if(array_key_exists("inscription" , $_POST)){
					extract($_POST);
					$userModel = new UserModel();
					$user_id = $userModel->create($lastName,$name,$mail,$password,$pseudo);
					$userSession= new UserSession();
					$userSession->create($user_id,$mail,$name." ".$lastName,false);
					header('Location: index.php');

				}
				return[
					'errors'=>[]
				];
			}catch (DomainException $exception){
				return[
					'errors'=> $exception->getMessage()
				];
			}
		}
	}
