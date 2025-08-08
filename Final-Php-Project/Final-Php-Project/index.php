<?php
session_start();
$pageTitle = "Home";
$pageDesc = "Welcome to our professional content management platform";

require './templates/header.php';
?>
<link rel="stylesheet" href="./css/style.css">
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">Welcome to <span class="highlight"> Data manager</span></h1>

        <?php if (isset($_SESSION['username'])): ?>
            <p class="hero-subtitle">Hi, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>! Glad to see you back.</p>
            <p class="hero-description">
                Empower yourself by managing your profile, creating captivating content, and connecting with your audience effortlessly.
            </p>
            <div class="hero-buttons">
                <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>

            <section class="features-section">
                <h2>Explore Your Capabilities</h2>
                <div class="features-grid">
                    <div class="feature-box">
                        <h3>User Profile</h3>
                        <p>Update your personal details and profile image with ease.</p>
                    </div>
                    <div class="feature-box">
                        <h3>Content Management</h3>
                        <p>Create, edit, and organize articles enriched with images and descriptions.</p>
                    </div>
                    <div class="feature-box">
                        <h3>Secure Access</h3>
                        <p>Advanced authentication ensuring your data privacy and security.</p>
                    </div>
                    <div class="feature-box">
                        <h3>Admin Controls</h3>
                        <p>Admins can monitor users and moderate content to maintain quality.</p>
                    </div>
                </div>
            </section>

        <?php else: ?>
            <p class="hero-subtitle">Discover a powerful platform to create and manage content like a pro.</p>
            <p class="hero-description">
                Join us today by registering or log in to unlock the full potential of your digital presence.
            </p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-success">Register Now</a>
                <a href="login.php" class="btn btn-primary">Login</a>
            </div>

            <section class="info-section">
                <h2>Why Choose YourContentHub?</h2>
                <ul>
                    <li>Intuitive and user-friendly interface designed for all skill levels.</li>
                    <li>Rich text and media content creation tools.</li>
                    <li>Robust security with hashed passwords and session management.</li>
                    <li>Responsive design for seamless use on all devices.</li>
                </ul>
            </section>
        <?php endif; ?>
    </div>
</section>

<?php require './templates/footer.php'; ?>
