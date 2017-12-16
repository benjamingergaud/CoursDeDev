<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 18/11/2017
 * Time: 13:47
 */

class CoursesModel
{
	function getCourses($subject){
		$db = new Database();
		$result = $db->fetchAll("SELECT cours.id,content,cour_date,users.pseudo,cours.title 
							FROM cours 
							JOIN category ON cours.category_id=category.id
							LEFT JOIN users ON cours.user_id = users.id
							WHERE category.title=?",[$subject]);
		return $result;
	}
	function getCoursesBySearch($title){
		$db = new Database();
		$like = "%".$title."%";
		$result = $db->fetchAll("SELECT cours.id,content,cour_date,users.pseudo,cours.title,category.title AS category
							FROM cours 
							JOIN category ON cours.category_id=category.id
							LEFT JOIN users ON cours.user_id = users.id
							WHERE cours.title LIKE ?",[$like]);
		return $result;
	}
	function getCour($courId){
		$db = new Database();
		$result = $db->fetchOne("SELECT cours.id,content,cour_date,pseudo,title, category_id 
							FROM cours 
							LEFT JOIN users ON cours.user_id = users.id
							WHERE cours.id=?",[$courId]);
		return $result;
	}
	function addCour($content , $category_id , $title , $user_id){
		$db = new Database();
		$db->query("INSERT INTO cours (category_id,content,cour_date,title,user_id) VALUE(?,?,NOW(),?,?) " , [$category_id, $content, $title , $user_id]);

	}
	function deleteCour($courId){
		$db = new Database();
		$db->query("DELETE FROM cours WHERE id=?",[$courId]);
	}
	function getAll(){
		$db = new Database();
		$result = $db->fetchAll("SELECT cours.id,content,cour_date,pseudo,cours.title ,category.title AS category, category_id
							FROM cours 
							JOIN category ON cours.category_id=category.id
							LEFT JOIN users ON cours.user_id = users.id");
		return $result;
	}
	function updateCourse($courseId , $content , $category_id ,$title){
		$db = new Database();
		$db->query("UPDATE cours SET content = ? , category_id = ? , title =? WHERE id=?",[$content,$category_id,$title,$courseId]);
	}

}