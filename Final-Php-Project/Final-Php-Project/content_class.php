<?php
class Content {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all content items
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM content ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find content by ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM content WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new content
    public function create($title, $body, $imagePath = null, $imageDescription = null) {
        $stmt = $this->conn->prepare("INSERT INTO content (title, body, image, image_description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $body, $imagePath, $imageDescription]);
    }

    // Update existing content
    public function update($id, $title, $body, $imagePath = null, $imageDescription = null) {
        if ($imagePath) {
            $stmt = $this->conn->prepare("UPDATE content SET title = ?, body = ?, image = ?, image_description = ? WHERE id = ?");
            return $stmt->execute([$title, $body, $imagePath, $imageDescription, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE content SET title = ?, body = ?, image_description = ? WHERE id = ?");
            return $stmt->execute([$title, $body, $imageDescription, $id]);
        }
    }

    // Delete content
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM content WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>

