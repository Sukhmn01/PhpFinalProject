<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("You must be logged in to access this page!");
}

require './templates/header.php';
require './inc/db.php';
require 'user.php';
require './inc/upload.php';

$db = getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $imagePath = null;
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $uploadResult = uploadImage('image');
        if (isset($uploadResult['error'])) {
            die('Image upload failed: ' . htmlspecialchars($uploadResult['error']));
        }
        $imagePath = $uploadResult['path'];
    }

    $success = $user->update($id, $username, $email, $imagePath);
    if ($success) {
        $_SESSION['success_message'] = "User updated successfully.";
        header("Location: dashboard.php");
        exit;
    } else {
        die("Update failed.");
    }
} else {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("Invalid user ID");
    }
    $found = $user->find($_GET['id']);
    if (!$found) {
        die("User not found");
    }
}
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead">
    <h1>Edit User</h1>
</section>

<section class="loginFormRow">
    <form method="POST" enctype="multipart/form-data" class="w-50">
        <input type="hidden" name="id" value="<?= htmlspecialchars($found['id']) ?>">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($found['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($found['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Image:</label>
            <input type="file" name="image" accept="image/*" class="form-control">
            <?php if ($found['image'] && file_exists(__DIR__ . '/' . $found['image'])): ?>
                <img src="<?= htmlspecialchars($found['image']) ?>" alt="User Image" style="max-width:100px;margin-top:10px;">
            <?php endif; ?>
        </div>
        <button class="btn btn-success">Save</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</section>

<?php require './templates/footer.php'; ?>
