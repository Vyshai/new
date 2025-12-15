<?php
// Centralized session configuration
// Use this file in ALL pages to ensure consistent session handling

// Get the absolute path to the root directory
// This works from any subdirectory
$root_dir = dirname(__FILE__);
$session_path = $root_dir . '/sessions';

// Create sessions directory if it doesn't exist
if (!is_dir($session_path)) {
    @mkdir($session_path, 0700, true);
}

// Set session save path
ini_set('session.save_path', $session_path);

// Configure session settings for better compatibility
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookie
ini_set('session.cookie_path', '/'); // Make cookie available for entire domain

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>