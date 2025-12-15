<?php
$session_path = __DIR__ . '/sessions';
if (!is_dir($session_path)) {
    mkdir($session_path, 0700);
}
ini_set('session.save_path', $session_path);
session_start();

$_SESSION['test'] = 'Working!';
echo "Session set. <a href='check_session_test.php'>Check if it persists</a>";
?>