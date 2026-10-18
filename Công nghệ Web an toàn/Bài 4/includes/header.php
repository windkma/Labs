<?php
require_once __DIR__ . '/config.php';

if (!isset($pageTitle)) {
    $pageTitle = 'Bài 4: PHP và CSDL';
}

if (!isset($pageClass)) {
    $pageClass = '';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo escapeHtml($pageTitle); ?> - Phan Thế Phong</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico">
</head>

<body class="<?php echo escapeHtml($pageClass); ?>">

<div class="container">

    <div class="student-info">
        <img src="img/avatar-phong.svg" alt="Ảnh đại diện Phan Thế Phong">
        <div><strong>Họ và tên:</strong> <?php echo escapeHtml(STUDENT_NAME); ?></div>
        <div><strong>MSSV:</strong> <?php echo escapeHtml(STUDENT_ID); ?></div>
        <div><strong>Lớp:</strong> <?php echo escapeHtml(STUDENT_CLASS); ?></div>
    </div>

    <div class="banner">
        <img src="img/banner.jpg" alt="Banner" class="banner-image">
    </div>

    <?php include __DIR__ . "/menu.php"; ?>

    <div class="main-content">
