<?php
// Model User: Quản lý người dùng, mật khẩu băm BCRYPT và phân quyền vai trò (Role)

function findUserByUsername($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    return $stmt->fetch();
}

function registerUser($username, $password, $fullname) {
    global $pdo;
    // Mã hóa mật khẩu bằng thuật toán BCRYPT mạnh mẽ
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, 'customer')");
    return $stmt->execute([$username, $hashedPassword, $fullname]);
}

function getAllUsers() {
    global $pdo;
    return $pdo->query("SELECT id, username, fullname, role FROM users ORDER BY id ASC")->fetchAll();
}

function toggleUserRole($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([(int)$id]);
    $user = $stmt->fetch();
    if ($user) {
        $newRole = ($user['role'] === 'admin') ? 'customer' : 'admin';
        $updateStmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $updateStmt->execute([$newRole, (int)$id]);
    }
    return false;
}
