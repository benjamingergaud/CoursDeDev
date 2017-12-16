<?php
	class coursesController
	{
	private $courses;
	private $cour;
	private $category;
	private $comments;
	function __construct()
	{
		$this->courses=[];
		$this->cour=[];
		$this->category="";
		$this->comments=[];
	}

		/**
		 * @return array qui contient les informations a transmettre a la vue pour etre affichées
		 * fonction qui va etre appelée par la page index
		 */
		function init(){

		try
		{
			if (array_key_exists("subject", $_GET))
			{
				$this->getCourses();
			}

			if (array_key_exists("id", $_GET)) {
				$this->getCour($_GET['id']);
				$this->getComments($_GET['id']);
			}
			if (array_key_exists("id", $_GET) && array_key_exists("comment_content", $_POST)){
				$id = $_GET['id'];
				if ($_POST["comment_content"]=="")
					throw new DomainException("Le contenu du commentaire est vide");
				$this->addComment($id,$_POST["comment_content"]);
				header("Refresh: 0;url=index.php?page=courses&id=$id");
			}
			return [
				'errors'=>[],
				'courses'=>$this->courses,
				'cour'=>$this->cour,
				'category'=>$this->category,
				'comments'=>$this->comments
			];

		}catch (DomainException $e){
			return [
				'errors'=> $e
			];
		}
	}


		/**
		 * Requete vers le coursesModel pour recuperer la liste des cours en fonction de la categorie choisie
		 */
	function getCourses(){
		$courseModel = new CoursesModel();
		$this->category = $_GET['subject'];
		$this->courses = $courseModel->getCourses($this->category);
	}


		/**
		 * @param $id du cour demandé
		 * recupère les details du cours cliqué par l'utilisateur
		 */
	function getCour($id){
		$courseModel = new CoursesModel();
		$this->cour = $courseModel->getCour($id);
	}

	function getComments($id){
		$commentsModel = new CommentsModel();
		$this->comments = $commentsModel->getComments($id);
	}
	function addComment($id, $content){
		$commentsModel = new CommentsModel();
		$user_id = $_SESSION['user']['user_id'];
		$commentsModel->addComment($id , $content , $user_id);
	}

}