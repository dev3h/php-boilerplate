✅ 1. require __DIR__ . '/vendor/autoload.php'; khai báo ở đâu? Tại sao cần khai báo?

📌 Vị trí khai báo:

Thường được đặt ở đầu file trong các entry point như:
- index.php (nếu là ứng dụng web)
- artisan, cli.php (nếu là CLI app)
- public/index.php (Laravel)

📌 Mục đích:

Để Composer tự động load tất cả các class trong project mà bạn đã khai báo theo PSR-4/PSR-0, mà không cần phải thủ công require từng file PHP.

Load tất cả các file, class, package (nằm trong vendor/) mà Composer đã xử lý.

✅ 2. Sau khi gọi autoload.php, chuyện gì xảy ra?

```php
require_once __DIR__ . '/composer/autoload_real.php';
return ComposerAutoloaderInitfe2304a67c67916d617f1099dafb1304::getLoader();
```
➤ Giải thích dòng:
Composer tạo ra một class có tên ngẫu nhiên theo project hash:

```php
class ComposerAutoloaderInitfe2304a67c67916d617f1099dafb1304
{
    public static function getLoader()
    {
        // ...
    }
}
```
Class này nằm trong file autoload_real.php.

Phương thức getLoader() bên trong sẽ:

Load các classloader cần thiết (ClassLoader.php)

Khởi tạo các PSR-4, PSR-0 rules từ file autoload_psr4.php, autoload_psr0.php

Load các file files (nếu bạn dùng "autoload": { "files": [...] })

Trả về một instance của \Composer\Autoload\ClassLoader.

✅ 3. Cụ thể hàm getLoader() làm gì?
Trong autoload_real.php:

```php
public static function getLoader()
{
    if (null !== self::$loader) {
        return self::$loader;
    }

    require __DIR__ . '/ClassLoader.php';
    $loader = new \Composer\Autoload\ClassLoader();

    // load autoload_static.php nếu có để tối ưu hiệu năng (array map)
    $loader->setClassMapAuthoritative(true);
    $loader->register(true);

    self::$loader = $loader;
    return $loader;
}
```
- Load ClassLoader.php – đây là "bộ não" của hệ thống autoload.
- Tạo 1 instance $loader
- Gắn các namespace từ file:
	- autoload_psr4.php
	- autoload_psr0.php
	- autoload_namespaces.php (nếu có)
	- autoload_classmap.php
- Cuối cùng gọi $loader->register() để đăng ký với PHP SPL Autoloader stack.

✅ 4. Tóm tắt toàn bộ flow autoload
```js
(index.php)
    ↓
require 'vendor/autoload.php'
    ↓
vendor/autoload.php
    ↓
require vendor/composer/autoload_real.php
    ↓
ComposerAutoloaderInitXXXXX::getLoader()
    ↓
- load ClassLoader.php
- khởi tạo các map từ autoload_psr4.php, classmap,...
- return new ClassLoader instance
    ↓
PHP sẽ dùng class này để autoload tất cả class bạn viết (theo PSR-4)

```

VD: bạn có file app/Controllers/HomeController.php
Bạn chỉ cần đặt namespace đúng:

```php
namespace App\Controllers;

class HomeController {
    public function index() {
        echo 'Home Page';
    }
}
```
Và ở index.php bạn chỉ cần:

```php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->index();
```
➡️ Composer sẽ tự động tìm đến file đúng và load vào.

## Vì sao có autoload.php rồi lại còn sinh ra autoload_real.php?

Composer không gộp tất cả vì:
- Tách riêng logic để dễ quản lý và maintain
- Có thể cache lại autoload_real.php cho performance
- Tách biệt rõ ràng giữa:
	- entrypoint (autoload.php)
	- core logic (autoload_real.php)
	- config dữ liệu (autoload_psr4.php, autoload_namespaces.php,...)

