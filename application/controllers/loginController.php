<?php
	class loginController{
		function init() {

			try{


				if (array_key_exists("login" , $_POST)){
					require_once "recaptchalib.php";
					$secret = "6LdsCT0UAAAAACwR6eScYv2gtB5pMO_QhNOEEjy2";
					$response = null;
					$reCaptcha = new ReCaptcha($secret);
					if ($_POST["g-recaptcha-response"]!="") {
						$response = $reCaptcha->verifyResponse(
							$_SERVER["REMOTE_ADDR"],
							$_POST["g-recaptcha-response"]
						);

					} else {
						throw new DomainException("Veuillez cliquer la case pour valider que vous n'êtes pas un robot");
					}
					$this->connect($_POST['mail'],$_POST['password']);
				}
				return [
					'errors' =>[],
				];
			}catch (DomainException $exception){
				return [
					'errors' => [$exception->getMessage()]
				];
			}
		}

		function connect($mail , $pass){
			if (empty($mail) || empty($pass))
				throw new DomainException("Tous les champs doivent être complétés");

			$userModel = new UserModel();
			$user_infos = $userModel->login($mail, $pass);
			global $userSession;
			$userSession=new UserSession();
			$userSession->create($user_infos['id'], $mail, $user_infos['fullname'],$user_infos['status']);
			header('Location: index.php');
			//todo créer un formfilter en js pour controller les formulaires
		}
	}



