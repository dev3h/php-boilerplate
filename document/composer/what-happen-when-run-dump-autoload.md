Khi bạn chạy lệnh:

```bash
composer dump-autoload
```
Composer sẽ thực hiện các bước sau đây để tạo lại hệ thống tự động nạp (autoloading), đảm bảo rằng các class PHP trong dự án của bạn được nạp đúng cách mà không cần require thủ công.

✅ Cụ thể điều gì xảy ra?
1. 🔄 Quét lại toàn bộ thư mục theo cấu hình autoload trong composer.json
Ví dụ bạn có:

```json
"autoload": {
  "psr-4": {
    "App\\": "app/"
  }
}
```
Composer sẽ quét thư mục app/ và tạo mapping tương ứng giữa namespace App\ và các file PHP thực tế.

2. 🧾 Tạo lại (hoặc cập nhật) các file autoload trong thư mục vendor/

Cụ thể là:

| File                                    | Tác dụng                                                     |
| --------------------------------------- | ------------------------------------------------------------ |
| `vendor/autoload.php`                   | File chính bạn `require` vào `index.php` để sử dụng autoload |
| `vendor/composer/autoload_psr4.php`     | Mapping giữa namespace PSR-4 và đường dẫn thư mục            |
| `vendor/composer/autoload_classmap.php` | Bản đồ ánh xạ từ tên class → file (nếu bạn dùng `classmap`)  |
| `vendor/composer/autoload_static.php`   | Tăng hiệu suất autoload bằng cách dùng array tĩnh            |


3. 🛠️ Áp dụng khi bạn:
- Thêm hoặc đổi thư mục trong cấu hình autoload
- Thêm file PHP mới trong thư mục đã autoload
- Cập nhật tên class hoặc namespace
- Sửa đổi kiểu autoload từ psr-4 → classmap, files...

Nếu bạn không chạy composer dump-autoload sau khi thêm class mới, Composer không thể nhận ra class đó vì mapping cũ chưa cập nhật.

💡 Ví dụ:
Bạn có:

```json
"autoload": {
  "psr-4": {
    "App\\": "app/"
  }
}
```
Và bạn vừa tạo file:

```php
app/Controllers/HomeController.php
```
Nhưng nếu bạn chưa chạy:

```bash
composer dump-autoload
```
Thì khi viết:

```php
use App\Controllers\HomeController;

$home = new HomeController();
use App\Controllers\HomeController;

$home = new HomeController();
```
👉 PHP sẽ báo lỗi class không tồn tại
Vì vendor/composer/autoload_psr4.php chưa được cập nhật.
