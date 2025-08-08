<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$pageTitle = "Dashboard";
$pageDesc = "List of registered users";

require './templates/header.php';
require './inc/db.php';
require 'user.php';

$db = getConnection();
$user = new User($db);
$users = $user->getAll();
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead">
    <h1>View Users</h1>
</section>

<section class="welcomeMessage">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
</section>

<section class="dashboard-intro mb-4">
    <p>This dashboard shows all registered users along with their uploaded profile images.</p>
    <p>Use the Edit and Delete buttons to manage the users.</p>
</section>

<section class="userList">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="5" class="text-center">No users found.</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?php
                        $imgPath = __DIR__ . '/' . $u['image'];
                        if (!empty($u['image']) && file_exists($imgPath)): ?>
                            <img src="<?= htmlspecialchars($u['image']) ?>" alt="User Image" style="max-width: 50px; max-height: 50px;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="update.php?id=<?= $u['id'] ?>">Edit</a>
                        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</section>

<?php require './templates/footer.php'; ?>
