<?php
// Model Product: Quản lý dữ liệu sản phẩm Laptop bằng PDO Prepared Statements (Chống SQL Injection)

function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
    return $stmt->fetchAll();
}

function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
    $stmt->execute([(int)$id]);
    return $stmt->fetch();
}

function searchProducts($keyword) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $searchTerm = "%" . $keyword . "%";
    $stmt->execute([$searchTerm, $searchTerm]);
    return $stmt->fetchAll();
}

function addProduct($name, $categoryId, $price, $sl, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO products (name, category_id, price, sl, description) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $categoryId, $price, $sl, $description]);
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([(int)$id]);
}

function getAllCategories() {
    global $pdo;
    return $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
}
