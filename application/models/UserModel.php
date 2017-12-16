<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 03/12/2017
 * Time: 15:45
 */

class UserModel
{
	function create($lastName,$name,$mail,$password,$pseudo){
		$password = $this->hashPassword($password);
		$db = new Database();

		$sql = "SELECT id FROM users WHERE mail = ?";
		$result = $db->fetchOne($sql, [$mail]);
		if(!empty($result))
			throw new DomainException("Le compte associé au mail $mail existe déjà");

		$sql = "SELECT id FROM users WHERE pseudo = ?";
		$result = $db->fetchOne($sql, [$pseudo]);
		if(!empty($result))
			throw new DomainException("Pseudo déjà utilisé");


		$sql = "INSERT INTO users (last_name,name,mail,password,pseudo,register_date ) VALUES (?,?,?,?,?,NOW())";
		$lastInsertId = $db->query($sql,[$lastName,$name,$mail,$password,$pseudo]);
		return $lastInsertId;
	}

	public function login($email, $password){

		$db = new Database();

		// On fait une première requête pour savoir si un compte avec $email existe déjà
		$sql = "SELECT password, id, name, last_name,status FROM users WHERE mail = ?";
		$result = $db->fetchOne($sql, [$email]);

		// s'il n'y a pas de compte associé on renvoi une erreur
		if(empty($result))
			throw new DomainException('Utilisateur non trouvé');

		// si les mot de passes ne coincident on renvoi une erreur
		if(!$this->verifyPassword($password , $result['password']))
			throw new DomainException('Mot de passe incorrect');

		// enfin si tout va bien jusque là, on retourn les infos de l'utilisateur
		// qui seront utilisé pour remplir les données de la session
		return [
			'id' => $result['id'],
			'fullname' => $result['name'] .' '. $result['last_name'],
			'status' => $result['status']
		];
	}








	private function verifyPassword($password, $hashedPassword) {
		return crypt($password, $hashedPassword) == $hashedPassword;
	}
	private function hashPassword($password) {
		/*
		 * Génération du sel, nécessite l'extension PHP OpenSSL pour fonctionner.
		 *
		 * openssl_random_pseudo_bytes() va renvoyer n'importe quel type de caractères.
		 * Or le chiffrement en blowfish nécessite un sel avec uniquement les caractères
		 * a-z, A-Z ou 0-9.
		 *
		 * On utilise donc bin2hex() pour convertir en une chaîne hexadécimale le résultat,
		 * qu'on tronque ensuite à 22 caractères pour être sûr d'obtenir la taille
		 * nécessaire pour construire le sel du chiffrement en blowfish.
		 */
		$salt = '$2y$11$' . substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

		// Voir la documentation de crypt() : http://devdocs.io/php/function.crypt
		return crypt($password, $salt);
	}
}