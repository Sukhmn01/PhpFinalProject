<?php
session_start();
$pageTitle = "About / Content";
$pageDesc = "Website content page";

require './templates/header.php';
require './inc/db.php';
require 'content_class.php';
require 'user.php';

$db = getConnection();
$contentObj = new Content($db);
$userObj = new User($db);

$contents = $contentObj->getAll();
$userImages = $userObj->getUsersWithImages();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';
    $imagePath = $_POST['image_path'] ?? null; // Selected image path from user images
    $imageDescription = $_POST['image_description'] ?? '';

    if ($id) {
        $contentObj->update($id, $title, $body, $imagePath, $imageDescription);
    } else {
        $contentObj->create($title, $body, $imagePath, $imageDescription);
    }

    header("Location: content.php");
    exit;
}
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead">
    <h1>Manage Content</h1>
</section>

<?php if (isset($_SESSION['user_id'])): ?>
    <section class="add-content mb-5">
        <h2>Add New Content</h2>
        <form method="POST" class="w-50">
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Body:</label>
                <textarea name="body" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Select Image:</label>
                <select name="image_path" class="form-control">
                    <option value="">-- Select an Image --</option>
                    <?php foreach ($userImages as $imgUser): ?>
                        <option value="<?= htmlspecialchars($imgUser['image']) ?>"><?= htmlspecialchars($imgUser['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image Description:</label>
                <input type="text" name="image_description" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Add Content</button>
        </form>
    </section>
<?php endif; ?>

<section class="existing-content">
    <h2>Existing Content</h2>
    <?php foreach ($contents as $content): ?>
        <article class="content-item mb-4 p-3 border">
            <h3><?= htmlspecialchars($content['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($content['body'])) ?></p>

            <?php if (!empty($content['image'])): ?>
                <div class="content-image mb-3">
                    <img src="<?= htmlspecialchars($content['image']) ?>" alt="Content Image" style="max-width:300px;">
                    <?php if (!empty($content['image_description'])): ?>
                        <p><em><?= htmlspecialchars($content['image_description']) ?></em></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="POST" class="mb-3 w-50">
                    <input type="hidden" name="id" value="<?= $content['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($content['title']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Body:</label>
                        <textarea name="body" class="form-control" rows="4" required><?= htmlspecialchars($content['body']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Image:</label>
                        <select name="image_path" class="form-control">
                            <option value="">-- Select an Image --</option>
                            <?php foreach ($userImages as $imgUser): ?>
                                <option value="<?= htmlspecialchars($imgUser['image']) ?>" <?= $imgUser['image'] === $content['image'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($imgUser['username']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image Description:</label>
                        <input type="text" name="image_description" class="form-control" value="<?= htmlspecialchars($content['image_description']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Content</button>
                </form>
                <form method="POST" action="delete_content.php" onsubmit="return confirm('Are you sure you want to delete this content?');">
                    <input type="hidden" name="id" value="<?= $content['id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete Content</button>
                </form>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>

<?php require './templates/footer.php'; ?>
