## Cấu hình để dùng được `getenv()` với `phpdotenv`
phpdotenv có thể cấu hình để chỉ nạp biến vào $_ENV, $_SERVER, hoặc cả getenv() — và điều này phụ thuộc vào cách bạn gọi Dotenv::create() hoặc Dotenv::createImmutable().

🔍 Cụ thể:
1. getenv() lấy từ hệ thống OS env
getenv() lấy biến môi trường từ hệ điều hành (hoặc từ các biến được set thông qua putenv()).

Nếu .env không được load đúng cách, hoặc nếu cấu hình dotenv không gọi putenv(), thì getenv() sẽ không thấy giá trị.

2. $_ENV là một mảng siêu toàn cục
phpdotenv luôn đẩy biến từ file .env vào $_ENV (nếu không bị putenv tắt).

PHP không tự động đồng bộ $_ENV và getenv().

✅ Cách đảm bảo getenv() hoạt động:
```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); // Mặc định: chỉ nạp vào $_ENV, không gọi putenv()
```
➡️ Nếu bạn muốn getenv() hoạt động, bạn phải bật putenv bằng cách dùng createMutable() hoặc cấu hình thêm:

```php
$dotenv = Dotenv\Dotenv::createMutable(__DIR__); // Dùng được getenv()
$dotenv->load();
```

## Sự khác biệt giữa `createImmutable()` và `createMutable()`

| Đặc điểm                             | `createImmutable()` | `createMutable()`                 |
| ------------------------------------ | ------------------- | --------------------------------- |
| Có thể **ghi đè** biến đã tồn tại?   | ❌ Không             | ✅ Có                              |
| Ghi biến vào `$_ENV`                 | ✅ Có                | ✅ Có                              |
| Ghi biến vào `$_SERVER`              | ❌ Mặc định không    | ❌ Mặc định không                  |
| Ghi biến vào `getenv()` (`putenv()`) | ❌ Không             | ✅ Có                              |
| Dùng cho môi trường production?      | ✅ An toàn           | ⚠️ Cẩn thận (có thể gây xung đột) |

🔹 `createImmutable()`

Không cho phép ghi đè nếu biến đã tồn tại (trong $_ENV, getenv(), v.v.).

Không gọi `putenv()` nên `getenv('VAR_NAME')` không thấy gì.

Ưu tiên tính an toàn và ổn định, thường dùng trong production.

```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo $_ENV['APP_NAME']; // ✅ Có
echo getenv('APP_NAME'); // ❌ Không thấy
```
🔸 `createMutable()`
Cho phép ghi đè các biến môi trường đã tồn tại.

Gọi `putenv()` để set biến vào `getenv()` → `getenv('VAR')` hoạt động.

Dễ bị ghi đè sai nếu nhiều nơi set cùng biến.

```php
$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

echo $_ENV['APP_NAME']; // ✅ Có
echo getenv('APP_NAME'); // ✅ Có luôn
```

Nếu dùng `createImmutable()` mà vẫn muốn dùng `getenv()`, bạn có thể thủ công ghi thêm:

```php
putenv("APP_NAME=".$_ENV['APP_NAME']);
```