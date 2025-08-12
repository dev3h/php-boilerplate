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

## Thực hiện truy vấn với PDO
### Truy vấn SELECT
```php
$stmt = $pdo->query('SELECT * FROM users'); // ✅ đã tự động execute()
return $stmt->fetchAll(PDO::FETCH_ASSOC);
```
- `stmt` là viết tắt của từ "statement", đại diện cho một câu lệnh SQL đã được chuẩn bị.

✅ 1. $pdo->query($sql)
Hàm `query()` là một phương thức của đối tượng PDO trong PHP.

📌 Mục đích:
Thực thi một câu SQL đơn giản (thường là SELECT, không có tham số ràng buộc).

Trả về một PDOStatement đại diện cho tập kết quả.
```php
$stmt = $pdo->query("SELECT * FROM users");
```
- `query()` sẽ tự động thực thi câu lệnh SQL mà không cần gọi thêm execute().
- Nhưng chỉ nên dùng `query()` khi bạn không có tham số truyền vào. Nếu có tham số thì dùng `prepare()` và `bindParam()` mới an toàn.

✅ 2. $stmt->fetchAll(PDO::FETCH_ASSOC)

Hàm fetchAll() lấy tất cả dữ liệu từ kết quả trả về.

🔍 PDO::FETCH_ASSOC nghĩa là:
Kết quả trả về là một mảng liên kết (associative array).

Chỉ chứa các key là tên cột, không có key số.

🧠 Ví dụ:
Giả sử bảng users có dữ liệu:
| id | name  |
| -- | ----- |
| 1  | Alice |
| 2  | Bob   |
Giá trị:
```php
[
  ['id' => 1, 'name' => 'Alice'],
  ['id' => 2, 'name' => 'Bob']
]
```

### Truy vấn INSERT
```php
$stmt = $this->db->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
$stmt->bindParam(':name', $data['name']);
$stmt->bindParam(':price', $data['price']);
$stmt->execute();
```
- `prepare()` tạo một prepared statement — nghĩa là câu lệnh SQL được “biên dịch trước” nhưng chưa chạy, giúp:
  - Tránh SQL Injection.
  - Tăng hiệu suất khi chạy nhiều lần với dữ liệu khác nhau.
- :name và :price là named placeholders — các biến tạm để bạn bind dữ liệu vào sau.
- `bindParam()` gắn dữ liệu từ biến PHP vào placeholder SQL.
- Ở đây:
    - :name → lấy giá trị từ $data['name'].
    - :price → lấy giá trị từ $data['price'].
- bindParam gắn tham chiếu, nghĩa là nếu bạn thay đổi giá trị $data['name'] sau khi bind, thì khi execute() nó sẽ dùng giá trị mới nhất.
- `execute()` thực thi câu lệnh SQL với các giá trị đã bind vào.