## ✅ PDO là gì?
PDO là một lớp (class) trong PHP dùng để kết nối và thao tác với CSDL theo cách an toàn, linh hoạt và hiện đại. Nó hỗ trợ nhiều hệ quản trị CSDL như: MySQL, PostgreSQL, SQLite, SQL Server...

## So sánh Pdo và Mysqli
| Tiêu chí              | PDO | MySQLi            |
| --------------------- | --- | ----------------- |
| Đa hệ quản trị DB     | ✅   | ❌ (chỉ MySQL)     |
| Prepared Statements   | ✅   | ✅                 |
| Hướng đối tượng chuẩn | ✅   | Có, nhưng kém hơn |
| Fetch dạng object     | ✅   | ✅                 |
| Giao dịch             | ✅   | ✅                 |
| Tính linh hoạt        | ✅   | ❌                 |

## Tạo kết nối với PDO
```php
try {
    // chuỗi DNS (data source name) để kết nối đến CSDL
    // utf8 (hoặc utf8mb4 nếu hỗ trợ emoji).
    $pdo = new PDO('mysql:host=localhost;dbname=test
;charset=utf8', 'username', 'password');
    // Nếu có lỗi, PDO sẽ ném lỗi (throw Exception) thay vì chỉ trả về false
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Kết nối thất bại: ' . $e->getMessage();
}
```
- `PDO::ATTR_ERRMODE`	Là hằng số đại diện cho “chế độ xử lý lỗi”
- `PDO::ERRMODE_EXCEPTION`	Là giá trị thiết lập, nghĩa là “ném lỗi Exception khi có lỗi xảy ra”
- Khi thiết lập chế độ này, nếu có lỗi xảy ra trong quá trình thực thi câu lệnh SQL, PDO sẽ ném một ngoại lệ (exception) thay vì chỉ trả về false. Điều này giúp bạn dễ dàng xử lý lỗi hơn.