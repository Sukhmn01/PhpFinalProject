<?php
session_start();
$pageTitle = "Register";
$pageDesc = "User registration form";

require './templates/header.php';
require './inc/db.php';
require 'user.php';
require './inc/upload.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    }

    if (empty($error)) {
        $result = uploadImage('image');
        if (isset($result['error'])) {
            $error = $result['error'];
        } else {
            $imagePath = $result['path'];

            $conn = getConnection();
            $user = new User($conn);
            $register = $user->register($username, $email, $password, $imagePath);
            if ($register) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Username or email already exists";
            }
        }
    }
}
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead">
    <h1>Register User</h1>
</section>

<section class="errorMessageRow">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</section>

<section class="loginFormRow">
    <form method="POST" enctype="multipart/form-data" class="w-50">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password:</label>
            <input type="password" name="confirm" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Image:</label>
            <input type="file" name="image" accept="image/*" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-secondary">Login</a>
    </form>
</section>

<?php require './templates/footer.php'; ?>
