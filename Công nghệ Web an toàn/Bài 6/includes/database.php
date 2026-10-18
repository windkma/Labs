<?php
require_once __DIR__ . '/config.php';

function connect_database($databaseName, $sqlFile)
{
    global $pageTitle, $pageClass;

    mysqli_report(MYSQLI_REPORT_OFF);

    // Bước 1: kết nối vào database cần sử dụng.
    $connection = @mysqli_connect(
        DB_HOST,
        DB_USERNAME,
        DB_PASSWORD,
        $databaseName
    );

    // Bước 2: nếu database chưa có thì tạo database rồi kết nối lại.
    if (!$connection) {
        $serverConnection = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);

        if ($serverConnection) {
            $safeDatabaseName = str_replace('`', '``', $databaseName);
            $createDatabaseSql = "CREATE DATABASE IF NOT EXISTS `$safeDatabaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

            @mysqli_query($serverConnection, $createDatabaseSql);
            mysqli_close($serverConnection);

            $connection = @mysqli_connect(
                DB_HOST,
                DB_USERNAME,
                DB_PASSWORD,
                $databaseName
            );
        }
    }

    // Bước 3: trả kết nối về cho trang đang gọi hàm.
    if ($connection) {
        mysqli_set_charset($connection, DB_CHARSET);
        return $connection;
    }

    // Không kết nối được: hiển thị hướng dẫn thay vì làm trang bị lỗi trắng.
    include __DIR__ . '/header.php';
    echo '<h2>Chưa sẵn sàng cơ sở dữ liệu</h2>';
    echo '<p>Hãy bật MySQL trong XAMPP, đảm bảo tài khoản root không có mật khẩu, và import file <code>'
        . escapeHtml($sqlFile)
        . '</code> bằng phpMyAdmin, sau đó tải lại trang.</p>';
    include __DIR__ . '/footer.php';

    exit;
}
