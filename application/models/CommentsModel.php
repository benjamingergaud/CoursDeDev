<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 13/12/2017
 * Time: 11:22
 */

class CommentsModel
{
	function getComments($id){
		$db = new Database();
		$result = $db->fetchAll("SELECT content,comment_date, pseudo
							FROM comments
							LEFT JOIN users ON comments.user_id = users.id
							WHERE cour_id=?
							ORDER BY comment_date DESC" , [$id]);
		return $result;
	}
	function addComment($id,$content,$user_id){
		var_dump($id,$content,$user_id);
		$db = new Database();
		$db->query("INSERT INTO comments (cour_id,content,user_id,comment_date) VALUE(?,?,?,NOW())" , [$id,$content,$user_id]);
	}
}