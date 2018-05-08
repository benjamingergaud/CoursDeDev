<?php
	class adminController{
		private $action;
		private $courses;
		private $links;
		function __construct(){
			$this->action="";
			$this->courses=[];
			$this->links=[];
		}


		function init(){
			try{

				// Si une action est fournie dans la queryString pour definir quoi afficher dans la vue
				if(array_key_exists("action" , $_GET)){
					$this->action = $_GET['action'];
					//Recuperation de la liste des cours en cas de gestion des cours
					if($this->action=="manageCourse"){
						$coursesModel=new CoursesModel();
						$this->courses = $coursesModel->getAll();
					}
					//Recuperation de la liste des liens en cas de gestion des liens
					if($this->action=="manageLink"){
						$linksModel = new LinksModel();
						$this->links = $linksModel->getAll();
					}
				}



				// Si un formulaire d'ajout de cours est envoyé
				if(array_key_exists("addCourse",$_POST)){
					$userSession = new UserSession();
					$user_id = $userSession->get_user_id();
					$category = $_POST['category'];
					if(empty($_POST['content'])||empty($_POST['category'])||empty($_POST['title']))
						throw new DomainException("Veuillez remplir tous les champs");
					$coursesModel = new CoursesModel();
					$coursesModel->addCour($_POST['content'],$category,$_POST['title'],$user_id);

				}

				// Si un formulaire d'ajout de lien est envoyé
				if(array_key_exists("addLink",$_POST)){
					$userSession = new UserSession();
					$user_id = $userSession->get_user_id();
					if(empty($_POST['content'])||empty($_POST['category'])||empty($_POST['title']))
						throw new DomainException("Veuillez remplir tous les champs");
					if(!strpos($_POST["content"],"http"))
						throw new DomainException("Le lien entré n'est pas valide");
					$linksModel = new LinksModel();
					$linksModel->addLink($_POST['content'],$_POST['category'],$_POST['title'],$user_id);
				}

				// Si une requete ajax est lancée pour la suppression d'un lien
				if (array_key_exists("ajaxDeleteLink",$_POST)){
					$linkId = $_POST['id'];
					$linksModel = new LinksModel();
					$linksModel->deleteLink($linkId);
				}

				// Si une requete ajax est lancée pour la suppression d'un cours
				if (array_key_exists("ajaxDeleteCourse",$_POST)){
					$courId = $_POST['id'];
					$coursesModel = new CoursesModel();
					$coursesModel->deleteCour($courId);
				}

				//execution de la mise a jour du cour si le formulaire est envoyé
				if (array_key_exists("updateCourse",$_POST)){
					$courseId = $_POST['courseId'];
					$coursesModel = new CoursesModel();
					$coursesModel->updateCourse($courseId, $_POST['content'] , $_POST['category'] ,$_POST['title']);
					header('Refresh: 0;url=index.php?page=admin&action=manageCourse');
				}
				//execution de la mise a jour du lien si le formulaire est envoyé
				if (array_key_exists("updateLink",$_POST)){
					$linkId = $_POST['linkId'];
					$linksModel = new LinksModel();
					$linksModel->updateLink($linkId, $_POST['content'] , $_POST['category'] ,$_POST['title']);
					header('Refresh: 0;url=index.php?page=admin&action=manageLink');
				}

				return [
					'errors'=>[],
					'action' => $this->action,
					'courses' => $this->courses,
					'links' => $this->links

				];
			}catch (DomainException $e){
				return [
					'errors' => $e->getMessage(),
					'action' => $this->action,
					'courses' => $this->courses,
					'links' => $this->links
				];
			}
		}
	}



