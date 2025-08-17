# argv

Trong PHP, biến $argv là một mảng đặc biệt (special array) được PHP cung cấp khi bạn chạy script ở chế độ CLI (Command Line Interface). Nó chứa các tham số dòng lệnh mà bạn truyền vào khi chạy file PHP.

Cách hoạt động của $argv

$argv[0] → luôn chứa tên file PHP đang được chạy.

$argv[1], $argv[2], ... → chứa các đối số (arguments) mà bạn truyền thêm từ dòng lệnh.

Ví dụ

File: test.php

```php
print_r($argv);
```


Chạy lệnh:
```bash
php test.php hello world 123
```

Kết quả:

```bash
Array
(
    [0] => test.php
    [1] => hello
    [2] => world
    [3] => 123
)
```

Một số điểm cần lưu ý

$argv chỉ tồn tại khi PHP chạy ở CLI hoặc khi trong php.ini có bật register_argc_argv = On.

Biến $argc là số lượng phần tử trong $argv. Ví dụ ở trên, $argc = 4.

$argv thường dùng khi bạn viết script chạy nền, cronjob, tool CLI (không phải code chạy qua web server).

👉 Ví dụ ứng dụng:

```php
if ($argc < 2) {
    echo "Usage: php script.php <name>\n";
    exit(1);
}

$name = $argv[1];
echo "Hello, $name!\n";
```

Chạy:

```bash
php script.php Nam
```

Output:
```bash
Hello, Nam!
```

# glob

Hàm glob() trong PHP được dùng để tìm kiếm file hoặc thư mục theo một mẫu (pattern) nhất định, rất tiện khi bạn muốn lấy danh sách file trong một thư mục theo định dạng nào đó.

🔹 Cú pháp
```php
glob(string $pattern, int $flags = 0): array|false
```

$pattern: chuỗi mẫu (pattern) để tìm, có thể dùng ký tự đại diện giống như trong shell (*, ?, [...]).

$flags: (tùy chọn) – ảnh hưởng đến cách trả về kết quả.

🔹 Ví dụ cơ bản
```php
$files = glob("*.php");  // lấy tất cả các file có đuôi .php trong thư mục hiện tại
print_r($files);
```


Kết quả (giả sử thư mục có index.php, test.php):
```php
Array
(
    [0] => index.php
    [1] => test.php
)
```

🔹 Một số pattern thường dùng

"*.txt" → tất cả file .txt

"data/*.csv" → tất cả file .csv trong thư mục data

"*.{jpg,png,gif}" kèm GLOB_BRACE → tất cả ảnh jpg, png, gif

Ví dụ:

```php
$images = glob("*.{jpg,png,gif}", GLOB_BRACE);
```

🔹 Các flags thường dùng
- GLOB_MARK → thêm dấu / vào cuối tên thư mục.
- GLOB_ONLYDIR → chỉ lấy thư mục, bỏ qua file.
- GLOB_NOSORT → không sắp xếp kết quả (mặc định là có sắp xếp).
- GLOB_BRACE → cho phép mẫu dạng {a,b,c}.

Ví dụ chỉ lấy thư mục:

```php
$dirs = glob("*", GLOB_ONLYDIR);
```

🔹 So sánh với **scandir()**

scandir() → lấy tất cả file và thư mục trong một folder, rồi bạn phải tự lọc.

glob() → có sẵn bộ lọc theo pattern, tiện hơn khi chỉ cần loại file cụ thể.