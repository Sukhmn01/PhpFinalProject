<?php
// user.php

class User {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Get all users with id, username, email, image
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, username, email, image FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a user by ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, image FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Login function - verifies password and returns user info if successful
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return ['id' => $user['id'], 'username' => $user['username']];
        }
        return false;
    }

    // Register a new user, returns false if username/email already exists
    public function register($username, $email, $password, $imagePath = null) {
        // Check if username or email exists
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            return false; // user/email exists
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashed, $imagePath]);
    }

    // Update user details; update image if provided
    public function update($id, $username, $email, $imagePath = null) {
        if ($imagePath) {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, image = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $imagePath, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $id]);
        }
    }

    // Delete user by ID
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Get all users that have images uploaded (non-empty image field)
    public function getUsersWithImages() {
        $stmt = $this->conn->prepare("SELECT id, username, image FROM users WHERE image IS NOT NULL AND image != ''");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
