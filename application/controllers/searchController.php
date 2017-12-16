<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 12/12/2017
 * Time: 11:13
 */

class searchController
{
	function init(){
		try{
			if(!array_key_exists("search" , $_GET)){
				throw new DomainException("la recherche est vide");
			}
			$search = $_GET['search'];
			$coursesModel = new CoursesModel();
			$courses = $coursesModel->getCoursesBySearch($search);
			$linksModel = new LinksModel();
			$links = $linksModel->getLinksBySearch($search);
			return[
				"errors"=>[],
				"courses" => $courses,
				"search"=>$search,
				"links"=>$links
			];
		}catch (DomainException $exception){
			return [
				"errors" => $exception->getMessage()
			];
		}

	}
}