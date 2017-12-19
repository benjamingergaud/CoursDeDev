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
					$subject="Confirmation de votre inscription";
					$content="Bonjour $name $lastName\n Bienvenue sur CoursDeDev, ton compte est créé tu peux dès à présent interagir avec les autres membres et nous contacter en cas de problème ! ";
					$userMail = $userSession->get_email();
					$headers = "From: gergaud.benjamin@gmail.com " . "\r\n" .
						'Reply-To: gergaud.benjamin@gmail.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
					ini_set("sendmail_from","gergaud.benjamin@gmail.com");
					mail("$userMail",$subject,$content,$headers);
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
