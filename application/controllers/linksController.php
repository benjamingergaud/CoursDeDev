<?php
class linksController{
	private $links;
	private $category;

	function __construct()
	{
		$this->links=[];
		$this->category="";
	}

	function init(){
		try{
			if(array_key_exists("subject" , $_GET)){
				$this->getLinks();
			}
			return [
				'errors'=>[],
				'links'=>$this->links,
				'category'=>$this->category
			];
		}catch (DomainException $e){
			return[
				'errors'=>$e
			];
		}
	}
	function getLinks(){
		$linksModel = new LinksModel();
		$this->category = $_GET['subject'];
		$this->links = $linksModel->getLinks($this->category);
	}
}
