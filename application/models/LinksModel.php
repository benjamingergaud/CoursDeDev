<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 18/11/2017
 * Time: 13:47
 */

class LinksModel
{
	function getLinks($subject){
		$db = new Database();
		$result = $db->fetchAll("SELECT links.id,content,link_date,pseudo,links.title 
							FROM links 
							JOIN category ON links.category_id=category.id
							LEFT JOIN users ON links.user_id = users.id
							WHERE category.title=?",[$subject]);
		return $result;
	}
	function getLinksBySearch($title){
		$db = new Database();
		$like = "%".$title."%";
		$result = $db->fetchAll("SELECT links.id,content,link_date,users.pseudo,links.title,category.title AS category
							FROM links 
							JOIN category ON links.category_id=category.id
							LEFT JOIN users ON links.user_id = users.id
							WHERE links.title LIKE ?",[$like]);
		return $result;
	}
	function addLink($content , $category_id , $title , $user_id){
		$db = new Database();
		$db->query("INSERT INTO links (category_id,content,link_date,title,user_id) VALUE(?,?, NOW(),?,?) " , [$category_id, $content, $title , $user_id]);
	}
	function deleteLink($linkId){
		$db = new Database();
		$db->query("DELETE FROM links WHERE id=?",[$linkId]);
	}
	function getAll(){
		$db = new Database();
		$result = $db->fetchAll("SELECT links.id,content,link_date,pseudo,links.title ,category.title AS category , category_id
							FROM links
							LEFT JOIN users ON links.user_id = users.id 
							JOIN category ON links.category_id=category.id");
		return $result;
	}
	function getLink($linkId){
		$db = new Database();
		$result = $db->fetchOne("SELECT id,content,link_date,user_id,title, category_id 
							FROM links 
							WHERE id=?",[$linkId]);
		return $result;
	}
	function updateLink($linkId , $content , $category_id ,$title){
		$db = new Database();
		$db->query("UPDATE links SET content = ? , category_id = ? , title =? WHERE id=?",[$content,$category_id,$title,$linkId]);
	}
}