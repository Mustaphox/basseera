<?php
$admin_route = isset($url_parts[1]) ? $url_parts[1] : 'dashboard';

// Check Authentication
$is_logged_in = isset($_SESSION['admin_id']);

if (!$is_logged_in && $admin_route !== 'login') {
    header("Location: " . BASE_URL . "admin/login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $admin_route === 'login') {
    // Basic Auth Simulation for the prompt
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user->password)) {
        $_SESSION['admin_id'] = $user->id;
        $_SESSION['admin_name'] = $user->name;
        header("Location: " . BASE_URL . "admin/dashboard");
        exit;
    } else {
        $error = "بيانات الدخول غير صحيحة";
    }
}

if ($admin_route === 'logout') {
    session_destroy();
    header("Location: " . BASE_URL . "admin/login");
    exit;
}

// Routes
if ($admin_route === 'login') {
    require_once 'views/login.php'; // We will create this below or inline it
} else {
    require_once 'includes/admin_header.php';
    $admin_view = "views/{$admin_route}.php";
    if (file_exists("admin/" . $admin_view)) {
        require_once $admin_view;
    } else {
        echo "<div class='container mt-5'><h3>الصفحة غير موجودة</h3></div>";
    }
    // No footer for admin to keep it simple, or a very basic one
    echo "</div></div><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script><script src='https://unpkg.com/lucide@latest'></script><script>lucide.createIcons();</script></body></html>";
}
