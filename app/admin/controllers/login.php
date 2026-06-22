<?php
if (is_admin_logged_in()) admin_redirect('/');

$error = '';
$username = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $u = get_admin_by_username($username);
    if ($u && password_verify($password, $u['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $u['id'];
        admin_redirect('/');
    }
    $error = 'Incorrect username or password.';
}
render_admin('login', ['title' => 'Sign in', 'chrome' => false, 'error' => $error, 'username' => $username]);
