<?php

class Database {

    private $pdo;

    function __construct() {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    function query($sql, array $arguments = []) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);

        return $this->pdo->lastInsertId();
    }

    function fetchOne($sql, array $arguments = [], $fetchType = PDO::FETCH_ASSOC) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);
        return $query->fetch($fetchType);
    }

    function fetchAll($sql, array $arguments = [], $fetchType = PDO::FETCH_ASSOC) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);
        return $query->fetchAll($fetchType);
    }
}