<?php
/**
 * Script kiểm tra kết nối MySQL
 * Chạy: php test_connection.php
 */

// Cấu hình kết nối (lấy từ .env hoặc điền trực tiếp)
$host = '127.0.0.1';
$port = '3306';
$database = 'vietlance';
$username = 'root';
$password = ''; // Điền mật khẩu MySQL của bạn

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✅ Kết nối MySQL thành công!\n";
    echo "Database: $database\n";
    echo "Host: $host:$port\n\n";
    
    // Kiểm tra các bảng
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠️  Chưa có bảng nào. Hãy chạy migrations:\n";
        echo "   php artisan migrate\n";
    } else {
        echo "📋 Các bảng đã có:\n";
        foreach ($tables as $table) {
            echo "   - $table\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Lỗi kết nối MySQL:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "💡 Kiểm tra:\n";
    echo "   1. MySQL đã được cài đặt và đang chạy?\n";
    echo "   2. Database '$database' đã được tạo chưa?\n";
    echo "   3. Username và password có đúng không?\n";
    echo "   4. Port MySQL có đúng không? (mặc định: 3306)\n";
}

