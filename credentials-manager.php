<?php

class CredentialsManager {
    private $mysqli;
    
    public function __construct(mysqli $mysqli) {
        session_start();
        
        $this->mysqli = $mysqli;
    }
    
    public function login($username, $password) {
        if($this->isLoggedIn()) {
            return false;
        }
        
        $stmt = $this->mysqli->prepare("SELECT * FROM user WHERE nev = ? AND jelszo = ? LIMIT 1;");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        
        if($stmt->affected_rows === 0) {
            return false;
        }
        
        $_SESSION['user'] = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }
    
    public function logout() {
        if(!$this->isLoggedIn()) {
            return;
        }
        
        session_destroy();
    }

    public function register($username, $password) {
        if($this->isLoggedIn()) {
            return false;
        }

        $stmt = $this->mysqli->prepare("INSERT INTO user (`nev`, `jelszo`, `jog`) VALUES (?, ?, 'user');");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if($stmt->affected_rows === 0) {
            return false;
        }

        $this->login($username, $password);
        header("Location: index.php");
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }
    
    public function isAdmin() {
        if(!$this->isLoggedIn()) {
            return false;
        }
        
        return $_SESSION['user']['jog'] === "admin";
    }
    
    public function getLoggedInUser() {
        return $_SESSION['user'];
    }
}