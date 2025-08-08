<?php
session_start();
$pageTitle = "About";
$pageDesc = "Learn more about our website and its features";
require './templates/header.php';
?>
<link rel="stylesheet" href="./css/style.css">
<section class="lesson-masthead text-center py-5 bg-light">
    <div class="container">
        <h1 class="display-4 fw-bold">About This Website</h1>
        <p class="lead mt-3">
            Our website is designed to showcase a fully functional CRUD system built with
            <strong>PHP, MySQL, HTML5, and CSS3</strong>.
            It allows users to register, log in, upload their profiles, and manage content securely.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-6">
                <h2 class="fw-bold">Core Features</h2>
                <ul class="list-unstyled mt-3">
                    <li>✔ User Registration and Authentication</li>
                    <li>✔ Secure Password Handling with Hashing</li>
                    <li>✔ User Profile Image Upload</li>
                    <li>✔ Dashboard with User Management</li>
                    <li>✔ Content Creation, Editing, and Deletion</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">Technology Stack</h2>
                <p class="mt-3">
                    The system is built using:
                </p>
                <ul class="list-unstyled">
                    <li><strong>Backend:</strong> PHP (OOP + PDO for Database Connection)</li>
                    <li><strong>Frontend:</strong> HTML, CSS, Bootstrap 5</li>
                    <li><strong>Database:</strong> MySQL (Secure & Scalable)</li>
                </ul>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="fw-bold text-center">Our Mission</h2>
                <p class="text-center mt-3">
                    We aim to provide a simple yet powerful demonstration of modern web programming
                    principles. This project is ideal for beginners learning how to integrate front-end
                    and back-end technologies effectively.
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="fw-bold text-center">Future Enhancements</h2>
                <p class="text-center mt-3">
                    Planned features include role-based admin access, advanced content management,
                    RESTFUL API integration, and improved security layers.
                </p>
            </div>
        </div>
    </div>
</section>

<?php require './templates/footer.php'; ?>
