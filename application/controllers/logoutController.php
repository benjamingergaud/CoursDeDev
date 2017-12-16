<?php
	class logoutController{
		function init(){

			try{
				$userSession = new UserSession();
				$userSession->destroy();
				header('Location: index.php?page=home');
				return[
					'errors'=>[]
				];

			}catch (DomainException $exception){
				return [
					'errors' => $exception->getMessage()
				];
			}

		}
	}
