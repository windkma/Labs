<?php
define('STUDENT_NAME', 'Phan Thế Phong');
define('STUDENT_ID', 'AT200345');
define('STUDENT_CLASS', 'AT20');

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8mb4');

// Chuyển ký tự đặc biệt thành dạng an toàn trước khi hiển thị ra HTML.
function escapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
