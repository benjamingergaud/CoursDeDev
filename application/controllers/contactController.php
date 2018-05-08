<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 19/12/2017
 * Time: 11:59
 */

class contactController
{
	private $subject;
	private $content;
	private $errors;
	public function __construct(){
		$this->errors=[];
		$this->subject="";
		$this->content="";
	}

	function init(){
		try{
			if(array_key_exists("subject",  $_POST) && array_key_exists("content" ,$_POST)){
				if(empty($_POST["subject"])||empty($_POST["content"]))
					throw new DomainException("Veuillez remplir tous les champs");
				$this->subject=$_POST["subject"];
				$this->content=str_replace("\n.", "\n..",$_POST["content"]);
				$userSession=new UserSession();
				$userMail = $userSession->get_email();
				$headers = "From: $userMail" . "\r\n" .
					'Reply-To: gergaud.benjamin@gmail.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				ini_set("sendmail_from","$userMail");
				mail("gergaud.benjamin@gmail.com",$this->subject,$this->content,$headers);

			}

			return[
				"errors"=>$this->errors
			];
		}catch (DomainException $exception){
			return[
				"errors"=>$exception->getMessage()
			];
		}
	}
}