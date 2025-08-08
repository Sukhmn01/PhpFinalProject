<?php
session_start();
$pageTitle = "Login";
$pageDesc = "This is the login form";

require './templates/header.php';
require './inc/db.php';
require 'user.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = getConnection();
    $user = new User($db);

    $login = $user->login($_POST['username'], $_POST['password']);
    if ($login) {
        $_SESSION['user_id'] = $login['id'];
        $_SESSION['username'] = $login['username'];
        $_SESSION['success_message'] = "Logged in successfully!";
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Wrong username or password";
    }
}
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead">
    <h1>Login</h1>
</section>

<section class="errorMessageRow">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</section>

<section class="loginFormRow">
    <form method="POST" class="w-50">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
        <a href="register.php" class="btn btn-secondary">Register</a>
    </form>
</section>

<?php require './templates/footer.php'; ?>
