<?php
// Use centralized session config from parent directory
require_once "../session_config.php";

echo "<!DOCTYPE html><html><head><title>Session Debug</title><style>
body { font-family: Arial; padding: 20px; background: #f4f6f9; }
.debug { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
.success { background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; }
.error { background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; }
</style></head><body>";

echo "<div class='debug'>";
echo "<h2>🔍 Session Debug Information</h2>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Session Save Path:</strong> " . session_save_path() . "</p>";
echo "<p><strong>Current File:</strong> " . __FILE__ . "</p>";
echo "<p><strong>Session Data:</strong></p>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "</div>";

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='error'>";
    echo "<h2>❌ You are not logged in!</h2>";
    echo "<p>Session is active but no user data found.</p>";
    echo "<p><a href='../login.php' style='background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";
    echo "</div>";
    exit();
}

// Check role
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff') {
    echo "<div class='error'>";
    echo "<h2>⚠ Access Denied</h2>";
    echo "<p>Your role: " . htmlspecialchars($_SESSION['role']) . "</p>";
    echo "</div>";
    exit();
}
?>

<div class="success">
    <h1>🎉 SUCCESS! You Are Logged In!</h1>
    <p style="font-size: 18px; margin-top: 10px;">Dashboard access working perfectly!</p>
</div>

<div class="debug">
    <h2>✅ Your Account Information:</h2>
    <ul style="font-size: 16px; line-height: 2;">
        <li><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></li>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['full_name']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
        <li><strong>Role:</strong> <span style="background: #667eea; color: white; padding: 5px 15px; border-radius: 5px;"><?php echo strtoupper($_SESSION['role']); ?></span></li>
    </ul>
</div>

<div class="debug">
    <h2>📱 Quick Links:</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
        <a href="dashboard.php" style="display: block; padding: 20px; background: white; text-align: center; text-decoration: none; color: #333; border-radius: 8px; border: 2px solid #667eea;">
            <div style="font-size: 30px;">📊</div>
            <strong>Full Dashboard</strong>
        </a>
        <a href="manageOrders.php" style="display: block; padding: 20px; background: white; text-align: center; text-decoration: none; color: #333; border-radius: 8px; border: 2px solid #667eea;">
            <div style="font-size: 30px;">📦</div>
            <strong>Manage Orders</strong>
        </a>
        <a href="manageServices.php" style="display: block; padding: 20px; background: white; text-align: center; text-decoration: none; color: #333; border-radius: 8px; border: 2px solid #667eea;">
            <div style="font-size: 30px;">💅</div>
            <strong>Manage Services</strong>
        </a>
        <a href="manageUsers.php" style="display: block; padding: 20px; background: white; text-align: center; text-decoration: none; color: #333; border-radius: 8px; border: 2px solid #667eea;">
            <div style="font-size: 30px;">👥</div>
            <strong>Manage Users</strong>
        </a>
        <a href="../logout.php" style="display: block; padding: 20px; background: #dc3545; text-align: center; text-decoration: none; color: white; border-radius: 8px;">
            <div style="font-size: 30px;">🚪</div>
            <strong>Logout</strong>
        </a>
    </div>
</div>

</body>
</html>