<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Destroy the session
    session_destroy();
    // Redirect to the login page or any other page
    header("Location: sign-in.html");
    exit;
}

