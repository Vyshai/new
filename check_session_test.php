<?php
$session_path = __DIR__ . '/sessions';
ini_set('session.save_path', $session_path);
session_start();

if (isset($_SESSION['test'])) {
    echo "✅ Sessions are working! Value: " . $_SESSION['test'];
} else {
    echo "❌ Sessions are NOT working!";
}
?>